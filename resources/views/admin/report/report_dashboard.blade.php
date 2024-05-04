
@extends('layouts.backend.app')
@section('title','Report Dashboard')
@push('css')
<!-- model style -->
@endpush
@section('admin_content')
<div class="pcoded-main-container navChild">
    <div class="pcoded-content  ">
        <div class="pcoded-inner-content  " >
               <br><br>
                <!-- Main-body start -->
            <div class="main-body  side-component">
                <div class="page-wrapper m-t-0 p-0">
                <!-- Page-header start -->
                    <div class="page-header m-0 p-0">
                        <div class="row align-items-end">
                            <div class="col-lg-8">
                                <div class="page-header-title">
                                    <div class="d-inline ">
                                        <h4 class="text-center mx-auto"></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="page-header-breadcrumb">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-header end -->
                    <!-- Page body start -->
                    <div class="page-body left-data">
                            <!-- Basic Form Inputs card start -->
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4 " >
                                         <h5 style="background-color:#CCCCCC" class="text-center ">General Reports</h5>
                                          @if(user_privileges_check('report','Daybook','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('daybook-report.index') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('daybook-report.index')}}" data-turbolinks="false">Day Book</a></li>
                                          @endif
                                          @if(user_privileges_check('report','Challan','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('challan-show') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('challan-show')}}" data-turbolinks="false">Challan</a></li>
                                         @endif
                                         @if(user_privileges_check('report','Bill','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('bill-show') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('bill-show')}}" data-turbolinks="false">Bill</a></li>
                                        @endif
                                        </ul>
                                        <h5 style="background-color:#CCCCCC" class="text-center">Account Summary</h5>
                                          @if(user_privileges_check('report','LedgerVoucherList','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('account-ledger-voucher') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('account-ledger-voucher')}}" data-turbolinks="false">Ledger Voucher List / Register</a></li>
                                          @endif
                                          @if(user_privileges_check('report','LedgerMonthly','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('account-ledger-monthly-summary') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('account-ledger-monthly-summary')}}" data-turbolinks="false">Accounts Ledger > Monthly Summary</a></li>
                                          @endif 
                                          @if(user_privileges_check('report','LedgerDaily','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('account-ledger-monthly-summary') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('account-ledger-daily-summary')}}" data-turbolinks="false">Accounts Ledger > Daily Summary</a></li>
                                          @endif 
                                          @if(user_privileges_check('report','AccountGroupSummary','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-account-group-summary') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-account-group-summary')}}" data-turbolinks="false">Account Group Summary</a></li>
                                          @endif
                                          @if(user_privileges_check('report','BalanceSheet','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-balance-sheet') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-balance-sheet')}}" data-turbolinks="false">Balance Sheet</a></li>
                                          @endif
                                          @if(user_privileges_check('report','TrialBalance','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-trial-balance') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-trial-balance')}}" data-turbolinks="false">Trial Balance</a></li>
                                          @endif
                                          @if(user_privileges_check('report','ProfitLoss','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-profit-loss') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-profit-loss')}}" data-turbolinks="false">Profit & Loss</a></li>
                                          @endif
                                       </ul>
                                        <h5 style="background-color:#CCCCCC" class="text-center">Movement Analysis (1)</h5>
                                          @if(user_privileges_check('report','ActualSales','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-actual_sales') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-actual_sales')}}" data-turbolinks="false">Actual Sales</a></li>
                                          @endif
                                          @if(user_privileges_check('report','LedgerAnalysis','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-ledger-analysis') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-ledger-analysis')}}" data-turbolinks="false">Ledger Analysis</a></li>
                                          @endif
                                          @if(user_privileges_check('report','ItemVoucherAnalysisLedger','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-item-voucher-analysis') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-item-voucher-analysis')}}" data-turbolinks="false">Item Voucher Analysis of Ledger</a></li>
                                          @endif
                                          @if(user_privileges_check('report','AccountsGroupAnalysis','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-item-voucher-analysis') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-account-group-analysis')}}" data-turbolinks="false">Accounts Group Analysis</a></li>
                                          @endif
                                          @if(user_privileges_check('report','ItemVoucherAnalysisGroup','display_role'))
                                            <li  class="m-1 voucher_type {{Route::is('report-item-voucher-analysis-group') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-item-voucher-analysis-group')}}" data-turbolinks="false">Item Voucher Analysis of Group</a></li>
                                          @endif
                                       </ul>
                                    </div>
                                    <div class="col-md-4  ">
                                      <h5 style="background-color:#CCCCCC" class="text-center">Company Statistics</h5>
                                      <li  class="m-1 voucher_type {{Route::is('bill-show') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('bill-show')}}" data-turbolinks="false">Month Closing Summary</a></li>
                                    </ul>
                                      <h5 style="background-color:#CCCCCC" class="text-center">Inventory Books</h5>
                                      @if(user_privileges_check('report','WarehousewiseStock','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-warehousewise-stock') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-warehousewise-stock')}}" data-turbolinks="false">Warehousewise Stock</a></li>
                                      @endif
                                      @if(user_privileges_check('report','StockItemRegister','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-item-register') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-stock-item-register')}}" data-turbolinks="false">Stock Item Register</a></li>
                                      @endif
                                      @if(user_privileges_check('report','StockItemDaily','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-item-register') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('stock-item-daily-summary')}}" data-turbolinks="false">Stock Item Daily Summary</a></li>
                                      @endif
                                      @if(user_privileges_check('report','StockItemMonthly','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-item-register') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('stock-item-monthly-summary')}}" data-turbolinks="false">Stock Item Monthly Summary</a></li>
                                      @endif
                                      @if(user_privileges_check('report','StockGroupSummary','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-group-summary') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-stock-group-summary')}}" data-turbolinks="false">Stock Group Summary</a></li>
                                      @endif
                                    </ul>
                                    <h5 style="background-color:#CCCCCC" class="text-center">Movement Analysis (2)</h5>
                                      @if(user_privileges_check('report','StockGroupAnalysis','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-group-analysis') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-stock-group-analysis')}}" data-turbolinks="false">Stock Group Analysis</a></li>
                                      @endif
                                      @if(user_privileges_check('report','StockItemAnalysis','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-item-analysis') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-stock-item-analysis')}}" data-turbolinks="false">Stock Item Analysis</a></li>
                                      @endif
                                      @if(user_privileges_check('report','StockItemAnalysisDetails','display_role'))
                                        <li  class="m-1 voucher_type {{Route::is('report-stock-item-analysis-deatils') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('report-stock-item-analysis-details')}}" data-turbolinks="false">Stock Item Analysis Details</a></li>
                                     @endif
                                    </ul>
                                    </div>
                                    <div class="col-md-4 ">
                                        <h5 style="background-color:#CCCCCC" class="text-center">Company Statistics</h5>
                                        @if(user_privileges_check('report','VoucherListsStatistics','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('voucher-register') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-register')}}" data-turbolinks="false">Voucher Lists/Register</a></li>
                                        @endif
                                        @if(user_privileges_check('report','CashFlow','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('cash-flow-summary') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('cash-flow-summary')}}" data-turbolinks="false">Cash Flow Summary</a></li>
                                        @endif
                                        @if(user_privileges_check('report','GroupCashFlow','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('group-cash-flow') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('group-cash-flow')}}" data-turbolinks="false">Group Cash Flow</a></li>
                                        @endif
                                        @if(user_privileges_check('report','LedgerCashFlow','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('group-cash-flow') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('ledger-cash-flow')}}" data-turbolinks="false">Ledger Cash Flow</a></li>
                                        @endif
                                        </ul>
                                        <h5 style="background-color:#CCCCCC" class="text-center">Party Ledger</h5>
                                        @if(user_privileges_check('report','PartyLedger','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('party-ledger') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('party-ledger')}}" data-turbolinks="false">Party Ledger</a></li>
                                        @endif
                                        @if(user_privileges_check('report','PartyLedgeDetails','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('party-ledger-details') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('party-ledger-details')}}" data-turbolinks="false">Party Ledger in Details</a></li>
                                        @endif
                                        @if(user_privileges_check('report','GroupWisePartyLedger','display_role'))
                                          <li  class="m-1 company_statistics {{Route::is('group-wise-party-ledger') ? 'activedata' : ''}}" ><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('group-wise-party-ledger')}}" data-turbolinks="false">Group Wise Party Ledger</a></li>
                                        @endif
                                       </ul>
                                    </div>
                                <div>
                            </div>
                    </div>
                </div>
           </div>
       </div>
   </div>
</div>
@push('js')
$('.company_statistics_check').
@endpush
@endsection

