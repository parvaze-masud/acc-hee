@extends('layouts.backend.app')
@section('title','Stock Item Register')
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

table {width:100%;grid-template-columns: auto auto;}
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
    'title' => 'Stock Item Register',
    'print_layout'=>'landscape',
    'print_header'=>'Stock Item Register',
]);

<!-- Page-header component -->
@slot('header_body')
 <form  id="add_item_register_form"  method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row m-0 p-0">
        <div class="col-md-3">
            <label>Stock Item : </label>
            <select name="stock_item_id" class="form-control js-example-basic-single stock_item">
                <option value="0">--ALL--</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Voucher Type : </label>
            <select name="voucher_id" class="form-control js-example-basic-single voucher_id">
                <option value="0">--ALL--</option>
                @php  $voucher_type_id= 0;  @endphp
                @foreach ($vouchers as $voucher)
                    @if($voucher_type_id!=$voucher->voucher_type_id)
                    @php  $voucher_type_id=$voucher->voucher_type_id;  @endphp
                        <option style="color:red;"  value="v{{$voucher->voucher_type_id??''}}">{{$voucher->voucher_type??''}}</option>
                    @endif
                    <option value="{{$voucher->voucher_id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$voucher->voucher_name}}</option>

                @endforeach
            </select>
        </div>
        <div class="col-md-2">
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
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$from_date?? date('Y-m-d') }}"   name="narratiaon"  >
                </div>
                <div class="col-md-6 m-0 p-0 end_date">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date?? date('Y-m-d') }}"  name="narratiaon"  >
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <br>
            <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
        </div>
        <div class="col-md-12">
            <label></label>
            <div>
                <input class="form-check-input inwords_rate_checkbox" type="checkbox"  name="inwords_rate"  value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1" >
                    Inwords Rate
                </label>
                <input class="form-check-input inwords_value_checkbox" type="checkbox"  name="inwords_value"   value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Inwords Value
                </label>
                <input class="form-check-input outwords_rate_checkbox" type="checkbox"  name="outwords_rate"  value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1" >
                    Outwords Rate
                </label>
                <input class="form-check-input outwords_value_checkbox" type="checkbox"  name="outwords_value"   value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Outwords Value
                </label>
                <input class="form-check-input  closing_rate_checkbox" type="checkbox"  name="closing_rate"  value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1" >
                    Closing Rate
                </label>
                <input class="form-check-input closing_value_checkbox" type="checkbox"  name="closing_value"   value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Closing  Value
                </label>
                <input class="form-check-input narratiaon" type="checkbox" id="narratiaon" name="narratiaon"  value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1" >
                    Narration
                </label>
                <input class="form-check-input particular" type="checkbox"  name="particular"   value="1" >
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Particular
                </label>

            </div>
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
                <th rowspan="2" style="width: 1%; text-align:center;" class="th">SL.</th>
                <th rowspan="2"style="width: 3%" class="th" >Date</th>
                <th rowspan="2" style="width: 3%;" class="th">Voucher No</th>
                <th rowspan="2" style="width: 2%;" class="th">Voucher Type</th>
                <th rowspan="2" style="width: 5%;text-align:center;table-layout: fixed;" class="th">Particulars</th>
                <th colspan="3" style=" width: 5%; text-align:center;"class="th inwards">Inward Balance</th>
                <th colspan="3" style=" width: 5%; text-align:center;"class="th outwards">Outward Balance</th>
                <th colspan="3" style=" width: 5%; text-align:center;"class="th closing">Closing Balance</th>

            </tr>
            <tr>
                <th style="width: 3%;" class="th">Quantity</th>
                <th style="width: 3%;" class="th inwards_rate">Rate</th>
                <th style="width: 5%;" class="th inwards_value">Value</th>
                <th style="width: 2%;" class="th">Quantity</th>
                <th style="width: 2%;" class="th outwards_rate">Rate</th>

                <th style="width: 5%;" class="outwards_value th">Value</th>
                <th style="width: 3%;" class="th">Quantity</th>
                <th style="width: 3%;" class="thc losing_rate">Rate</th>
                <th style="width: 5%"  class="th closing_value">Value</th>

            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 5%;" class="th">Total :</th>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 2%;font-size: 18px;" class="th total_inwards_qty"></th>
                <th  style="width: 2%;font-size: 18px;" class="th inwards_rate total_inwards_rate"></th>
                <th  style="width: 5%;font-size: 18px;" class="th inwards_value total_inwards_value"></th>
                <th  style="width: 2%;font-size: 18px;" class="th total_outwards_qty"></th>
                <th  style="width: 3%;font-size: 18px;" class="th outwards_rate total_outwards_rate"></th>
                <th  style="width: 5%;font-size: 18px;" class="th outwards_value total_outwards_value"></th>
                <th  style="width: 3%;font-size: 18px;" class="th total_clasing_qty"></th>
                <th style="width: 2%;font-size: 18px;"  class="th closing_rate total_clasing_rate"></th>
                <th  style="width: 5%;font-size: 18px;" class="th closing_value total_clasing_value"></th>
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

