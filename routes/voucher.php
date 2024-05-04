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
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers\Backend\Voucher'], function () {
    //route dashboard
    Route::get('voucher-dashboard', 'DashboardController@index')->name('voucher-dashboard');

    //route purchase
    Route::resource('voucher-purchase', 'PurchaseController');
    Route::get('edit/purchase/stock/in', 'PurchaseController@purchaseStockIn');
    Route::get('searching-data', 'PurchaseController@searchingDataGet');
    Route::get('searching-item-data', 'PurchaseController@searchingDataGet')->name('searching-item-data');
    Route::get('searching-stock-item-price', 'PurchaseController@searchingStockItemPrice')->name('searching-stock-item-price');
    Route::get('searching-ledger', 'PurchaseController@searchingLedger')->name('searching-ledger');
    //route receipt
    Route::resource('voucher-receipt', 'ReceiptController');
    Route::get('voucher-receipt/edit/{id}', 'ReceiptController@edit')->name('voucher-receipt-edit');
    Route::get('edit/debit-credit', 'ReceiptController@editDebitCredit');
    Route::get('searching-ledger-data', 'ReceiptController@searchingLedgerDataGet')->name('searching-ledger-data');
    Route::get('get/balance/debit-credit', 'ReceiptController@balanceDebitCredit')->name('balance-debit-credit');

    //route payment
    Route::resource('voucher-payment', 'PaymentController');

    //route contra
    Route::resource('voucher-contra', 'ContraController');

    //route Grn
    Route::resource('voucher-grn', 'GrnController');

    //route sales
    Route::resource('voucher-sales', 'SalesController');
    Route::get('current-stock', 'SalesController@currentStock');
    Route::get('edit/stock/out', 'SalesController@stockOut');
    Route::get('searching-ledger-debit', 'SalesController@searchingLedgerDebit')->name('searching-ledger-debit');
    //route gtn
    Route::resource('voucher-gtn', 'GtnController');

    // route purchase return
    Route::resource('voucher-purchase-return', 'PurchaseReturnController');

    // route transfer return
    Route::resource('voucher-transfer', 'TransferController');
    Route::get('voucher-stock-in-out', 'TransferController@stockOut_with_stockIn');

    //route sales return
    Route::resource('voucher-sales-return', 'SalesReturnController');

    // route stock journal
    Route::resource('voucher-stock-journal', 'StockJournalController');
    Route::get('edit/stock/in/with/current_stock', 'StockJournalController@stockIn_with_current_stock');
    Route::get('destination_searching-stock-item-price', 'StockJournalController@destinationPrice')->name('destination_searching-stock-item-price');

    // route journal
    Route::resource('voucher-journal', 'JournalController');
    Route::get('voucher-journal-edit', 'JournalController@getDebitCreditAndStockInStockOut');
    Route::get(' journal-data', 'JournalController@getJournalData');

    // route commission
    Route::resource('voucher-commission', 'CommissionController');
    Route::post('show-commission', 'CommissionController@showCommission');
    Route::get('product_name_get', 'PurchaseController@getProductName');

    // route in line search ledger name
    Route::get('ledger_name', 'PurchaseController@inlineSearchLedgerName')->name('ledger_name');
});
