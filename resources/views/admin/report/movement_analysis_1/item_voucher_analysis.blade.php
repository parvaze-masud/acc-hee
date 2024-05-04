
@extends('layouts.backend.app')
@section('title','Item voucher Analysis')
@push('css')
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
    table {width:100%;grid-template-columns: auto auto;}
    .table-scroll thead tr:nth-child(2) th {
        top: 30px;
    }
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Item voucher Analysis',
    'print_layout'=>'landscape',
    'print_header'=>'Item voucher Analysis',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="item_voucher_analysis"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-3">
                <label>Item Name :</label>
                <select name="stock_item_id" class="form-control  js-example-basic-single stock_item stock_item_id" required>
                    <option value="">--Select--</option>
                </select>
                <label>Accounts Ledger : </label>
                <select name="ledger_id" class="form-control  js-example-basic-single  ledger_id" required>
                    <option value="">--Select--</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="row  m-0 p-0">
                    <div class="col-md-6 m-0 p-0">
                        <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{company()->financial_year_start }}">
                    </div>
                    <div class="col-md-6 m-0 p-0">
                        <label>Date To : </label>
                        <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label></label><br>
                    <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
                </div>
            </div>
            <div class="col-md-6">
                <label></label>
                <div class="form-group mb-0" style="position: relative">
                    <label class="fs-6">Eff. Rate :</label>
                    <input class="form-check-input op_qty" type="checkbox"  name="rate_in"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Inward Column
                    </label>
                    <input class="form-check-input op_rate " type="checkbox"    name="rate_out"   value="1"  >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Outward Column
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <label class="fs-6">Inward Column :</label>
                    <input class="form-check-input purchase" type="checkbox"  name="purchase" {{ isset($purchase_in)?($purchase_in==10 ? ' checked' : ''):''  }}  value="10" {{$purchase_in?? "checked"}} >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Purchase
                    </label>
                    <input class="form-check-input grn" type="checkbox"  {{ isset($grn_in)?($grn_in==24 ? 'checked' : ''):''  }}   name="grn"   value="24" {{$grn_in??"checked"}} >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        GRN
                    </label>
                    <input class="form-check-input purchase_return" type="checkbox"  name="purchase_return" {{ isset($purchase_return_in)?($purchase_return_in==29 ? ' checked' : ''):''  }}  value="29" {{$purchase_return_in??"checked"}} >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Purchase Return
                    </label>
                    <input class="form-check-input journal_in" type="checkbox"    name="journal_in"  {{ isset($journal_in)?($journal_in==6 ? ' checked' : ''):''  }} value="6" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Journal
                    </label>
                    <input class="form-check-input stock_journal_in" type="checkbox"    name="stock_journal_in" {{ isset($stock_journal_in)?($stock_journal_in==21 ? ' checked' : ''):''  }}  value="21" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Stock Journal
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <label class="fs-6">Outward Column :</label>
                    <input class="form-check-input sales_return" type="checkbox"    name="sales_return"  {{ isset($sales_return_out)?($sales_return_out==25 ? ' checked' : ''):''  }}  value="25" {{$sales_return_out?? "checked"}}>
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Sales Return
                    </label>
                    <input class="form-check-input gtn" type="checkbox"    name="gtn" {{ isset($gtn_out)?($gtn_out==23 ? ' checked' : ''):''  }}   value="23"  {{$gtn_out?? "checked"}}>
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        GTN
                    </label>
                    <input class="form-check-input sales" type="checkbox"    name="sales" {{ isset($sales_out)?($sales_out==19 ? ' checked' : ''):''  }}  value="19"  {{$sales_out?? "checked"}}>
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Sales
                    </label>
                    <input class="form-check-input journal_out" type="checkbox"    name="journal_out"  {{ isset($journal_out)?($journal_out==6 ? ' checked' : ''):''  }}  value="6" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Journal
                    </label>
                    <input class="form-check-input stock_journal_out" type="checkbox"    name="stock_journal_out" {{ isset($stock_journal_out)?($stock_journal_out==12 ? ' checked' : ''):''  }}  value="21" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Stock Journal
                    </label>
               </div>
           </div>
        </div>
    </form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_stock_group_analysis">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers table-scroll">
        <thead>
            <thead>
                <tr>
                    <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold; overflow: hidden;">Serial</th>
                    <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold; overflow: hidden;">Vch No</th>
                    <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold; overflow: hidden;">Particulars / Voucher Type</th>
                    <th style="width: 5%;  border: 1px solid #ddd;font-weight: bold; overflow: hidden;">Quantity</th>
                    <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold; overflow: hidden;">Rate</th>
                    <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;overflow: hidden;">Value</th>
                </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;"></th>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;"></th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Total :</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_opening"></th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_inwards"></th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_outwards"></th>
            </tr>
        </tfoot>
    </table>
    <div class="col-sm-12 text-center hide-btn">
        <span><b>Copyright &copy; 2014-2022 <a href="http://www.hamko-ict.com/">Hamko-ICT.</a> All rights
                reserved.</b></span>
    </div>
