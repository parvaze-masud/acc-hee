<?php

namespace App\Http\Controllers\Backend\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Repositories\Backend\Master\CustomerRepository;
use App\Repositories\Backend\Master\GodownRepository;
use App\Repositories\Backend\Master\GroupChartRepository;
use App\Repositories\Backend\Master\LegerHeadRepository;
use App\Repositories\Backend\Voucher\VoucherPurchaseReturnRepository;
use App\Repositories\Backend\Voucher\VoucherReceivedRepository;
use App\Services\Tree;
use App\Services\User\UserCheck;
use App\Services\Voucher_setup\Voucher_setup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseReturnController extends Controller
{
    private $godown;

    private $groupChartRepository;

    private $unit_branch;

    private $ledger;

    private $voucher_setup;

    private $tree;

    private $authRepository;

    private $voucherReceivedRepository;

    private $customerRepository;

    private $userCheck;

    private $voucherPurchaseReturnRepository;

    public function __construct(GodownRepository $godownRepository, Voucher_setup $voucher_setup, LegerHeadRepository $ledger, Tree $tree, GroupChartRepository $groupChartRepository, CustomerRepository $customerRepository, UserCheck $userCheck, VoucherPurchaseReturnRepository $voucherPurchaseReturnRepository, VoucherReceivedRepository $voucherReceivedRepository)
    {
        $this->godown = $godownRepository;
        $this->voucher_setup = $voucher_setup;
        $this->ledger = $ledger;
        $this->tree = $tree;
        $this->groupChartRepository = $groupChartRepository;
        $this->customerRepository = $customerRepository;
        $this->userCheck = $userCheck;
        $this->voucherPurchaseReturnRepository = $voucherPurchaseReturnRepository;
        $this->voucherReceivedRepository = $voucherReceivedRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (count(array_filter($request->product_id)) != 0) {
            if (user_privileges_check('Voucher', $request->voucher_id, 'create_role')) {
                if ($request->ch_4_dup_vou_no == 0) {
                    $validator = Validator::make($request->all(), [
                        'invoice_no' => 'required|unique:transaction_master,invoice_no,'.$request->invoice_no.',tran_id,voucher_id,'.$request->voucher_id,
                    ]);

                    if (empty($request->invoice)) {
                        if ($validator->fails()) {
                            return RespondWithError('validation Voucher error ', $validator->errors(), 422);
                        }
                        $voucher_invoice = '';
                    } else {
                        if ($validator->fails()) {
                            $transaction_voucher = DB::table('transaction_master')->where('voucher_id', $request->voucher_id)->orderBy('tran_id', 'DESC')->first();
                            preg_match_all("/\d+/", $transaction_voucher->invoice_no, $number);
                            $voucher_invoice = str_replace(end($number[0]), end($number[0]) + 1, $transaction_voucher->invoice_no);
                        } else {
                            $voucher_invoice = '';
                        }
                    }
                } else {
                    $voucher_invoice = '';
                }
                try {
                    $data = $this->voucherPurchaseReturnRepository->storePurchaseReturn($request, $voucher_invoice);

                    return RespondWithSuccess('Voucher PurchaseReturn successful  !! ', $data, 201);
                } catch (Exception $e) {
                    return RespondWithError('Voucher PurchaseReturn Not successful !!', $e->getMessage(), 404);
                }
            } else {
                abort(403);
            }
        } else {
            return RespondWithError('Voucher PurchaseReturn Not successful !!', 'Product not Empty', 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (user_privileges_check('Voucher', $id, 'create_role')) {
            $voucher = Voucher::find($id);
            $voucher_date = $this->voucher_setup->dateSetup($voucher);
            $branch_setup = $this->voucher_setup->branchSetup($voucher);
            $voucher_invoice = $this->voucher_setup->invoiceSetup($voucher);
            $ledger_tree = $this->voucher_setup->optionLedger(32, 3, $voucher->voucher_id);
            $godowns = $this->voucher_setup->godownAccess($voucher->voucher_id);
            $ledger_commission_tree = $this->tree->getTreeViewSelectOptionLedgerTree(json_decode(json_encode($this->groupChartRepository->getGroupChartOfIndex(), true), true), 0);
            $customers = $this->customerRepository->getCustomerOfIndex();
            $distributionCenter = $this->userCheck->AccessDistributionCenter();
            $ledger_name_debit_wise = $voucher->debit != 0 ? $this->ledger->getLegerHeadId($voucher->debit) : '';
            $ledger_name_credit_wise = $voucher->credit != 0 ? $this->ledger->getLegerHeadId($voucher->credit) : '';
            $balanceDebitCredit = $voucher->debit != 0 ? $this->voucher_setup->balanceDebitCredit($voucher->debit) : '';
            $debit_sum_value = $balanceDebitCredit ? $this->voucher_setup->balanceDebitCreditCalculation($balanceDebitCredit) : '';

            return view('admin.voucher.purchase_return.create_purchase_return', compact('godowns', 'voucher_date', 'branch_setup', 'voucher_invoice', 'voucher', 'ledger_tree', 'ledger_commission_tree', 'customers', 'distributionCenter', 'ledger_name_debit_wise', 'ledger_name_credit_wise', 'debit_sum_value'));
        } else {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->voucherPurchaseReturnRepository->getPurchaseReturnId($id);
        if (user_privileges_check('Voucher', $data->voucher_id, 'alter_role')) {
            $debit_credit_data = $this->voucherReceivedRepository->editDebitCredit($id);
            $debit = $this->voucher_setup->id_wise_debit_credit_data($id, 'Dr', null);
            $credit = $this->voucher_setup->id_wise_debit_credit_data($id, 'Cr', null);
            $balanceDebitCredit = $this->voucher_setup->balanceDebitCredit($debit->ledger_head_id);
            $credit_sum_value = $this->voucher_setup->balanceDebitCreditCalculation($balanceDebitCredit);
            $voucher = Voucher::find($data->voucher_id);
            $branch_setup = $this->voucher_setup->branchSetup($voucher);
            $ledger_tree = $this->voucher_setup->optionLedger(32, 3, $voucher->voucher_id);
            $godowns = $this->voucher_setup->godownAccess($voucher->voucher_id);
            $ledger_commission_tree = $this->tree->getTreeViewSelectOptionLedgerTree(json_decode(json_encode($this->groupChartRepository->getGroupChartOfIndex(), true), true), 0);
            $customers = $this->customerRepository->getCustomerOfIndex();
            $distributionCenter = $this->userCheck->AccessDistributionCenter();
            $ledger_name_debit_wise = $voucher->debit != 0 ? $this->ledger->getLegerHeadId($voucher->debit) : '';
            $ledger_name_credit_wise = $voucher->credit != 0 ? $this->ledger->getLegerHeadId($voucher->credit) : '';

            return view('admin.voucher.purchase_return.edit_purchase_return', compact('branch_setup', 'data', 'voucher', 'debit_credit_data', 'ledger_tree', 'godowns', 'ledger_commission_tree', 'credit_sum_value', 'customers', 'distributionCenter', 'voucher', 'debit', 'credit', 'ledger_name_debit_wise', 'ledger_name_credit_wise'));
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (user_privileges_check('Voucher', $request->voucher_id, 'alter_role')) {
            if ($request->ch_4_dup_vou_no == 0) {
                $validator = Validator::make($request->all(), [
                    'invoice_no' => 'required|unique:transaction_master,invoice_no,'.$id.',tran_id,voucher_id,'.$request->voucher_id,
                ]);

                if (empty($request->invoice)) {
                    if ($validator->fails()) {
                        return RespondWithError('validation Voucher error ', $validator->errors(), 422);
                    }
                    $voucher_invoice = '';
                } else {
                    if ($validator->fails()) {
                        $transaction_voucher = DB::table('transaction_master')->where('voucher_id', $request->voucher_id)->orderBy('tran_id', 'DESC')->first();
                        preg_match_all("/\d+/", $transaction_voucher->invoice_no, $number);
                        $voucher_invoice = str_replace(end($number[0]), end($number[0]) + 1, $transaction_voucher->invoice_no);
                    } else {
                        $voucher_invoice = '';
                    }
                }
            } else {
                $voucher_invoice = '';
            }
            try {
                $data = $this->voucherPurchaseReturnRepository->updatePurchaseReturn($request, $id, $voucher_invoice);

                return RespondWithSuccess('Voucher Purchase Return Update  successful  !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError('Voucher Purchase Return Update Not successful !!', $e->getMessage(), 404);
            }
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->voucherPurchaseReturnRepository->getPurchaseReturnId($id);
        if (user_privileges_check('Voucher', $data->voucher_id, 'delete_role')) {
            try {
                $data = $this->voucherPurchaseReturnRepository->deletePurchaseReturn($id);

                return RespondWithSuccess('Voucher  PurchaseReturn delete successful  !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError('Voucher PurchaseReturn delete Not successful !!', $e->getMessage(), 404);
            }
        } else {
            abort(403);
        }
    }
}
