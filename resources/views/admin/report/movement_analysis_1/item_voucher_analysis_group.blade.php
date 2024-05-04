
@extends('layouts.backend.app')
@section('title','Item voucher Analysis Group')
@push('css')
 <!-- model style -->
 <link rel="stylesheet" type="text/css" href="{{asset('libraries/assets/modal-style.css')}}">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
.th{
    border: 1px solid #ddd;font-weight: bold;
}
.td{
    border: 1px solid #ddd; font-size: 16px;
}
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Item voucher Analysis Group',
    'print_layout'=>'landscape',
    'print_header'=>'Item voucher Analysis Group',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="item_voucher_analysis_group"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row">
            <div class="col-md-4">
                <label>Item Name :</label>
                <select name="stock_item_id" class="form-control  js-example-basic-single stock_item stock_item_id" required>
                    <option value="">--Select--</option>
                </select>
                <label>Group Name :</label>
                <select name="group_id" class="form-control  js-example-basic-single  group_id" required>
                    <option value="">--Select--</option>
                    {!!html_entity_decode($group_chart_data)!!}
                </select>
            </div>
            <div class="col-md-4">
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
            </div>
            <div class="col-md-2">
                <label></label><br>
                <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
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
                    <th style="width: 2%;" class="th">Serial</th>
                    <th style="width: 2%;" class="th">Vch No</th>
                    <th style="width: 2%;" class="th">Particulars / Voucher Type</th>
                    <th style="width: 5%;" class="th">Quantity</th>
                    <th style="width: 2%;"class="th">Rate</th>
                    <th style="width: 3%;" class="th">Value</th>
                </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;" class="th"></th>
                <th style="width: 1%; "class="th"></th>
                <th style="width: 3%;"class="th">Total :</th>
                <th style="width: 2%;font-size: 18px;"class="th"></th>
                <th style="width: 3%;font-size: 18px;"class="th"></th>
                <th style="width: 2%;font-size: 18px;"class="th"></th>
            </tr>
        </tfoot>
    </table>
    <div class="col-sm-12 text-center">
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
<script type="text/javascript" src="{{asset('ledger&item_select_option.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>

// get select option item
get_item_recursive('{{route("stock-item-select-option-tree") }}');

$(document).ready(function(){
    // table header fixed
    let display_height=$(window).height();
    $('.tableFixHead_stock_group_analysis').css('height',`${display_height-300}px`);
});

var amount_decimals="{{company()->amount_decimals}}";
let  total_inwards_qty=0; total_inwards_value=0;total_outwards_qty=0;total_outwards_value=0;

// stock group analysis
$(document).ready(function () {


 $("#item_voucher_analysis_group").submit(function(e) {
    total_inwards_qty=0; total_inwards_value=0;total_outwards_qty=0;total_outwards_value=0;
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("report-item-voucher-analysis-group-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  get_item_voucher_analysis_group(response.data)
                },
                error : function(data,status,xhr){

                }
        });
});

function get_item_voucher_analysis_group(response){
              total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0; total_outwards_value=0;
                let  html=[];
                //stock in
                html.push(`<tr><td style="font-weight: bolder;font-size: 18px;" colspan="6">Movement Purchase</td></tr> `);
                if(response.purchase){
                    response.purchase[0]? html.push(`<tr><td colspan="6" style="font-weight: bolder;font-size: 16px;">Purchase</td></tr>`):''
                    $.each(response.purchase, function(key, v) {
                           total_inwards_qty+=(v.stock_in_qty||0);total_inwards_value+=(v.stock_in_total||0);
                           html.push(`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;"class="td">${(key+1)}</td>
                                <td  style="width: 3%;color: #0B55C4"class="text-wrap td">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;color: #0B55C4"class="text-wrap td">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;"class="text-wrap td">${(v.stock_in_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;"class="text-wrap td">${(((v.stock_in_total||0)/(v.stock_in_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;"class="text-wrap td">${(v.stock_in_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           </tr> `);
                   });
                }

                html.push(`<tr><td style="font-weight: bolder;font-size: 18px;" colspan="3">Total :</td><td style=";font-size: 16px;font-weight: bolder;">${total_inwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${(Math.abs((total_inwards_value)/(total_inwards_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${total_inwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td></tr>
                <tr><td style="font-weight: bolder;font-size: 18px;" colspan="6">Movement Sale</td></tr>`);

               if(response.sales){
                    response.sales[0]? html.push(`<tr ><td colspan="6" style="font-weight: bolder;font-size: 16px;">Sales</td></tr> `):'';
                    $.each(response.sales, function(key, v) {
                        total_outwards_qty+=(v.stock_out_qty||0);total_outwards_value+=(v.stock_out_total||0);
                        html.push(`<tr id='${v.tran_id},${v.voucher_type_id}' class="left left-data editIcon table-row">
                                <td  style="width: 1%;" class="td">${(key+1)}</td>
                                <td  style="width: 3%;color: #0B55C4"class="text-wrap td">${(v.invoice_no||'')}</td>
                                <td  style="width: 3%;color: #0B55C4"class="text-wrap td">${(v.ledger_name||'')}</td>
                                <td  style="width: 3%;" class="text-wrap td">${(v.stock_out_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;" class="text-wrap td">${(((v.stock_out_total||0)/(v.stock_out_qty||0)||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                <td  style="width: 3%;" class="text-wrap td">${(v.stock_out_total||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr> `);
                    });
               }

               html.push(`<tr><td style="font-weight: bolder;font-size: 18px;" colspan="3">Total :</td><td style=";font-size: 16px;font-weight: bolder;">${total_outwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${(Math.abs((total_outwards_value)/(total_outwards_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style=";font-size: 16px;font-weight: bolder;">${total_outwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td></tr> `);

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
