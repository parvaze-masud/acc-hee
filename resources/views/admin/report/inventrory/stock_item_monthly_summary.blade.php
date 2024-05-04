@extends('layouts.backend.app')
@section('title','Stock Item Monthly Summary')
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
 .table-scroll thead tr:nth-child(2) th {
    top: 30px;
}
.th{
    border: 1px solid #ddd;font-weight: bold;
}
.td{
    border: 1px solid #ddd; font-size: 16px;
}

table {width:100%;grid-template-columns: auto auto;}
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Stock Item Monthly Summary',
    'print_layout'=>'landscape',
    'print_header'=>'Stock Item Monthly Summary',
]);

<!-- Page-header component -->
@slot('header_body')
 <form  id="add_stock_item_monthly_summary_form"  method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row m-0 p-0">
        <div class="col-md-3">
            <label>Stock Item : </label>
            <select name="stock_item_id" class="form-control js-example-basic-single stock_item">
                <option value="0">--ALL--</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Godown Name :</label>
            <select name="godown_id" class="form-control  js-example-basic-single godown_id" required>
                <option value="0">All</option>
                @foreach($godowns as $godown)
                  <option value="{{$godown->godown_id}}">{{$godown->godown_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3  m-0 p-0">
            <div class="row  m-0 p-0 ">
                <div class="col-md-6 m-0 p-0 start_date">
                    <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$form_date??date('Y-m-d')}}" >
                </div>
                <div class="col-md-6 m-0 p-0 end_date">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date??date('Y-m-d') }}" >
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <br>
            <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
        </div>
    </div>
</form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_item_register">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers table-scroll">
        <thead>
            <tr>
                <th  rowspan="2" style="width: 1%;">SL.</th>
                <th rowspan="2"style="width: 3%;  border: 1px solid #ddd;">Date</th>
                <th class="th" colspan="3" style=" width: 5%;text-align:center;"class="inwards">Inward Balance</th>
                <th class="th" colspan="3" style=" width: 5%;text-align:center; "class="outwards">Outward Balance</th>
                <th class="th" colspan="3" style=" width: 5%;text-align:center;"class="clasing">Closing Balance</th>

            </tr>
            <tr>
                <th class="th" style="width: 3%;text-align:center;">Quantity</th>
                <th style="width: 3%;text-align:center;" class="inwards_rate th">Rate</th>
                <th style="width: 5%;text-align:center;" class="inwards_value th">Value</th>
                <th style="width: 2%;text-align:center;" class="th">Quantity</th>
                <th style="width: 2%;text-align:center;" class="outwards_rate th">Rate</th>

                <th style="width: 5%;text-align:center;" class="outwards_value th">Value</th>
                <th style="width: 3%;text-align:center;" class="th">Quantity</th>
                <th style="width: 3%;text-align:center;" class="clasing_rate th">Rate</th>
                <th style="width: 5%;text-align:center;" class="clasing_value th">Value</th>

            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 5%;" class="th">Total :</th>
                <th  style="width: 2%;font-size: 18px;" class="th total_inwards_qty"></th>
                <th  style="width: 2%;font-size: 18px;" class="th inwards_rate total_inwards_rate"></th>
                <th  style="width: 5%;font-size: 18px;" class="th inwards_value total_inwards_value"></th>
                <th  style="width: 2%;font-size: 18px;" class="th total_outwards_qty"></th>
                <th  style="width: 3%;font-size: 18px;" class="th outwards_rate total_outwards_rate"></th>
                <th  style="width: 5%;font-size: 18px;" class="th outwards_value total_outwards_value"></th>
                <th  style="width: 3%;font-size: 18px;" class="th total_clasing_qty"></th>
                <th style="width: 2%;font-size: 18px;"  class="th clasing_rate total_clasing_rate"></th>
                <th  style="width: 5%;font-size: 18px;" class="th clasing_value total_clasing_value"></th>
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
<script type="text/javascript" src="{{asset('ledger&item_select_option.js')}}"></script>
<script>
//item tree function
get_item_recursive('{{route("stock-item-select-option-tree") }}');

// stock item get id check
if({{$stock_item_id??0}}!=0){
     $('.stock_item').val({{$stock_item_id??0}});
}
// stock item get id check
if({{$godown_id??0}}!=0){
     $('.godown_id').val({{$godown_id??0}});
}

