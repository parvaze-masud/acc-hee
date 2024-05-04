<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers\Backend\Report'], function () {
    //dashboard route

    Route::get('report-dashboard', 'DashboardController@index')->name('report-dashboard');

    //daybook route
    Route::resource('daybook-report', 'DayBookController');
    Route::get('get-daybook', 'DayBookController@getDayBook');
    Route::get('get-debitOrStock', 'DayBookController@getDebitOrStock');

    // party ledger in details route
    Route::get('report/party-ledger', 'PartyLedgerController@PartyLedgerShow')->name('party-ledger');
    Route::match(['get', 'post'], 'report/party-ledger-get-data', 'PartyLedgerController@PartyLedgerGetData')->name('party-ledger-get-data');
    Route::get('party-ledger/{ledger_id?}/{form_date?}/{to_date?}', 'PartyLedgerController@PartyLedgerIdWise')->name('party-ledger-id-wise');

    // party ledger in details route
    Route::get('party-ledger-details', 'PartyLedgerDetailsController@PartyLedgerInDetailsShow')->name('party-ledger-details');
    Route::post('party-ledger-details-get-data', 'PartyLedgerDetailsController@PartyLedgerInDetailsGetData')->name('party-ledger-details-get-data');

    // group wise  party ledger in details route
    Route::get('report/group-wise-party-ledger', 'GroupWisePartyLedgerController@groupWisePartyLedgerShow')->name('group-wise-party-ledger');
    Route::match(['get', 'post'], 'report/group-wise-party-ledger-get-data', 'GroupWisePartyLedgerController@groupWisePartyLedgerGetData')->name('group-wise-party-ledger-get-data');
    Route::get('report/group-wise-party-ledger/{group_chart_id?}/{form_date?}/{to_date?}', 'GroupWisePartyLedgerController@groupWisePartyLedgerIdWise')->name('group-wise-party-ledger-id-wise');

    // cash flow summary route
    Route::get('cash-flow-summary', 'CashFlowSummaryController@CashFlowSummaryDetailsShow')->name('cash-flow-summary');
    Route::match(['get', 'post'], 'cash-flow-summary-get-data', 'CashFlowSummaryController@PartyLedgerInDetailsGetData')->name('cash-flow-summary-get-data');

    //group cash flow route
    Route::get('group-cash-flow', 'GroupCashFlowController@GroupCashFlowDetailsShow')->name('group-cash-flow');
    Route::match(['get', 'post'], 'group-cash-flow-get-data', 'GroupCashFlowController@GroupCashFlowDetailsGetData')->name('group-cash-flow-get-data');
    Route::get('group-cash-flow/{id?}/{form_date?}/{to_date?}', 'GroupCashFlowController@GroupCashFlowDetailsIdWise')->name('group-cash-flow-id-wise');

    //ledger cash flow route
    Route::get('ledger-cash-flow', 'ledgerCashFlowController@LedgerCashFlowDetailsShow')->name('ledger-cash-flow');
    Route::match(['get', 'post'], 'ledger-cash-flow-get-data', 'ledgerCashFlowController@LedgerCashFlowDetailsGetData')->name('ledger-cash-flow-get-data');
    Route::get('ledger-cash-flow/{id?}/{form_date?}/{to_date?}', 'ledgerCashFlowController@LedgerCashFlowDetailsIdWise')->name('ledger-cash-flow-id-wise');

    //voucher register route
    Route::get('voucher-register', 'VoucherRegisterController@VoucherRegisterShow')->name('voucher-register');
    Route::post('voucher-register-data', 'VoucherRegisterController@getVoucherRegister')->name('voucher-register-data');

    // challan route
    Route::get('challan-show', 'ChallanController@index')->name('challan-show');
    Route::post('challan-data', 'ChallanController@getChallan')->name('challan-data');

    // bill route
    Route::get('bill-show', 'BillController@index')->name('bill-show');
    Route::post('bill-data', 'BillController@getBill')->name('bill-data');
    Route::get('bill-data', 'BillController@getBill')->name('bill-data');

    // warehousewise stock
    Route::get('report/warehousewise/stock', 'WarehouseWiseStockController@warehouseWiseStockShow')->name('report-warehousewise-stock');
    Route::post('report/warehousewise/stock-data', 'WarehouseWiseStockController@warehouseWiseStock')->name('report-warehousewise-stock-data');

    // stock item register
    Route::get('report/stock-item-register', 'StockItemRegisterController@StockItemRegisterShow')->name('report-stock-item-register');
    Route::match(['get', 'post'], 'report/stock-item-register-data', 'StockItemRegisterController@StockItemRegister')->name('stock-item-register-data');
    Route::get('stock-item-select-option-tree', 'StockItemRegisterController@StockItemSelectOptionTree')->name('stock-item-select-option-tree');
    Route::get('stock-ledger-select-option-tree', 'StockItemRegisterController@StockLedgerSelectOptionTree')->name('stock-ledger-select-option-tree');
    Route::get('report/stock-item-register/{date?}/{stock_item_id?}/{godown_id?}', 'StockItemRegisterController@StockItemRegisterWise')->name('stock-item-register-id-wise');

    // stock item daily summary
    Route::get('report/stock-item-daily-summary', 'StockItemDailySummaryController@stockItemDailySummaryShow')->name('stock-item-daily-summary');
    Route::match(['get', 'post'], 'report/stock-item-daily-summary-data', 'StockItemDailySummaryController@stockItemDailySummary')->name('stock-item-daily-summary-data');

    // stock item monthly summary
    Route::get('report/stock-item-monthly-summary', 'StockItemMonthlySummaryController@stockItemMontlySummaryShow')->name('stock-item-monthly-summary');
    Route::match(['get', 'post'], 'report/stock-item-monthly-summary-data', 'StockItemMonthlySummaryController@stockItemMontlySummary')->name('stock-item-monthly-summary-data');
    Route::get('report/stock-item-monthly-summary/{id?}/{form_date?}/{to_date?}/{godown_id?}', 'StockItemMonthlySummaryController@stockItemMontlySummaryWise')->name('stock-item-monthly-summary-id-wise');

    // stock group summary
    Route::get('report/stock-group-summary', 'StockGroupSummaryController@stockGroupSummaryShow')->name('report-stock-group-summary');
    Route::post('report/stock-group-summary-data', 'StockGroupSummaryController@stockGroupSummary')->name('report-stock-group-summary-data');

    // current stoc
    Route::get('report/current-stock', 'CurrentStockController@currentStockShow')->name('report-current-stock');
    Route::post('report/current-stock-data', 'CurrentStockController@currentStockStock')->name('report-current-stock-data');
    //stock group analysis
    Route::get('report/stock-group-analysis', 'StockGroupAnalysisController@stockGroupAnalysisShow')->name('report-stock-group-analysis');
    Route::match(['get', 'post'], 'report/stock-group-analysis-data', 'StockGroupAnalysisController@stockGroupAnalysis')->name('stock-group-analysis-data');
    Route::get('report/stock-group-analysis/{stock_group_id?}/{godown_id?}/{form_date?}/{to_date?}/{purchase_in?}/{grn_in?}/{purchase_return_in?}/{journal_in?}/{stock_journal_in?}/{sales_return_out?}/{gtn_out?}/{sales_out?}/{journal_out?}/{stock_journal_out?}', 'StockGroupAnalysisController@stockGroupAnalysisIdWise')->name('stock-group-analysis-id-wise');

    //stock item analysis
    Route::get('report/stock-item-analysis', 'StockItemAnalysisController@stockItemAnalysisShow')->name('report-stock-item-analysis');
    Route::match(['get', 'post'], 'report/stock-item-analysis-data', 'StockItemAnalysisController@stockItemAnalysis')->name('stock-item-analysis-data');
    Route::get('report/stock-item-analysis/{stock_item_id?}/{godown_id?}/{form_date?}/{to_date?}/{purchase_in?}/{grn_in?}/{purchase_return_in?}/{journal_in?}/{stock_journal_in?}/{sales_return_out?}/{gtn_out?}/{sales_out?}/{journal_out?}/{stock_journal_out?}', 'StockItemAnalysisController@stockItemAnalysisIdWise')->name('stock-item-analysis-id-wise');

    //stock item analysis details
    Route::get('report/stock-item-analysis-details', 'StockItemAnalysisDetailsController@stockItemAnalysisDetailsShow')->name('report-stock-item-analysis-details');
    Route::match(['get', 'post'], 'report/stock-item-analysis-details-data', 'StockItemAnalysisDetailsController@stockItemAnalysisDetails')->name('stock-item-analysis-details-data');
    Route::get('report/stock-item-analysis-details/{ledger_head_id?}/{stock_item_id?}/{godown_id?}/{form_date?}/{to_date?}/{purchase_in?}/{grn_in?}/{purchase_return_in?}/{journal_in?}/{stock_journal_in?}/{sales_return_out?}/{gtn_out?}/{sales_out?}/{journal_out?}/{stock_journal_out?}', 'StockItemAnalysisDetailsController@stockItemAnalysisDetailsIdWise')->name('stock-item-analysis-details-id-wise');

    //actual sales
    Route::get('report/actual_sales', 'ActualSalesController@actualSalesShow')->name('report-actual_sales');
    Route::match(['post'], 'report/actual_sales-data', 'ActualSalesController@actualSales')->name('actual_sales-data');
    Route::get('report/stock-item-analysis-details/{ledger_head_id?}/{stock_item_id?}/{godown_id?}/{form_date?}/{to_date?}/{purchase_in?}/{grn_in?}/{purchase_return_in?}/{journal_in?}/{stock_journal_in?}/{sales_return_out?}/{gtn_out?}/{sales_out?}/{journal_out?}/{stock_journal_out?}', 'StockItemAnalysisDetailsController@stockItemAnalysisDetailsIdWise')->name('stock-item-analysis-details-id-wise');

    // ledger analysis
    Route::get('report/ledger-analysis', 'LedgerAnalysisController@ledgerAnalysisShow')->name('report-ledger-analysis');
    Route::match(['post'], 'report/ledger-analysis-data', 'LedgerAnalysisController@ledgerAnalysis')->name('report-ledger-analysis-data');

    // item voucher analysis
    Route::get('report/item-voucher-analysis', 'ItemVoucherAnalysisController@itemVoucherAnalysisShow')->name('report-item-voucher-analysis');
    Route::match(['post'], 'report/litem-voucher-analysis-data', 'ItemVoucherAnalysisController@itemVoucherAnalysis')->name('report-item-voucher-analysis-data');

    // trail balance
    Route::get('report/trial-balance', 'TrialBalanceController@trialBalanceShow')->name('report-trial-balance');
    Route::match(['get', 'post'], 'report/trial-balance-data', 'TrialBalanceController@trialBalance')->name('trial-balance-data');

    //account group summary
    Route::get('report/account-group-summary', 'AccountGroupSummaryController@accountGroupSummaryShow')->name('report-account-group-summary');
    Route::match(['get', 'post'], 'report/account-group-summary-data', 'AccountGroupSummaryController@accountGroupSummary')->name('account-group-summary-data');
    Route::get('report/account-group-summary/{group_chart_id?}/{form_date?}/{to_date?}', 'AccountGroupSummaryController@accountGroupSummaryIdWise')->name('account-group-summary-id-wise');

    //account ledger Daily summary
    Route::get('report/account-ledger-daily-summary', 'AccountLedgerDailySummaryController@accountLedgerDailySummaryShow')->name('account-ledger-daily-summary');
    Route::match(['get', 'post'], 'report/account-ledger-daily-summary-data', 'AccountLedgerDailySummaryController@accountLedgerDailySummary')->name('account-ledger-daily-summary-data');

    //account ledger monthly summary
    Route::get('report/account-ledger-monthly-summary', 'AccountLedgerMonthlySummaryController@accountLedgerMonthlySummaryShow')->name('account-ledger-monthly-summary');
    Route::match(['get', 'post'], 'report/account-ledger-monthly-summary-data', 'AccountLedgerMonthlySummaryController@accountLedgerMonthlySummary')->name('account-ledger-monthly-summary-data');
    Route::get('report/account-ledger-monthly-summary/{ledger_id?}/{form_date?}/{to_date?}', 'AccountLedgerMonthlySummaryController@accountLedgerMonthlySummaryIdWise')->name('account-ledger-monthly-summary-id-wise');

    //account ledger voucher
    Route::get('report/account-ledger-voucher', 'AccountLedgerVoucherController@accountLedgerVoucherShow')->name('account-ledger-voucher');
    Route::match(['get', 'post'], 'report/account-ledger-voucher-data', 'AccountLedgerVoucherController@accountLedgerVoucher')->name('account-ledger-voucher-data');
    Route::get('report/account-ledger-voucher/{ledger_id?}/{form_date?}/{to_date?}', 'AccountLedgerVoucherController@accountLedgerVoucherIdWise')->name('account-ledger-voucher-id-wise');
    Route::get('report/account-ledger-voucher-month/{ledger_id?}/{date?}', 'AccountLedgerVoucherController@accountLedgerVoucherMonthWise')->name('account-ledger-voucher-month-id-wise');

    // balance sheet
    Route::get('report/balance-sheet', 'BalanceSheetController@BalanceSheetShow')->name('report-balance-sheet');
    Route::match(['get', 'post'], 'report/balance-sheet-data', 'BalanceSheetController@BalanceSheet')->name('balance-sheet-data');

    // profit loss
    Route::get('report/profit-loss', 'ProfitLossController@profitLossShow')->name('report-profit-loss');
    Route::match(['get', 'post'], 'report/profit-loss-data', 'ProfitLossController@profitLoss')->name('profit-loss-data');

    //account group analysis
    Route::get('report/account-group-analysis', 'AccountGroupAnalysisController@AccountGroupAnalysisShow')->name('report-account-group-analysis');
    Route::match(['post'], 'report/account-group-analysis-data', 'AccountGroupAnalysisController@AccountGroupAnalysis')->name('account-group-analysis-data');

    // item voucher analysis group
    Route::get('report/item-voucher-analysis-group', 'ItemVoucherAnalysisGroupController@itemVoucherAnalysisGroupShow')->name('report-item-voucher-analysis-group');
    Route::match(['post'], 'report/litem-voucher-analysis-group-data', 'ItemVoucherAnalysisGroupController@itemVoucherAnalysisGroup')->name('report-item-voucher-analysis-group-data');
});
