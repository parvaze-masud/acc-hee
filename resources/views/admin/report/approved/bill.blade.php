@extends('layouts.backend.app')
@section('title','Bill')
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
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Bill',
    'print_layout'=>'landscape',
    'print_header'=>'Bill',
]);

<!-- Page-header component -->
@slot('header_body')
 <form  id="bill_form"  method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row m-0 p-0">
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
        <div class="col-md-3  m-0 p-0">
            <div class="row  m-0 p-0 ">
                <div class="col-md-6 m-0 p-0 start_date">
                    <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{ date('Y-m-d') }}"   name="narratiaon"  >
                </div>
                <div class="col-md-6 m-0 p-0 end_date">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{ date('Y-m-d') }}"  name="narratiaon"  >
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <br>
            <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
        </div>
        <div class="col-md-5">
            <label></label>
            <div>
                <input class="form-check-input narratiaon" type="checkbox" id="narratiaon" name="narratiaon"  value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1" >
                    Narration
                </label>
                <input class="form-check-input user_info" type="checkbox"  name="last_update"   value="1" >
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    User Info
                </label>
            </div>
        </div>
    </div>
</form>
@endslot

<!-- Main body component -->
@slot('main_body')
 <div class="dt-responsive table-responsive cell-border sd tableFixHead_report">
        <table  id="tableId" style=" border-collapse: collapse; " class="table table-striped customers">
            <thead>
                <tr>
                    <th style="width: 1%;  border: 1px solid #ddd;">SL.</th>
                    <th style="width: 3%;  border: 1px solid #ddd;">Date</th>
                    <th style="width: 3%;  border: 1px solid #ddd;">Particulars</th>
                    <th style="width: 2%;  border: 1px solid #ddd;">Voucher Type</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" >Voucher No</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" class="narration d-none   colunm_none">Narration</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" class="user_name d-none   colunm_none" >User Name</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" >Debit Amount/<br>Inwords Qty</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" >Credit Amount/<br>Outwards Qty</th>

                </tr>
            </thead>
            <tbody id="myTable" class="bill_body">
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 1%;  border: 1px solid #ddd;">SL.</th>
                    <th style="width: 3%;  border: 1px solid #ddd;">Date</th>
                    <th style="width: 3%;  border: 1px solid #ddd;">Particulars</th>
                    <th style="width: 2%;  border: 1px solid #ddd;">Voucher Type</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" >Voucher No</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" class="narration d-none  colunm_none">Narration</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" class="user_name d-none  colunm_none">User Name</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" >Debit Amount/<br>Inwords Qty</th>
                    <th style="width: 3%;  border: 1px solid #ddd;" >Credit Amount/<br>Outwards Qty</th>

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
<script>
$(document).ready(function () {
  var amount_decimals="{{company()->amount_decimals}}";
function  get_bill_initial_show(){
  $.ajax({
        url: "{{ url('bill-data')}}",
        type: 'GET',
        dataType: 'json',
        data:{
            to_date:$('.to_date').val(),
            from_date:$('.from_date').val(),
            voucher_id:$('.voucher_id').val()
        },
        success: function(response) {
            get_bill_val(response)
        }
    })
 }
 $("#bill_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("bill-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    get_bill_val(response)
                },
                error : function(data,status,xhr){
                }
        });
    });
    get_bill_initial_show();
    function get_bill_val(response){
        if($(".user_info").is(':checked')){$('.user_name').removeClass("d-none");$('.user_name').removeClass("colunm_none");}
        if($("#narratiaon").is(':checked')){ $('.narration').removeClass("d-none");$('.narration').removeClass("colunm_none");}

                var html='';
                $.each(response.data, function(key, v) {
                    html+='<tr id='+v.tran_id+","+v.voucher_type_id+' class="left left-data editIcon table-row"> ';
                        html += '<td  style="width: 1%;  border: 1px solid #ddd;">'+(key+1)+'</td>' ;
                        html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+join( new Date(v.transaction_date), options, ' ')+'</td>' ;
                        html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+(v.ledger_name ? v.ledger_name:'')+'</td>' ;
                        html += '<td  style="width: 2%;  border: 1px solid #ddd; font-size: 16px;color:#0B55C4;"><input type="hidden" class="voucher_name" value="'+v.tran_id+'">'+v.voucher_name+'</td>' ;
                        html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+v.invoice_no+'</td>' ;
                        if($("#narratiaon").is(':checked')){
                            html += '<td style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+(v.narration?v.narration:"")+'</td>' ;
                        }
                        if($(".user_info").is(':checked')){
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+(v.narration?v.narration:"")+'</td>' ;
                        }
                        if(v.voucher_type_id==1||v.voucher_type_id==6||v.voucher_type_id==8||v.voucher_type_id==14){
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; text-align: right; font-size: 16px;">'+(v.debit?(v.debit_sum?v.debit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+ 'TK':''):'')+'</td>' ;
                            html += '<td  style="width: 3%;  border: 1px solid #ddd;text-align: right; font-size: 16px;">'+(v.credit?(v.credit_sum?v.credit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+ 'TK':''):'')+'</td>' ;
                        }else{
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; text-align: right; font-size: 16px;">'+(v.stock_in_sum?Math.abs(parseFloat(v.stock_in_sum)).toFixed(amount_decimals):'')+'</td>' ;
                            html += '<td  style="width: 3%;  border: 1px solid #ddd;text-align: right; font-size: 16px;">'+(v.stock_out_sum?Math.abs(parseFloat(v.stock_out_sum)).toFixed(amount_decimals):'')+'</td>' ;
                        }
                    html+="</tr> ";
                });
        $(".bill_body").html(html);
        set_scroll_table();
        get_hover();
    }
});
//get  all data show
$(document).ready(function () {
    $('#tableId').on('click','td',function(e){
        e.preventDefault();
        let   id=$(this).find('.voucher_name').val();
        if(id){
            window.location = "{{url('approve')}}" + '/' +id ;
        }


     })

});
</script>
@endpush
@endsection
