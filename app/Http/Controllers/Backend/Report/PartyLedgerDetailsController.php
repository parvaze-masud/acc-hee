<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Master\GroupChartRepository;
use App\Repositories\Backend\Report\PartyLedgerDetailsRepository;
use App\Services\DebitCredit\DebitCreditService;
use App\Services\Tree;
use Exception;
use Illuminate\Http\Request;

class PartyLedgerDetailsController extends Controller
{
    private $debitCreditService;

    private $tree;

    private $groupChartRepository;

    private $partyLedgerRepository;

    public function __construct(DebitCreditService $debitCreditService, Tree $tree, GroupChartRepository $groupChartRepository, PartyLedgerDetailsRepository $partyLedgerRepository)
    {

        $this->debitCreditService = $debitCreditService;
        $this->tree = $tree;
        $this->groupChartRepository = $groupChartRepository;
        $this->partyLedgerRepository = $partyLedgerRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PartyLedgerInDetailsShow()
    {
        if (user_privileges_check('report', 'PartyLedgeDetails', 'display_role')) {
            $ledgers = $this->tree->getTreeViewSelectOptionLedgerTree(json_decode(json_encode($this->groupChartRepository->getGroupChartOfIndex(), true), true), 0);

            return view('admin.report.party_ledger.party_ledger_in_details', compact('ledgers'));
        } else {
            abort(403);
        }

    }

    /**
     * Display a listing of the all data show components.
     *
     * @return \Illuminate\Http\Response
     */
    public function PartyLedgerInDetailsGetData(Request $request)
    {

        if (user_privileges_check('report', 'PartyLedgeDetails', 'display_role')) {
            try {
                $data = $this->partyLedgerRepository->PartyLedgerInDetails($request);

                return RespondWithSuccess('Party Ledger Details successfully !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError('Party Ledger Details successfully', $e->getMessage(), 400);
            }
        } else {
            abort(403);
        }
    }
}