</div>
@endslot
@endcomponent
<br>
@push('js')
<!-- table hover js -->
<script type="text/javascript" src="{{asset('libraries/assets/table-hover.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/jquery-simple-tree-table.js')}}"></script>
<script type="text/javascript" src="{{asset('ledger&item_select_option.js')}}"></script>

<script>
// get select option item
get_item_recursive('{{route("stock-item-select-option-tree") }}');
get_ledger_recursive('{{route("stock-ledger-select-option-tree") }}');

$(document).ready(function(){
    // table header fixed
    let display_height=$(window).height();
    $('.tableFixHead_stock_group_analysis').css('height',`${display_height-300}px`);
});

var amount_decimals="{{company()->amount_decimals}}";
let  total_inwards_qty=0; total_inwards_value=0;total_outwards_qty=0;total_outwards_value=0;
// group chart  id check
if({{$godown_id??0}}!=0){
     $('.godown_id').val('{{$godown_id??0}}');
}
if({{$stock_item_id??0}}!=0){
     $('.stock_item_id').val('{{$stock_item_id??0}}');
}

// stock group analysis
$(document).ready(function () {
 // stock item analysis function
 function get_item_voucher_analysis_initial_show(){
        $.ajax({
            url: '{{ route("stock-item-analysis-data") }}',
                method: 'GET',
                data: {
                    to_date:$('.to_date').val(),
                    from_date:$('.from_date').val(),
                    stock_item_id:$(".stock_item_id").val(),
                    godown_id:$(".godown_id").val(),
                    purchase:$(".purchase").is(':checked')?$(".purchase").val():'',
                    grn:$(".grn").is(':checked')?$(".grn").val():'',
                    purchase_return:$(".purchase_return").is(':checked')?$(".purchase_return").val():'',
                    journal_in:$(".journal_in").is(':checked')?$(".journal_in").val():'',
                    stock_journal_in:$(".stock_journal_in").is(':checked')?$(".stock_journal_in").val():'',
                    sales_return:$(".sales_return").is(':checked')?$(".sales_return").val():'',
                    gtn:$(".gtn").is(':checked')?$(".gtn").val():'',
                    sales:$(".sales").is(':checked')?$(".sales").val():'',
                    journal_out:$(".journal_out").is(':checked')?$(".journal_out").val():'',
                    stock_journal_out:$(".stock_journal_out").is(':checked')?$(".stock_journal_out").val():'',
                },
                dataType: 'json',
                success: function(response) {
                    get_item_voucher_analysis(response.data)
                },
                error : function(data,status,xhr){
                }
        });
   }

    // stock  group get id check
    if({{$stock_item_id??0}}!=0){
        get_item_voucher_analysis_initial_show();
    }

  $("#item_voucher_analysis").submit(function(e) {
      total_inwards_qty=0; total_inwards_value=0;total_outwards_qty=0;total_outwards_value=0;
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("report-item-voucher-analysis-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    result=[];
                  get_item_voucher_analysis(response.data)
                },
                error : function(data,status,xhr){

                }
        });
   });

