<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Report\BalanceSheetRepository;
use Exception;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    private $balanceSheetRepository;

    public function __construct(BalanceSheetRepository $balanceSheetRepository)
    {

        $this->balanceSheetRepository = $balanceSheetRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function BalanceSheetShow()
    {
        if (user_privileges_check('report', 'BalanceSheet', 'display_role')) {
            return view('admin.report.account_summary.balance_sheet');
        } else {
            abort(403);
        }
    }

    /**
     * Display a listing of the all data show components.
     *
     * @return \Illuminate\Http\Response
     */
    public function BalanceSheet(Request $request)
    {
        if (user_privileges_check('report', 'BalanceSheet', 'display_role')) {
            try {
                $data = $this->balanceSheetRepository->getBalanceSheetOfIndex($request);

                return RespondWithSuccess(' balance sheet successfully !! ', $data, 201);
            } catch (Exception $e) {
                return RespondWithError(' balance sheet successfully', $e->getMessage(), 400);
            }
        } else {
            abort(403);
        }
    }
}
