<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Master\GroupChartRepository;
use App\Repositories\Backend\Report\PartyLedgerRepository;
use App\Services\Tree;
use Exception;
use Illuminate\Http\Request;

class PartyLedgerController extends Controller
{
    private $tree;

    private $groupChartRepository;

    private $partyLedgerRepository;

    public function __construct(Tree $tree, GroupChartRepository $groupChartRepository, PartyLedgerRepository $partyLedgerRepository)
    {
        $this->tree = $tree;
        $this->groupChartRepository = $groupChartRepository;
        $this->partyLedgerRepository = $partyLedgerRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PartyLedgerShow()
    {
        if (user_privileges_check('report', 'PartyLedger', 'display_role')) {
            $ledgers = $this->tree->getTreeViewSelectOptionLedgerTree(json_decode(json_encode($this->groupChartRepository->getGroupChartOfIndex(), true), true), 0);

            return view('admin.report.party_ledger.party_ledger', compact('ledgers'));
        } else {
            abort(403);
        }

    }

    /**
     * Display a listing of the all data show components.
     *
     * @return \Illuminate\Http\Response
     */
    public function PartyLedgerGetData(Request $request)
    {

        if (user_privileges_check('report', 'PartyLedger', 'display_role')) {
            try {
                $data = $this->partyLedgerRepository->PartyLedgerOfIndex($request);

                return RespondWithSuccess('party ledger successfully !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError('party ledger  successfully', $e->getMessage(), 404);
            }
        } else {
            abort(403);
        }
    }

    /**
     * Display a listing of the all data show components.
     *
     * @return \Illuminate\Http\Response
     */
    public function PartyLedgerIdWise(Request $request)
    {
        if (user_privileges_check('report', 'PartyLedger', 'display_role')) {
            $ledgers = $this->tree->getTreeViewSelectOptionLedgerTree(json_decode(json_encode($this->groupChartRepository->getGroupChartOfIndex(), true), true), 0);
            $ledger_id = $request->ledger_id;
            $form_date = $request->form_date;
            $to_date = $request->to_date;

            return view('admin.report.party_ledger.party_ledger', compact('ledgers', 'ledger_id', 'form_date', 'to_date'));
        } else {
            abort(403);
        }
    }
}
