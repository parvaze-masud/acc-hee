<?php

namespace App\Http\Controllers\Backend\Voucher;

use App\Http\Controllers\Controller;
use App\Models\StockIn;
use App\Models\Voucher;
use App\Repositories\Backend\Master\CustomerRepository;
use App\Repositories\Backend\Master\GodownRepository;
use App\Repositories\Backend\Master\GroupChartRepository;
use App\Repositories\Backend\Voucher\{VoucherTransferRepository};
use App\Services\User\UserCheck;
use App\Services\Voucher_setup\Voucher_setup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    private $godown;

    private $groupChartRepository;

    private $unit_branch;

    private $ledger;

    private $voucher_setup;

    private $authRepository;

    private $customerRepository;

    private $userCheck;

    private $voucherTransferRepository;

    public function __construct(GodownRepository $godownRepository, Voucher_setup $voucher_setup, GroupChartRepository $groupChartRepository, CustomerRepository $customerRepository, UserCheck $userCheck, VoucherTransferRepository $voucherTransferRepository)
    {
        $this->godown = $godownRepository;
        $this->voucher_setup = $voucher_setup;
        $this->groupChartRepository = $groupChartRepository;
        $this->customerRepository = $customerRepository;
        $this->userCheck = $userCheck;
        $this->voucherTransferRepository = $voucherTransferRepository;
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
                    $data = $this->voucherTransferRepository->storeTransfer($request, $voucher_invoice);

                    return RespondWithSuccess('Voucher Transfer successful  !! ', $data, 201);
                } catch (Exception $e) {
                    return RespondWithError('Voucher Transfer Not successful !!', $e->getMessage(), 404);
                }
            } else {
                abort(403);
            }
        } else {
            return RespondWithError('Voucher Transfer Not successful !!', 'Product not Empty', 422);
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
            $godowns = $this->voucher_setup->godownAccess($voucher->voucher_id);
            $customers = $this->customerRepository->getCustomerOfIndex();
            $distributionCenter = $this->userCheck->AccessDistributionCenter();

            return view('admin.voucher.transfer.create_transfer', compact('godowns', 'voucher_date', 'branch_setup', 'voucher_invoice', 'voucher', 'customers', 'distributionCenter'));
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
        $data = $this->voucherTransferRepository->getTransferId($id);
        if (user_privileges_check('Voucher', $data->voucher_id, 'alter_role')) {
            $voucher = Voucher::find($data->voucher_id);
            $godown_id_in = StockIn::where('tran_id', $id)->first(['godown_id']);
            $branch_setup = $this->voucher_setup->branchSetup($voucher);
            $godowns = $this->voucher_setup->godownAccess($voucher->voucher_id);
            $customers = $this->customerRepository->getCustomerOfIndex();
            $distributionCenter = $this->userCheck->AccessDistributionCenter();

            return view('admin.voucher.transfer.edit_transfer', compact('branch_setup', 'data', 'voucher', 'godowns', 'customers', 'distributionCenter', 'voucher', 'godown_id_in'));
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
                $data = $this->voucherTransferRepository->updateTransfer($request, $id, $voucher_invoice);

                return RespondWithSuccess('Voucher  Update Transfer successful  !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError('Voucher Update Transfer Not successful !!', $e->getMessage(), 404);
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
        $data = $this->voucherTransferRepository->getTransferId($id);
        if (user_privileges_check('Voucher', $data->voucher_id, 'delete_role')) {
            try {
                $data = $this->voucherTransferRepository->deleteTransfer($id);

                return RespondWithSuccess('Voucher  Transfer delete successful  !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError('Voucher Transfer delete Not successful !!', $e->getMessage(), 404);
            }
        } else {
            abort(403);
        }
    }

    public function stockOut_with_stockIn(Request $request)
    {
        try {
            $data = $this->voucher_setup->stockOut_with_stockIn($request->tran_id);

            return RespondWithSuccess('Voucher  Stock In And out successful  !! ', $data, 201);
        } catch (Exception $e) {
            return RespondWithError('Voucher Stock In And out Not successful !!', $e->getMessage(), 404);
        }
    }
}
