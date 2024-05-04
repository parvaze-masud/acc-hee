@extends('layouts.backend.app')
@section('title','Approve')
@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<!-- model style -->
<link rel="stylesheet" type="text/css" href="{{asset('libraries/assets/modal-style.css')}}">
<style>
    input[type=radio] {
        width: 20px;
        height: 20px;
    }

    input[type=checkbox] {
        width: 20px;
        height: 20px;
    }

    .card-block {
        padding: 0.25rem;
    }

    .card {
        margin-bottom: -29px;
    }

    body {
        /* overflow: hidden; */
        /* Hide scrollbars */
    }
</style>
@endpush
@section('admin_content')
<br>
@component('components.setting_modal', [
'id' =>'exampleModal',
'class' =>'modal fade',
'page_title'=>'approve',
'page_unique_id'=>15,
'title'=>'Approve',
'sort_by'=>'sort_by',
'insert_settings'=>'insert_settings',
'view_settings'=>'view_settings'
])
@endcomponent
<div class="coded-main-container navChild ">
    <div class="pcoded-content">
        <div class="pcoded-inner-content"><br>
            <!-- Main-body start -->
            <div class="main-body p-0  side-component">
                <div class="page-wrapper m-t-0 p-0">
                    <div class="page-wrapper m-t-0 m-l-1 m-r-1 p-2">
                        <!-- Page-header start -->
                        <div class="page-header m-0 p-0  ">
                            <div class="row align-items-left">
                                <div class="col-lg-12">
                                    <div class="row ">
                                        <div class="col-md-3">
                                            <div class="page-header-title">
                                                <h4>Approve Order</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div style="float: right; margin-left: 5px;">
                                                <a style=" float:right; text-decoration: none; " href="{{route('master-dashboard')}}"><span class="fa fa-times-circle-o m-1" style="font-size:27px; color:#ff6666;"></span><span style="float:right;margin:2px; padding-top:5px; ">Close</span></a>
                                            </div>
                                            <div style="float: right; margin-left: 5px;">
                                                <a style=" float:right ;text-decoration: none; cursor: pointer" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-cog m-1" style="font-size:27px;  color:Green;"></span><span style="float:right;margin:2px; padding-top:5px; ">Setting</span></a>
                                            </div>
                                            <div style="float: right;margin-left:9px">
                                                <a style="float:right; text-decoration: none;cursor: pointer; " onclick="print_html('landscape','Stock Item Price')"><span class="fa fa-print m-1" style="font-size:27px; color:teal;"></span><span style="float:right;margin:2px; padding-top:5px;">Print</span></a>
                                            </div>
                                            <div style="float: right;margin-left:9px">
                                                <a style="float:right; text-decoration: none;cursor: pointer;" class="excel" onclick="exportTableToExcel('Stock Item Price')"><span class="fa fa-file-excel-o m-1 " style="font-size:25px; color:Gray;"></span><span style="float:right;margin:2px; padding-top:5px;">Excel</span></a>
                                            </div>
                                            <div style="float: right;margin-left:9px">
                                                <a style="float:right; text-decoration: none;cursor: pointer;" class="pdf_download" onclick="generateTable('Stock Item Opening')"><span class="fa fa-file-pdf-o m-1 " style="font-size:25px; color:MediumSeaGree; "></span><span style="float:right;margin:2px; padding-top:5px;">Pdf</span></a>
                                            </div>
                                            <div style="float: right; width:200px;">
                                                <input type="text" id="myInput" style="border-radius: 5px" class="form-control form-control pb-1" width="100%" placeholder="searching">
                                            </div>
                                        </div>
                                        <hr style="margin-bottom: 0px;">
                                    </div>
                                </div>
                                <!-- Page-header end -->
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <div class="row">
                                        <div class="page-header m-0  ">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Page-body start -->
                            <div class="page-body left-data">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <!-- Zero config.table start -->
                                        <div class="card ">
                                            <div class="card-block table_content">
                                                <div class="row ">
                                                    <h4 style="text-align: center;font-weight: bold; padding:0%;margin:0%">{{company()->company_name }}</h4>
                                                    <h4 style="text-align: center;font-weight: bold; padding:0%;margin:0%">Bill of : {{$tran_ledger->voucher_name }}</h4>
                                                </div>
                                                <hr>
                                                <div class="row row_style m-1">
                                                    <div class="col-md-6 box">
                                                        <div>
                                                            <span style="font-weight: bold;">Invoice No :</span>
                                                            <span style="margin-left:1%">{{$tran_ledger->invoice_no}}</span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;">Ref No :</span>
                                                            <span style="margin-left:1%">{{$tran_ledger->ref_no}}</span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;">Date :</span>
                                                            <span style="margin-left:1%">{{date('d M, Y', strtotime($tran_ledger->transaction_date))}}</span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;">Note :</span>
                                                            <span style="margin-left:1%">{{$tran_ledger->narration}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6 box">
                                                        @if((int)$tran_ledger->voucher_type_id==10 OR (int)$tran_ledger->voucher_type_id==24 OR (int)$tran_ledger->voucher_type_id==29 OR (int)$tran_ledger->voucher_type_id==19 OR (int)$tran_ledger->voucher_type_id==23 OR (int)$tran_ledger->voucher_type_id==25 )
                                                        <div>
                                                            <span style="font-weight: bold;">Party Code : </span>
                                                            <span style="margin-left:1%"></span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;">Party Name : </span>
                                                            <span style="margin-left:1%"> {{$tran_ledger->ledger_name }}</span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;">Address : </span>
                                                            <span style="margin-left:1%">{{$tran_ledger->mailing_add}}</span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;">Contact : </span>
                                                            <span style="margin-left:1%">{{$tran_ledger->mobile}}</span>
                                                        </div>
                                                        <div>
                                                            <span style="font-weight: bold;"> NID : </span>
                                                            <span style="margin-left:1%">{{$tran_ledger->national_id}}</span>
                                                        </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="dt-responsive table-responsive cell-border sd ">
                                                    <table id="tableId" style=" border-collapse: collapse;" class="table  customers ">
                                                        {{-- debit credit --}}

                                                        @if((int)$tran_ledger->voucher_type_id==14 OR (int)$tran_ledger->voucher_type_id==8 OR (int)$tran_ledger->voucher_type_id==1)
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Serial No</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Type</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Particular</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Debit</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Credit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="qw" id="myTable">
                                                            @php $total_debit=0;$total_credit=0; @endphp
                                                            @foreach ($debit_credit as $key=>$data)
                                                            @php $total_debit+=$data->debit; $total_debit+=$data->credit;@endphp
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;">{{ $key+1 }}</td>

                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->dr_cr}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->ledger_name}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{number_format((float)$data->debit, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{number_format((float)$data->credit, company()->amount_decimals)}}</td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>

                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold; text-align: right;">TOTAL :</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$total_debit, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$total_debit, company()->amount_decimals)}}</td>
                                                            </tr>
                                                        </tbody>
                                                        @elseif($tran_ledger->voucher_type_id==21)
                                                        {{-- {{Stock Journal}} --}}

                                                        <thead>
                                                            <td>Source (Consumption)</td>
                                                            <tr>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Serial No</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Source Godown</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Description Of Goods</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Quantity</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Rate</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="qw" id="myTable">
                                                            @php $total_out_qty=0;$amount_out=0; $total_out_rate=0; @endphp
                                                            @foreach ($stock_out as $key=>$data)
                                                            @php $total_out_qty+=$data->qty;$amount_out+=$data->total; $total_out_rate+=$data->rate; @endphp
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;">{{ $key+1 }}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->godown_name}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->product_name}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->qty ." "}}{{$data->symbol }}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{number_format((float)$data->rate, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{number_format((float)$data->total, company()->amount_decimals)}}</td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;">TOTAL :</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{$total_out_qty}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$total_out_rate, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$amount_out, company()->amount_decimals)}}</td>
                                                            </tr>
                                                        </tbody>

                                                        <thead>
                                                            <td>Destination (Production)</td>
                                                            <tr>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Serial No</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Source Godown</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Description Of Goods</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Quantity</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Rate</th>
                                                                <th style="width: 3%;  border: 1px solid #ddd;">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="qw" id="myTable">
                                                            @php $total_in_qty=0;$amount_in=0; $total_in_rate=0; @endphp
                                                            @foreach ($stock_in as $key=>$data)
                                                            @php $total_in_qty+=$data->qty;$amount_in+=$data->total; $total_in_rate+=$data->rate; @endphp
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;">{{ $key+1 }}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->godown_name}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->product_name}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->qty ." "}}{{$data->symbol }}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{number_format((float)$data->rate, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{number_format((float)$data->total, company()->amount_decimals)}}</td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;">TOTAL :</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{$total_in_qty}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$total_in_rate, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$amount_in, company()->amount_decimals)}}</td>
                                                            </tr>
                                                            @else
                                                            {{-- stock--}}
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Serial No</th>
                                                                    @if($tran_ledger->voucher_type_id==22)
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Source Godown</th>
                                                                    @endif
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Description Of Goods</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Quantity</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Rate</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Amount</th>
                                                                    @if($tran_ledger->commission_is==1)
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Comm</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Comm Amount</th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                        <tbody class="qw" id="myTable">
                                                            @php $total_qty=0;$amount=0; $total_rate=0; $final_total_credit_product_wise=0; $final_total_debit_product_wise=0; @endphp
                                                            @foreach ($stock as $key=>$data)
                                                            @php $total_qty+=$data->qty;$amount+=$data->total; $total_rate+=$data->rate; @endphp
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;">{{ $key+1 }}</td>
                                                                @if($tran_ledger->voucher_type_id==22)
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->godown_name}}</td>
                                                                @endif
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->product_name}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;">{{$data->qty." "}}{{$data->symbol }}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;">{{number_format((float)$data->rate, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;">{{number_format((float)$data->total, company()->amount_decimals)}}</td>

                                                                @if($tran_ledger->commission_is==1)
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;">{{$data->commission_commission_type==1?'(-)%':($data->commission_commission_type==3?'(-)':($data->commission_commission_type==2?'(+)%':'(+)'))}}{{" ". $data->commission_commission }}</td>
                                                                @if($data->commission_commission_type==2||$data->commission_commission_type==4)
                                                                @php $final_total_credit_product_wise+=($data->commission_credit) @endphp
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;">{{number_format((float)$data->commission_credit, company()->amount_decimals)}}</td>
                                                                @endif
                                                                @if($data->commission_commission_type==1||$data->commission_commission_type==3)
                                                                @php $final_total_debit_product_wise+=($data->commission_debit) @endphp
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right; ">{{number_format((float)$data->commission_debit, company()->amount_decimals)}}</td>
                                                                @endif
                                                                @endif
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                @if($tran_ledger->voucher_type_id==22)
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                @endif
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;">TOTAL :</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{$total_qty}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$total_rate, company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$amount, company()->amount_decimals)}}</td>
                                                                @if($tran_ledger->commission_is==1)
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;">{{number_format((float)abs($final_total_credit_product_wise-$final_total_debit_product_wise), company()->amount_decimals)}}</td>
                                                                @endif
                                                            </tr>
                                                            @if($tran_ledger->commission_is==1)
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;bold;text-align: right;">Commission Total :</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)abs($final_total_credit_product_wise-$final_total_debit_product_wise), company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;"></td>
                                                            </tr>
                                                            @endif
                                                            @if($tran_ledger->commission_is==1)
                                                            <tr>
                                                                @php $total_without_commission= (($amount)-($final_total_credit_product_wise-$final_total_debit_product_wise)) @endphp
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;bold;text-align: right;">Net Total : </td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)abs(($amount)-($final_total_credit_product_wise-$final_total_debit_product_wise)), company()->amount_decimals)}}</td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;"></td>
                                                            </tr>
                                                            @endif
                                                            @if((((int)$tran_ledger->voucher_type_id==10)||((int)$tran_ledger->voucher_type_id==24)||((int)$tran_ledger->voucher_type_id==29)||((int)$tran_ledger->voucher_type_id==19)||((int)$tran_ledger->voucher_type_id==23)||((int)$tran_ledger->voucher_type_id==25)))
                                                            @php $final_total_credit=0; $final_total_debit=0; @endphp
                                                            @foreach ($debit_credit_commission as $key=>$data)
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                @if($tran_ledger->voucher_type_id==22)
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                @endif

                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;bold;text-align: right;">Commission</td>

                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{$data->commission_type==1?'(-)%':($data->commission_type==3?'(-)':($data->commission_type==2?'(+)%':'(+)')) }} </td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;">{{$data->commission}}</td>
                                                                @if($data->commission_type==2||$data->commission_type==4)
                                                                @php $final_total_credit+=($data->credit) @endphp
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$data->credit, company()->amount_decimals)}}</td>
                                                                @endif
                                                                @if($data->commission_type==1||$data->commission_type==3)
                                                                @php $final_total_debit+=($data->debit) @endphp
                                                                <td style="width: 3%;  border: 1px solid #ddd; font-weight: bold;">{{number_format((float)$data->debit, company()->amount_decimals)}}</td>
                                                                @endif
                                                                @if($tran_ledger->commission_is==1)
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;"></td>
                                                                @endif
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>

                                                                @if($tran_ledger->voucher_type_id==22)
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                @endif
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;">Final Total :</td>

                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;"></td>
                                                                @if($tran_ledger->commission_is==1)
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$total_without_commission+($final_total_credit-$final_total_debit), company()->amount_decimals)}}</td>
                                                                @else
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">{{number_format((float)$amount+($final_total_credit-$final_total_debit), company()->amount_decimals)}}</td>
                                                                @endif
                                                                @if($tran_ledger->commission_is==1)
                                                                <td style="width: 3%;  border: 1px solid #ddd;text-align: right;"></td>
                                                                <td style="width: 3%;  border: 1px solid #ddd;font-weight: bold;text-align: right;"></td>
                                                                @endif
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                        @endif
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <h6 style="text-align:left ;">Received By : . . . . . . . . . . . . . .</h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h6 style="text-align:right ;">Received For : . . . . . . . . . . . . . .</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @push('js')
            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
            <!-- table hover js -->
            <script type="text/javascript" src="{{asset('libraries/assets/table-hover.js')}}"></script>
            <script type="text/javascript" src="{{asset('pageWiseSetting/page_wise_setting.js')}}"></script>
            <script>
                $(function() {
                    // add new stock item price ajax request
                    $("#add_stock_item_prce_form").submit(function(e) {
                        e.preventDefault();
                        const fd = new FormData(this);
                        let last_updae_value = $('.last_update').is(':checked');
                        let user_name = $('.user_name').is(':checked');
                        $("#add_group_chart_btn").text('Adding...');
                        $.ajax({
                            url: '{{ route("approve.store") }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                var html = '';
                                $.each(response.data, function(key, v) {
                                    html += '<tr  class="left left-data editIcon table-row"  data-toggle="modal" data-target="#EditGodownModal" >';
                                    html += '<td class="sl" style="width: 3%;  border: 1px solid #ddd;">' + (key + 1) + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;">' + join(new Date(v.transaction_date), options, ' ') + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;">' + (v.invoice_no ? v.invoice_no : '') + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;color:#0B55C4;"><input type="hidden" class="voucher_name" value="' + v.tran_id + '" />' + (v.voucher_name ? v.voucher_name : '') + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;">' + (v.godown_name ? v.godown_name : '') + '</td>';
                                    html += '<td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">' + (v.ledger_name ? v.ledger_name : '') + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">';
                                    html += '<i>CL: ' + (v.credit_limit ? v.credit_limit.toFixed('{{company()->amount_decimals}}').replace(/\d(?=(\d{3})+\.)/g, '$&,') : parseFloat(0.00)) + '</i><br>';
                                    if (v.voucher_type_id == 19 || v.voucher_type_id == 24) {
                                        if (v.debit_credit_sum.split(",")[0] == 2 || v.debit_credit_sum.split(",")[0] == 4) {
                                            html += '<i>BL: ' + (parseFloat(v.debit_credit_sum.split(",")[1]) - parseFloat(v.debit_credit_sum.split(",")[2])).toFixed('{{company()->amount_decimals}}').replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' Dr</i>';
                                        } else if (v.debit_credit_sum.split(",")[0] == 1 || v.debit_credit_sum.split(",")[0] == 3)
                                            html += '<i>BL: ' + (parseFloat(v.debit_credit_sum.split(",")[2]) - parseFloat(v.debit_credit_sum.split(",")[1])).toFixed('{{company()->amount_decimals}}').replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' Dr</i>';
                                    }
                                    html += '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;">' + (v.credit_limit ? v.credit_limit : '') + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;">' + (v.narration ? v.cnarration : '') + '</td>';
                                    html += '<td  style="width: 3%;  border: 1px solid #ddd;"><div><i></i></div></td>';
                                    html += "</tr> ";
                                });

                                $('.qw').html(html);
                                page_wise_setting_checkbox();
                                get_hover();

                            },
                            error: function(data, status, xhr) {
                                if (data.status == 400) {
                                    swal({
                                        title: 'Oops...',
                                        text: data.message,
                                        type: 'error',
                                        timer: '1500'
                                    });
                                }


                            }
                        });
                    });
                });
            </script>
            @endpush
            @endsection
