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
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers\Backend\Approve'], function () {

    //route approve
    Route::get('show-approve-page', 'ApproveController@showApprove')->name('show-approve-page');
    Route::resource('approve', 'ApproveController');
    Route::get('delivery-approved/{id}', 'ApproveController@deliveryApproved')->name('delivery-approved');

});
