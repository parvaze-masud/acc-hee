
@extends('layouts.backend.app')
@section('title','Dashboard Voucher')
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
                                <div class="row ms-2">
                                    <div class="col-md-4">
                                         <h5 style="background-color:#CCCCCC" class="text-center ">Inward Vouchers</h5>
                                            @foreach ($purchases as $key=>$purchase )
                                              @if(user_privileges_check('Voucher',$purchase->voucher_id,'display_role'))
                                                  <li  class="m-1 voucher_type {{Route::is('voucher-purchase.create') ? 'activedata' : ''}}"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-purchase.show',$purchase->voucher_id)}}" data-turbolinks="false">{{$purchase->voucher_name}}</a></li>
                                              @endif
                                            </ul>
                                            @endforeach
                                            <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                              @foreach ($receives as $key=>$receve)
                                                @if(user_privileges_check('Voucher',$receve->voucher_id,'display_role'))
                                                  <li class="m-1 voucher_type {{Route::is('voucher-purchase.create') ? 'activedata' : ''}}"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-receipt.show',$receve->voucher_id)}}" data-turbolinks="false">{{$receve->voucher_name}}</a></li>
                                                @endif
                                            </ul>
                                            @endforeach
                                            <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                            @foreach ($grns as $key=>$grn)
                                               @if(user_privileges_check('Voucher',$grn->voucher_id,'display_role'))
                                                 <li class="m-1 voucher_type {{Route::is('voucher-grn.create') ? 'activedata' : ''}}"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-grn.show',$grn->voucher_id)}}" data-turbolinks="false">{{$grn->voucher_name}}</a></li>
                                                @endif
                                            </ul>
                                            @endforeach
                                            <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                            @foreach ($sales_return as $key=>$sale_return)
                                              @if(user_privileges_check('Voucher',$sale_return->voucher_id,'display_role'))
                                                <li class="m-1 voucher_type {{Route::is('voucher-purchase.create') ? 'activedata' : ''}}"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-sales-return.show',$sale_return->voucher_id)}}" data-turbolinks="false">{{$sale_return->voucher_name}}</a></li>
                                              @endif
                                          </ul>
                                          @endforeach
                                          <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                    </div>
                                    <div class="col-md-4">
                                      <h5 style="background-color:#CCCCCC" class="text-center">Outward Vouchers</h5>
                                        @foreach ($payments as $key=>$payment )
                                          @if(user_privileges_check('Voucher',$payment->voucher_id,'display_role'))
                                            <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-payment.show',$payment->voucher_id)}}" data-turbolinks="false">{{$payment->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($sales as $key=>$sale)
                                          @if(user_privileges_check('Voucher',$sale->voucher_id,'display_role'))
                                            <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;"href="{{route('voucher-sales.show',$sale->voucher_id)}}" data-turbolinks="false">{{$sale->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($gtns as $key=>$gtn)
                                          @if(user_privileges_check('Voucher',$gtn->voucher_id,'display_role'))
                                            <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;"href="{{route('voucher-gtn.show',$gtn->voucher_id)}}" data-turbolinks="false">{{$gtn->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($purchase_returns as $key=>$purchase_return)
                                            @if(user_privileges_check('Voucher',$purchase_return->voucher_id,'display_role'))
                                              <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-purchase-return.show',$purchase_return->voucher_id)}}" data-turbolinks="false">{{$purchase_return->voucher_name}}</a></li>
                                            @endif
                                         </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($adjustments as $key=>$adjustment)
                                          @if(user_privileges_check('Voucher',$adjustment->voucher_id,'display_role'))
                                           <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="{{route('voucher-transfer.show',$adjustment->voucher_id)}}" data-turbolinks="false">{{$adjustment->voucher_name}}</a></li>
                                          @endif
                                       </ul>
                                       @endforeach
                                       <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 style="background-color:#CCCCCC" class="text-center">Journal & General Vouchers</h5>
                                        @foreach ($contra as $key=>$con )
                                          @if(user_privileges_check('Voucher',$con->voucher_id,'display_role'))
                                              <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;"href="{{route('voucher-contra.show',$con->voucher_id)}}" data-turbolinks="false">{{$con->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($journals as $key=>$journal)
                                          @if(user_privileges_check('Voucher',$journal->voucher_id,'display_role'))
                                            <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;"href="{{route('voucher-journal.show',$journal->voucher_id)}}" data-turbolinks="false">{{$journal->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($jv as $key=>$data)
                                          @if(user_privileges_check('Voucher',$journal->voucher_id,'display_role'))
                                           <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;"href="{{route('voucher-stock-journal.show',$data->voucher_id)}}" data-turbolinks="false">{{$data->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
                                        @foreach ($commissions as $key=>$commission)
                                          @if(user_privileges_check('Voucher',$journal->voucher_id,'display_role'))
                                           <li class="m-1"><a style=" text-decoration: none; font-size: 15px;color:#0B55C4;"href="{{route('voucher-commission.show',$commission->voucher_id)}}" data-turbolinks="false">{{$commission->voucher_name}}</a></li>
                                          @endif
                                        </ul>
                                       
                                        @endforeach
                                        <p class="w3-margin-top w3-bottombar m-1" style="background-color:#eee; border-bottom: 6px solid #ccc!important;" ></p>
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
@endpush
@endsection