if(localStorage.getItem("voucher_id")){
        $('.voucher_id').val(localStorage.getItem("voucher_id"));
        localStorage.setItem("voucher_id",'');
}
$(document).ready(function () {
    if(localStorage.getItem("end_date")){
        $('.to_date').val(localStorage.getItem("end_date"));
        localStorage.setItem("end_date",'');
    }
    if(localStorage.getItem("start_date")){
        $('.from_date').val(localStorage.getItem("start_date"));
        localStorage.setItem("start_date",'');
    }

});


$(document).ready(function () {
    function get_stock_item_register_initial_show(){
        $.ajax({
            url: '{{ route("stock-item-register-data") }}',
                method: 'GET',
                data: {
                    to_date:$('.to_date').val(),
                    from_date:$('.from_date').val(),
                    stock_item_id:$('.stock_item').val(),
                    godown_id:$('.godown_id').val()
                },
                dataType: 'json',
                success: function(response) {
                    get_item_register_val(response.data)
                },
                error : function(data,status,xhr){
                }
        });
    }
    // stock item get id check
    if({{$stock_item_id??0}}!=0){
        get_stock_item_register_initial_show();
    }

    var amount_decimals="{{company()->amount_decimals}}";
    $("#add_item_register_form").submit(function(e) {

         // checking colspan table
         $('.inwards').attr('colspan',1+($(".inwords_rate_checkbox" ).is(':checked')?1:0)+($(".inwords_value_checkbox" ).is(':checked')?1:0));
        $('.outwards').attr('colspan',1+($(".outwords_rate_checkbox" ).is(':checked')?1:0)+($(".outwords_value_checkbox" ).is(':checked')?1:0));
         $('.closing').attr('colspan',1+($(".closing_rate_checkbox" ).is(':checked')?1:0)+($(".closing_value_checkbox" ).is(':checked')?1:0));

        //checking condition
        $(".inwards_rate").css("display", $(".inwords_rate_checkbox" ).is(':checked')==true?'':'none');
        $(".inwards_value").css("display", $(".inwords_value_checkbox" ).is(':checked')==true?'':'none');
        $(".outwards_rate").css("display", $(".outwords_rate_checkbox" ).is(':checked')==true?'':'none');
        $(".outwards_value").css("display", $(".outwords_value_checkbox" ).is(':checked')==true?'':'none');
        $(".closing_rate").css("display", $(".closing_rate_checkbox" ).is(':checked')==true?'':'none');
        $(".closing_value").css("display", $(".closing_value_checkbox" ).is(':checked')==true?'':'none');

            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route("stock-item-register-data") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                    get_item_register_val(response.data)
                    },
                    error : function(data,status,xhr){
                    }
            });
    });
    let  total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0; total_outwards_value=0;total_clasing_qty=0;total_clasing_value=0;
    function get_item_register_val(response) {
        let total_inwards_qty = 0;
        let total_inwards_value = 0;
        let total_outwards_qty = 0;
        let total_outwards_value = 0;
        let total_clasing_qty = 0;
        let total_clasing_value = 0;

        let html = '';
        let htmlFragment = document.createDocumentFragment();
        let row = document.createElement('tr');

        row.innerHTML=`<td style="width: 1%; border: 1px solid #ddd;"></td>
                        <td colspan="2" style="width: 3%;" class="td">Opening Blance</td>
                        <td style="width:3%;"class="td"></td>
                        <td style="width:2%" class="td"></td>
                        <td style="width:3%" class="td"></td>
                        ${$(".inwords_rate_checkbox").is(':checked') ? `<td style="width: 3%;" class="td"></td>` : `<td style='display:none'></td>`}
                        ${$(".inwords_value_checkbox").is(':checked') ? `<td style="width: 2%;" class="td"></td>` : ''}
                        <td style="width: 3%;" class="td"></td>
                        ${$(".outwords_rate_checkbox").is(':checked') ? `<td style="width: 3%;" class="td"></td>` : ''}
                        ${$(".outwords_value_checkbox").is(':checked') ? `<td style="width: 2%;" class="td"></td>` : ''}
                        <td style="width: 3%;" class="td">${((response.oppening_stock[0]?.total_stock_total_opening_qty || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                        ${$(".closing_rate_checkbox").is(':checked') ? `<td style="width: 3%" class="td">${dividevalue((response.oppening_stock[0]?.total_stock_total_out_opening || 0),(response.oppening_stock[0]?.total_stock_total_opening_qty || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>` : ''}
                        ${$(".closing_value_checkbox").is(':checked') ? `<td style="width: 2%;" class="td">${(((response.oppening_stock[0]?.total_stock_total_out_opening || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ''}
                  `;
        htmlFragment.appendChild(row);
        $.each(response.current_stock, function (key, v) {
                total_inwards_qty += (v.inwards_qty || 0);
                total_inwards_value += (v.inwards_value || 0);
                total_outwards_qty += (v.outwards_qty || 0);
                total_outwards_value += (v.outwards_value || 0);
                total_clasing_qty += (v.current_qty || 0);
                total_clasing_value += (v.current_qty || 0) * (v.current_rate || 0);

                let row = document.createElement('tr');
                row.id = `${v.tran_id},${v.voucher_type_id}`;
                row.className = "left left-data editIcon table-row";
                row.innerHTML = `
                    <td style="width: 1%; border: 1px solid #ddd;">${key + 1}</td>
                    <td style="width: 3%;" class="td text-wrap">${join(new Date(v.transaction_date), options, ' ')}</td>
                    <td style="width: 3%;" class="td text-wrap">${v.invoice_no}</td>
                    <td style="width: 2%;" class="td"><a class="item_register_voucher" style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="#" class="text-wrap">${v.voucher_name}</a></td>
                    <td style="width: 3%;" class="td text-wrap">${(v.ledger_name ? v.ledger_name : '')}</td>
                    <td style="width: 3%;" class="td" >${(v.inwards_qty || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    ${$(".inwords_rate_checkbox").is(':checked') ? `<td style="width:3%;" class="td">${((((v.inwards_value || 0) / (v.inwards_qty || 0)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ""}
                    ${$(".inwords_value_checkbox").is(':checked') ? `<td style="width: 3%;" class="td">${((v.inwards_value || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ''}
                    <td style="width: 3%;" class="td">${(v.outwards_qty || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    ${$(".outwords_rate_checkbox").is(':checked') ? `<td style="width: 2%;" class="td">${((((v.outwards_value || 0) / (v.outwards_qty || 0)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ""}
                    ${$(".outwords_value_checkbox").is(':checked') ? `<td style="width: 3%" class="td">${((v.outwards_value || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ''}
                    <td style="width: 3%;" class="td">${(v.current_qty || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    ${$(".closing_rate_checkbox").is(':checked') ? `<td style="width: 2%;" class="td">${((v.current_rate || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ''}
                    ${$(".closing_value_checkbox").is(':checked') ? `<td style="width: 3%;" class="td">${(((v.current_qty || 0) * (v.current_rate || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>` : ''}
                `;

                htmlFragment.appendChild(row);
            });

            $(".item_body").html(htmlFragment);
            $('.total_inwards_qty').text(total_inwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_inwards_rate').text(((Math.abs(total_inwards_value) / Math.abs(total_inwards_qty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_inwards_value').text(total_inwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_outwards_qty').text(total_outwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_outwards_rate').text(((Math.abs(total_outwards_value) / Math.abs(total_outwards_qty)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_outwards_value').text(total_outwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_clasing_qty').text((total_clasing_qty + (response.oppening_stock[0]?.total_stock_total_opening_qty || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_clasing_rate').text(((Math.abs((total_clasing_value) +(response.oppening_stock[0]?.total_stock_total_out_opening || 0))) / Math.abs((total_clasing_qty + (response.oppening_stock[0]?.total_stock_total_opening_qty || 0))) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.total_clasing_value').text(((total_clasing_value) + (response.oppening_stock[0]?.total_stock_total_out_opening || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            set_scroll_table();
            get_hover();
   }
});
//on click redirect url
$(document).ready(function () {
    $('.sd').on('click','.customers tbody tr ',function(e){
        localStorage.setItem("end_date",$('.to_date').val());
        localStorage.setItem("start_date",$('.from_date').val());
        localStorage.setItem("voucher_id",$('.voucher_id').val());
        e.preventDefault();
        let item_register_arr=$(this).closest('tr').attr('id').split(",");
          window.location = "{{url('voucher-receipt/edit')}}" + '/' + item_register_arr[0] ;
        if(item_register_arr[1]==14){
            window.location = "{{url('voucher-receipt/edit')}}" + '/' + item_register_arr[0] ;
        }else if(item_register_arr[1]==8){
            window.location = "{{url('voucher-payment')}}" + '/' + item_register_arr[0]+'/edit' ;
        }else if(item_register_arr[1]==1){
            window.location = "{{url('voucher-contra')}}" + '/' + item_register_arr[0]+'/edit' ;
        }else if(item_register_arr[1]==10){
            window.location = "{{url('voucher-purchase')}}" + '/' + item_register_arr[0]+'/edit' ;
        }else if(item_register_arr[1]==24){
            window.location = "{{url('voucher-grn')}}" + '/' + item_register_arr[0]+'/edit' ;
        }else if(item_register_arr[1]==19){
            window.location = "{{url('voucher-sales')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==23){
            window.location = "{{url('voucher-gtn')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==29){
            window.location = "{{url('voucher-purchase-return')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==22){
            window.location = "{{url('voucher-transfer')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==25){
            window.location = "{{url('voucher-sales-return')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==21){
            window.location = "{{url('voucher-stock-journal')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==6){
            window.location = "{{url('voucher-journal')}}" + '/' + item_register_arr[0]+'/edit' ;
        }
        else if(item_register_arr[1]==28){
            window.location = "{{url('voucher-commission')}}" + '/' + item_register_arr[0]+'/edit' ;

        }

    })
});

// table header fixed
$(document).ready(function(){
    // table header fixed
    let display_height=$(window).height();
    $('.tableFixHead_item_register').css('height',`${display_height-280}px`);

});
</script>
@endpush
@endsection