function get_item_voucher_analysis(response){
              total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0; total_outwards_value=0;
                let  html='';

                //stock in
                html+=` <tr><td style="font-weight: bolder;font-size: 18px;" colspan="6">Movement Inward</td></tr> `;
                if(response.purchase){
                    response.purchase[0]?html+=`<tr><td colspan="6" style="font-weight: bolder;font-size: 16px;">Purchase</td></tr>`:'';
                    $.each(response.purchase, function(key, v) {
                           total_inwards_qty+=(v.stock_in_qty||0);total_inwards_value+=(v.stock_in_total||0);
                            html+=` <tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                             <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_in_total||0)/(v.stock_in_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           </tr> `;
                   });
                }
                if(response.grn){
                    response.grn[0]?html+=`<tr><td colspan="6" style="font-weight: bolder;font-size: 16px;">GRN</td></tr> `:'';
                    $.each(response.grn, function(key, v) {
                            total_inwards_qty+=(v.stock_in_qty||0);total_inwards_value+=(v.stock_in_total||0);
                            html+=` <tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                             <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_in_total||0)/(v.stock_in_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           </tr> `;
                   });
                }
                if(response.purchase_return){
                    response.purchase_return[0]?html+=`<tr><td colspan="6" style="font-weight: bolder;font-size: 16px;">Purchase Return</></tr> `:'';
                    $.each(response.purchase_return, function(key, v) {
                            total_inwards_qty+=(v.stock_in_qty||0);total_inwards_value+=(v.stock_in_total||0);
                            html+=` <tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                             <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_in_total||0)/(v.stock_in_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           </tr> `;
                   });
                }
                if(response.journal_in){
                    response.journal_in[0]?html+=`<tr><td colspan="6" style="font-weight: bolder;font-size: 16px;">Journal</td></tr>`:'';
                    $.each(response.journal_in, function(key, v) {
                            total_inwards_qty+=(v.stock_in_qty||0);total_inwards_value+=(v.stock_in_total||0);
                            html+=` <tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                             <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_in_total||0)/(v.stock_in_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           </tr> `;
                   });
                }
                if(response.stock_journal_in){
                    response.stock_journal_in[0]? html+=`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;">Stock Journal</td></tr> `:'';
                    $.each(response.stock_journal_in, function(key, v) {
                            total_inwards_qty+=(v.stock_in_qty||0);total_inwards_value+=(v.stock_in_total||0);
                            html+=` <tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                             <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_in_total||0)/(v.stock_in_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                             <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_in_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           </tr> `;
                   });
                }
                html+=` <tr><td style="font-weight: bolder;font-size: 18px;" colspan="3">Total :</td><td style=";font-size: 16px;font-weight: bolder;">${total_inwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${(Math.abs((total_inwards_value)/(total_inwards_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${total_inwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td></tr> `;

                //stock out
                html+=` <tr><td style="font-weight: bolder;font-size: 18px;" colspan="6">Movement Outward</td></tr> `;

                if(response.sales_return){
                    response.sales_return[0]? html+=`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;">Sales Return </td></tr> `:'';
                    $.each(response.sales_return, function(key, v) {
                        total_outwards_qty+=(v.stock_out_qty||0);total_outwards_value+=(v.stock_out_total||0);
                        html+=`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_out_total||0)/(v.stock_out_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr> `;
                    });
               }
               if(response.gtn){
                    response.gtn[0]? html+=`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;">GTN</td></tr> `:'';
                    $.each(response.gtn, function(key, v) {
                        total_outwards_qty+=(v.stock_out_qty||0);total_outwards_value+=(v.stock_out_total||0);
                        html+=`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_out_total||0)/(v.stock_out_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr> `;
                    });
               }
               if(response.sales){
                    response.sales[0]? html+=`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;">Sales</td></tr> `:'';
                    $.each(response.sales, function(key, v) {
                        total_outwards_qty+=(v.stock_out_qty||0);total_outwards_value+=(v.stock_out_total||0);
                        html+=`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_out_total||0)/(v.stock_out_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr> `;
                    });
               }
               if(response.journal_out){
                   response.journal_out[0]? html+=`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;">Journal</td></tr> `:'';
                    $.each(response.journal_out, function(key, v) {
                        total_outwards_qty+=(v.stock_out_qty||0);total_outwards_value+=(v.stock_out_total||0);
                        html+=`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_out_total||0)/(v.stock_out_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr> `;
                    });
               }
               if(response.stock_journal_out){
                   response.stock_journal_out[0]? html+=`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;"> Stock Journal</td></tr> `:'';
                    $.each(response.stock_journal_out, function(key, v) {
                        total_outwards_qty+=(v.stock_out_qty||0);total_outwards_value+=(v.stock_out_total||0);
                        html+=`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;  border: 1px solid #ddd;">${(key+1)}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;color: #0B55C4"class="text-wrap">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(((v.stock_out_total||0)/(v.stock_out_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;" class="text-wrap">${(v.stock_out_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr> `;
                    });
               }
               html+=` <tr><td style="font-weight: bolder;font-size: 18px;" colspan="3">Total :</td><td style=";font-size: 16px;font-weight: bolder;">${total_outwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${(Math.abs((total_outwards_value)/(total_outwards_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${total_outwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td></tr> `;

        $(".item_body").html(html);
        set_scroll_table();
        get_hover();
    }
});

//get redirect route
$(document).ready(function () {
        $('.sd').on('click','.customers tbody tr ',function(e){
            localStorage.setItem("end_date",$('.to_date').val());
            localStorage.setItem("start_date",$('.from_date').val());
            localStorage.setItem("voucher_id",$('.voucher_id').val());
            e.preventDefault();
            let day_book_arr=$(this).closest('tr').attr('id').split(",");
            window.location = "{{url('voucher-receipt/edit')}}" + '/' + day_book_arr[0] ;
            if(day_book_arr[1]==14){
                window.location = "{{url('voucher-receipt/edit')}}" + '/' + day_book_arr[0] ;
            }else if(day_book_arr[1]==8){
                window.location = "{{url('voucher-payment')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==1){
                window.location = "{{url('voucher-contra')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==10){
                window.location = "{{url('voucher-purchase')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==24){
                window.location = "{{url('voucher-grn')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==19){
                window.location = "{{url('voucher-sales')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==23){
                window.location = "{{url('voucher-gtn')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==29){
                window.location = "{{url('voucher-purchase-return')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==22){
                window.location = "{{url('voucher-transfer')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==25){
                window.location = "{{url('voucher-sales-return')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==21){
                window.location = "{{url('voucher-stock-journal')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==6){
                window.location = "{{url('voucher-journal')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==28){
                window.location = "{{url('voucher-commission')}}" + '/' + day_book_arr[0]+'/edit' ;

            }

        })
});
</script>
@endpush
@endsection