$(document).ready(function () {
    function get_stock_item_monthly_summary_initial_show(){
        $.ajax({
            url: '{{ route("stock-item-monthly-summary-data") }}',
                method: 'GET',
                data: {
                    to_date:$('.to_date').val(),
                    from_date:$('.from_date').val(),
                    stock_item_id:$('.stock_item').val(),
                    godown_id:$('.godown_id').val()
                },
                dataType: 'json',
                success: function(response) {
                    get_stock_item_monthly_summary_val(response.data)
                },
                error : function(data,status,xhr){
                }
        });
    }
    // stock item get id check
    if({{$stock_item_id??0}}!=0){
        get_stock_item_monthly_summary_initial_show();
    }

    var amount_decimals="{{company()->amount_decimals}}";

    // add stock item monthly summary form
    $("#add_stock_item_monthly_summary_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("stock-item-monthly-summary-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    get_stock_item_monthly_summary_val(response.data)
                },
                error : function(data,status,xhr){
                }
        });
    });

    let  total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0; total_outwards_value=0;total_clasing_qty=0;total_clasing_value=0;

    // stock item monthly summary
    function get_stock_item_monthly_summary_val(response) {
        let total_inwards_qty = 0;
        let total_inwards_value = 0;
        let total_outwards_qty = 0;
        let total_outwards_value = 0;
        let total_clasing_qty = 0;
        let total_clasing_value = 0;

        const openingStock = response.oppening_stock[0] || { total_stock_total_opening_qty: 0, total_stock_total_out_opening: 0 };
        const openingQty =  openingStock.total_stock_total_opening_qty;
        const openingTotal = openingStock.total_stock_total_out_opening;

        // Create a document fragment
        const fragment = document.createDocumentFragment();

        // Opening Balance Row
        const openingBalanceRow = document.createElement('tr');
        openingBalanceRow.innerHTML = `
            <td style="width: 1%;  border: 1px solid #ddd;"></td>
            <td colspan="2" style="width: 3%;"class="td">Opening Balance</td>
            <td style="width: 3%;"class="td"></td>
            <td style="width: 2%;"class="td"></td>
            <td style="width: 3%;"class="td"></td>
            <td style="width: 3%; "class="td"></td>
            <td style="width: 2%;"class="td"></td>
            <td style="width: 3%;"class="td">${((openingQty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td style="width: 3%;"class="td">${(dividevalue((openingTotal||0),(openingQty || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td style="width: 2%;"class="td">${((openingTotal||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>

        `;
        fragment.appendChild(openingBalanceRow);

        // Current Stock Rows
        response.current_stock.forEach((v, key) => {
            const inwardsQty = v.inwards_qty || 0;
            const inwardsValue = v.inwards_value || 0;
            const outwardsQty = v.outwards_qty || 0;
            const outwardsValue = v.outwards_value || 0;
            const currentStockRate = parseFloat(v.current_stock_rate || 0);

            total_inwards_qty += inwardsQty;
            total_inwards_value += inwardsValue;
            total_outwards_qty += outwardsQty;
            total_outwards_value += outwardsValue;
            total_clasing_qty += parseInt((inwardsQty - outwardsQty));
            total_clasing_value += parseInt((inwardsQty - outwardsQty)) * currentStockRate;

            const stockRow = document.createElement('tr');
            stockRow.id = v.transaction_date;
            stockRow.className = 'left left-data editIcon table-row';
            stockRow.innerHTML = `
            <td style="width: 1%;  border: 1px solid #ddd;">${(key + 1)}</td>
            <td class="td" style="width: 3%;" class="text-wrap">${new Date(v.transaction_date).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</td>
            <td class="td" style="width: 3%;">${(inwardsQty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 3%;">${((((inwardsValue / inwardsQty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 3%;">${(inwardsValue.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 3%;">${(outwardsQty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 2%;">${((((outwardsValue / outwardsQty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 3%;">${(outwardsValue.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 3%;">${((parseInt((inwardsQty - outwardsQty))).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 2%;">${(currentStockRate.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            <td class="td" style="width: 3%; ">${((parseInt((inwardsQty - outwardsQty)) * currentStockRate).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
            `;
            fragment.appendChild(stockRow);
        });
        // Append the fragment to the DOM once
        $(".item_body").empty().append(fragment);
        // Update total values
        $('.total_inwards_qty').text(total_inwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_inwards_rate').text(((Math.abs(total_inwards_value) / Math.abs(total_inwards_qty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_inwards_value').text(total_inwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_qty').text(total_outwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_rate').text(((Math.abs(total_outwards_value) / Math.abs(total_outwards_qty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_value').text(total_outwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing_qty').text((parseInt(total_clasing_qty) + openingQty).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing_rate').text(((Math.abs(parseFloat(total_clasing_value)) + (openingTotal)) / Math.abs((total_clasing_qty + openingQty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing_value').text(((parseFloat(total_clasing_value)) + (openingTotal)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

        set_scroll_table();
        get_hover();
    }
});


// table header fixed
$(document).ready(function(){
    // table header fixed
    let display_height=$(window).height();
    $('.tableFixHead_item_register').css('height',`${display_height-280}px`);

});
// stock item  wise  voucher  route
$('.sd').on('click','.table-row',function(e){
    e.preventDefault();
    let date=$(this).closest('tr').attr('id');
    let godown_id=$('.godown_id').val();
    let stock_item_id=$('.stock_item').val();
    url = "{{route('stock-item-register-id-wise', ['date' =>':date', 'stock_item_id'=>':stock_item_id','godown_id'=>':godown_id'])}}";
    url = url.replace(':date',date);
    url = url.replace(':stock_item_id',stock_item_id);
    url = url.replace(':godown_id',godown_id);
    window.location=url;
});
</script>
@endpush
@endsection
