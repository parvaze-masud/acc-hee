@extends('layouts.backend.app')
@section('title','Voucher')
@push('css')
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
@section('admin_content')
<br>
@php
 $page_wise_setting_data=page_wise_setting(Auth::user()->id,3);
 if($page_wise_setting_data){
    $redirect=$page_wise_setting_data->redirect_page;

 }else{
    $redirect=3;
 }
@endphp
<!-- voucher add model  -->
@component('components.create', [
    'title'    => 'Accounts Voucher [New]',
    'help_route'=>route('voucher.index'),
    'close_route'=>route('master-dashboard'),
    'veiw_route'=>route('voucher.index'),
    'form_id' => 'add_voucher_form',
    'method'=> 'POST',
])
    @slot('body')
      <div class="row">
        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-6" >
            <div class="card-block ">
                <fieldset class="border p-2">
                    <legend  class="float-none w-auto p-2">General Fields</legend>
                        <div class="form-group">
                        <label for="formGroupExampleInput">Voucher Name:</label>
                        <input type="text" name="voucher_name" class="form-control "  id="formGroupExampleInput" placeholder="Voucher Name" >
                        <span id='error_voucher_name' class=" text-danger"></span>
                        </div>
                        <div class="form-group ">
                            <label for="formGroupExampleInput2">Voucher Type</label>
                            <select name="voucher_type_id"  class="form-control  js-example-basic-single  voucher_type " required>
                                <option value="" >-- select one --</option>
                                @foreach ($voucher_types as $voucher_type)
                                <option value="{{$voucher_type->voucher_type_id}}">{{$voucher_type->voucher_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="formGroupExampleInput2">Category :</label>
                            <select name="category"  class="form-control  js-example-basic-single   left-data" required>
                                <option value="normal">Normal</option>
                                <option value="All">All</option>
                                <option value="Pos">POS</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="border p-2">
                    <legend  class="float-none w-auto p-2">Number Settings</legend>
                            <div class="form-group ">
                            <label for="formGroupExampleInput2">Number Method :</label>
                            <select name="vouchernumbermethod"  class="form-control  js-example-basic-single voucher_type_id  left-data" required>
                                <option value="1">Full Automatic [ Singular Number ]</option>
                                <option value="2">Semi Automatic [ Manual Text + Number ]</option>
                                <option value="3">Semi Automatic [ Manual Text + Timeframe+ Number ]</option>
                                <option value="4">Full Manual</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <label for="formGroupExampleInput">Manual Text :</label>
                            <input type="text" name="manual_text" class="form-control manual" disabled id="formGroupExampleInput" placeholder="Manual Text" >
                            </div>

                            <div class="form-group row  "  >
                            <label for="formGroupExampleInput2">Timeframe : </label>
                            <div class="col-md-4">
                                <select name="time_frame_year"  class="form-control  js-example-basic-single   left-data time_frame" id="year" required disabled>
                                <option value="0">-- select one --</option>
                                <optgroup label="Year">Year</optgroup>
                                <option value="1">Year/ [2 digits]</option>
                                <option value="2">Year- [2 digits]</option>
                                <option value="3">Year/ [4 digits]</option>
                                <option value="4">Year- [4 digits]</option>
                                <optgroup label="Month">Month</optgroup>
                                <option value="5">Month/ [ 01-12 ]</option>
                                <option value="6">Month- [ 01-12] </option>
                                <option value="7">Month/ [ Jan-Dec ]</option>
                                <option value="8">Month/ [ Jan-Dec ]</option>
                                <optgroup label="Day">Day</optgroup>
                                <option value="9">Day/ [01-31 ]</option>
                                <option value="10">Day/ [01-31 ]</option>
                                <optgroup label="Time">Time</optgroup>
                                <option value="11">Hour/ [00-23]</option>
                                <option value="12">Hour- [00-23]</option>
                                <option value="13">Minute/ [00-59]</option>
                                <option value="14">Minute/ [00-59]</option>
                                <option value="15">Second/ [00-59]</option>
                                <option value="16">Second/ [00-59]</option>
                            </select>
                            </div>
                            <div class="col-md-4">
                                    <select name="time_frame_month"  class="form-control  js-example-basic-single   left-data time_frame" id="month" required disabled>
                                        <option value="0">-- select one --</option>
                                        <optgroup label="Year">Year</optgroup>
                                        <option value="1">Year/ [2 digits]</option>
                                        <option value="2">Year- [2 digits]</option>
                                        <option value="3">Year/ [4 digits]</option>
                                        <option value="4">Year- [4 digits]</option>
                                        <optgroup label="Month">Month</optgroup>
                                        <option value="5">Month/ [ 01-12 ]</option>
                                        <option value="6">Month- [ 01-12] </option>
                                        <option value="7">Month/ [ Jan-Dec ]</option>
                                        <option value="8">Month/ [ Jan-Dec ]</option>
                                        <optgroup label="Day">Day</optgroup>
                                        <option value="9">Day/ [01-31 ]</option>
                                        <option value="10">Day/ [01-31 ]</option>
                                        <optgroup label="Time">Time</optgroup>
                                        <option value="11">Hour/ [00-23]</option>
                                        <option value="12">Hour- [00-23]</option>
                                        <option value="13">Minute/ [00-59]</option>
                                        <option value="14">Minute/ [00-59]</option>
                                        <option value="15">Second/ [00-59]</option>
                                        <option value="16">Second/ [00-59]</option>
                                    </select>
                            </div>
                            <div class="col-md-4">
                                <select name="time_frame_day"  class="form-control  js-example-basic-single   left-data time_frame" id="time" required disabled>
                                    <option value="0">-- select one --</option>
                                    <optgroup label="Year">Year</optgroup>
                                    <option value="1">Year/ [2 digits]</option>
                                    <option value="2">Year- [2 digits]</option>
                                    <option value="3">Year/ [4 digits]</option>
                                    <option value="4">Year- [4 digits]</option>
                                    <optgroup label="Month">Month</optgroup>
                                    <option value="5">Month/ [ 01-12 ]</option>
                                    <option value="6">Month- [ 01-12] </option>
                                    <option value="7">Month/ [ Jan-Dec ]</option>
                                    <option value="8">Month/ [ Jan-Dec ]</option>
                                    <optgroup label="Day">Day</optgroup>
                                    <option value="9">Day/ [01-31 ]</option>
                                    <option value="10">Day/ [01-31 ]</option>
                                    <optgroup label="Time">Time</optgroup>
                                    <option value="11">Hour/ [00-23]</option>
                                    <option value="12">Hour- [00-23]</option>
                                    <option value="13">Minute/ [00-59]</option>
                                    <option value="14">Minute/ [00-59]</option>
                                    <option value="15">Second/ [00-59]</option>
                                    <option value="16">Second/ [00-59]</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="text_year" class="text_year"  >
                        <input type="hidden" name="text_month" class="text_month"  >
                        <input type="hidden" name="text_time" class="text_time" >
                        <div class="form-group  row ">
                            <label class="col-md-3 col-form-label ">Current Number :</label>
                            <div class="col-md-8">
                                <div class='basket-card' style="align-content:center;">
                                    <div class="row current_number">
                                        <div class="col-md-1">
                                            <button type="button" class="decrement"  id="decrement" >-</button>
                                        </div>
                                        <div class="col-md-2">
                                            <h3 class="rounded-button qty" id="qty">1</h3>
                                            <input type="hidden" name="current_no" class="current_no" value="1">
                                        </div>
                                        <div class="col-md-2">
                                          <button type="button" class="inc"  id="inc" >+</button>
                                        </div>
                                   </div>
                            </div>
                        </div>
                        <div class="form-group row mixcalculation">
                            <label class="col-md-3" for="formGroupExampleInput2 "> next Invoice Number : </label>
                            <h3 class="rounded-button qty col-md-8" id="invoice_number">1</h3>
                            <input type="hidden" name="invoice" class="invoice" value="1">
                        </div>
                    </div>
                    </fieldset>
                    <fieldset class="border p-2" style="background: #ddffff!important">
                    <legend  class="float-none w-auto p-2">Auto Reset Settings</legend>
                       <label for="formGroupExampleInput">Auto Reset Period :</label>
                        <div class="form-group">
                            <input class="form-check-input" type="radio"  name="auto_reset_period" value="1" checked="checked">
                            <label class="form-check-label fs-6" for="flexRadioDefault1" >
                                Never
                            </label><br>
                            <input class="form-check-input" type="radio"  name="auto_reset_period" value="2"  >
                            <label class="form-check-label fs-6" for="flexRadioDefault1">
                                Yearly : auto reset on every 1st January.
                            </label><br>
                            <input class="form-check-input" type="radio"  name="auto_reset_period" value="3" >
                            <label class="form-check-label fs-6" for="flexRadioDefault1">
                                Yearly : auto reset on every financial start date. (here it is : 30th June)
                            </label><br>
                            <input class="form-check-input" type="radio"  name="auto_reset_period" value="4" >
                            <label class="form-check-label fs-6" for="flexRadioDefault1">
                                Monthly : auto reset on every 1st day of month.
                            </label><br>
                        </div>
                        <div class="form-group ">
                            <label for="formGroupExampleInput2">Auto Reset Starting Number  :</label>
                            <input type="number" name="starting_number" class="form-control "  id="formGroupExampleInput" placeholder="Auto Reset Starting Number " >
                        </div>
                    </fieldset>
                    <fieldset class="border p-2" >
                    <legend  class="float-none w-auto p-2">Advance Settings</legend>
                        <div class="form-group advance_setting">
                        </div>
                    </fieldset>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 col-sm-6 col-xs-6 "  >
            <div class="card-block  " style="padding-left:0px;">
                <div class=" m-t-0 " style="">
                    <div style="margin-left: 0px;">
                        <fieldset class="border p-2">
                            <legend  class="float-none w-auto p-2">Optional Settings</legend>
                                <div class="form-group ">
                                    <label for="formGroupExampleInput2">Unit/Branch :</label>
                                    <select name="branch_id"  class="form-control  js-example-basic-single   left-data" required>
                                        <option value="0">-- select one --</option>
                                        @foreach ($branch as $data)
                                        <option value="{{$data->id }}">{{ $data->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="formGroupExampleInput2">Godown :</label>
                                        <select name="godown_id"  class="form-control  js-example-basic-single   left-data" required>
                                            <option value="0">-- select one --</option>
                                            @foreach ($godown as $data)
                                            <option value="{{$data->godown_id }}">{{ $data->godown_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="formGroupExampleInput2"> Godown's Motive :</label>
                                        <select name="godown_motive"  class="form-control  js-example-basic-single   left-data" required>
                                            <option value="1">Normal[available for each row]</option>
                                            <option value="2">Readonly</option>
                                            <option value="3">Hidden</option>
                                            <option value="4">Top</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row d-none destination">
                                    <div class="col-md-6">
                                        <label for="formGroupExampleInput2">Destination Godown:</label>
                                        <select name="destination_godown_id"  class="form-control  js-example-basic-single   left-data" required>
                                            <option value="0">-- select one --</option>
                                            @foreach ($godown as $data)
                                            <option value="{{$data->godown_id }}">{{ $data->godown_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="formGroupExampleInput2"> Godown's Motive :</label>
                                        <select name="godown_motive"  class="form-control  js-example-basic-single   left-data" required>
                                            <option value="1">Normal[available for each row]</option>
                                            <option value="2">Readonly</option>
                                            <option value="3">Hidden</option>
                                            <option value="4">Top</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="formGroupExampleInput2">Select Date Time :</label>
                                    <select name="select_date"  class="form-control  js-example-basic-single   select_date" required>
                                        <option value="current_date">Current Date</option>
                                        <option value="last_insert_date">Last Insert Date</option>
                                        <option value="fix_date">Fixt Date</option>
                                    </select>
                                </div>
                                <div class="form-group date_show">
                                </div>
                                <div class="form-group ">
                                    <label for="formGroupExampleInput2">Default Debit Ledger :</label>
                                    <select name="debit"  class="form-control  js-example-basic-single  " required>
                                        <option value="0">-- select one --</option>
                                        @foreach ( $debitLedger as $debitLedgers)
                                          <option value="{{$debitLedgers->ledger_head_id}}">{{$debitLedgers->ledger_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-group " style="margin-left: 30px;">
                                        <label for="formGroupExampleInput2">Group  Range 1:</label>
                                        <select  name="debit_group_id_array[]" class="form-control  js-example-basic-single   " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                        <label for="formGroupExampleInput2">Group  Range 2:</label>
                                        <select  name="debit_group_id_array[]" class="form-control  js-example-basic-single  " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                        <label for="formGroupExampleInput2">Group  Range 3:</label>
                                        <select  name="debit_group_id_array[]"  class="form-control  js-example-basic-single  " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                        <label for="formGroupExampleInput2">Group  Range 4:</label>
                                        <select   name="debit_group_id_array[]"  class="form-control  js-example-basic-single  " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="formGroupExampleInput2">Default Credit Ledger :</label>
                                    <select name="credit"  class="form-control  js-example-basic-single   " required>
                                        <option value="0">-- select one --</option>
                                        @foreach ( $creditLedger as $creditLedgers)
                                          <option value="{{$creditLedgers->ledger_head_id}}">{{$creditLedgers->ledger_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-group " style="margin-left: 30px;">
                                        <label for="formGroupExampleInput2">Group  Range 1:</label>
                                        <select  name="credit_group_id_array[]"  class="form-control  js-example-basic-single  " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                        <label for="formGroupExampleInput2">Group  Range 2:</label>
                                        <select  name="credit_group_id_array[]"  class="form-control  js-example-basic-single   " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                        <label for="formGroupExampleInput2">Group Ledger  Range 3:</label>
                                        <select  name="credit_group_id_array[]" class="form-control  js-example-basic-single  " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                        <label for="formGroupExampleInput2">Group  Range 4:</label>
                                        <select  name="credit_group_id_array[]"  class="form-control  js-example-basic-single   " required>
                                            <option value="0">-- select one --</option>
                                            {!!html_entity_decode($group_chart)!!}
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="formGroupExampleInput2">Pricing System  :</label>
                                            <select name="price_type_id" class="form-control js-example-basic-single price_type_id">
                                                <option value="1">Selling Price</option>
                                                <option value="2">Purchage/Standard Price </option>
                                                <option value="3">Wholesale Price</option>
                                                <option value="4">POS Price</option>
                                                <option value="5">Last Insert Price</option>
                                                <option value="6">Average Price</option>
                                            </select>
                                    </div>
                                    <div class="form-group d-none destination">
                                        <label for="formGroupExampleInput2">Destination Pricing System  :</label>
                                            <select name="destrination_price_type_id" class="form-control js-example-basic-single price_type_id">
                                                <option value="1">Selling Price</option>
                                                <option value="2">Purchage/Standard Price </option>
                                                <option value="3">Wholesale Price</option>
                                                <option value="4">POS Price</option>
                                                <option value="5">Last Insert Price</option>
                                                <option value="6">Average Price</option>
                                            </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="formGroupExampleInput2">Commission  :</label>
                                            <select name="commission_type_id" class="form-control js-example-basic-single commission_type_id" required >
                                                <option value=''>-- select one --</option>
                                                <option value="1">Stock Group</option>
                                                <option value="2">Stock_item</option>
                                            </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endslot
    @slot('footer')
        <div class="col-lg-6 ">
            <div class="form-group">
                <button type="submit"  id="add_voucher_btn" class="btn hor-grd btn-grd-primary btn-block submit" style="width:100%" >Add</button>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
            <a class=" btn hor-grd btn-grd-success btn-block " href="{{route('master-dashboard')}}" style="width:100%">Close</a>
            </div>
        </div>
    @endslot
 @endcomponent
@push('js')
<!-- table hover js -->
<script>
$(document).ready(function() {
    $('.voucher_type').on('change',function(){
        var voucher=$(this).val();
        if(voucher==21){
            $('.destination').toggleClass("d-none");
        }else{
            $('.destination').addClass("d-none");
        }
        var data='';
        if(voucher==14||voucher==8||voucher==1 ){
            data+='<input class="form-check-input" type="checkbox"  name="dup_row" checked="checked"  value="1">';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1" >';
            data+='Allow Duplicate Accounts Ledger ?';
            data+='</label><br>';
            data+='<input class="form-check-input dc_amnt" type="checkbox" id="dc_amnt"  name="dc_amnt" checked="checked" value="1">';
            data+=' <label class="form-check-label fs-5" for="flexRadioDefault1">'
            data+=' Allow Total Dr/Cr Amount is 0 ?'
            data+='</label><br>';
            data+='<input class="form-check-input" type="checkbox"  name="amnt_typeable" checked="checked"  value="1">';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Allow Larger Amount than a Ledger/Party current Balance ?';
            data+='</label><br>';
            data+='<input class="form-check-input" type="checkbox"  name="ch_4_dup_vou_no" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Check and Prevent duplicate " Voucher Number " ?';
            data+='</label><br>'
            data+='<input class="form-check-input" type="checkbox"  name="remark_is" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Show Remarks field  with each row ?';
            data+='</label><br>';
            $('.advance_setting').html(data);
        }else if(voucher==10||voucher==24|voucher==19||voucher==23||voucher==29||voucher==22||voucher==25||voucher==21||voucher==6){
            data+='<input class="form-check-input" type="checkbox"  name="dup_row" checked="checked"  value="1">';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1" >';
            data+='Allow Duplicate  Stock Item ?';
            data+='</label><br>';
            data+='<input class="form-check-input total_qty" type="checkbox" id="total_qty"  name="total_qty_is" checked="checked" value="1">';
            data+=' <label class="form-check-label fs-5" for="flexRadioDefault1">'
            data+=' Allow Total  Quantity is 0 ?'
            data+='</label><br>';
            if(voucher==19||voucher==23||voucher==29||voucher==22||voucher==21||voucher==6){
            data+='<input class="form-check-input" type="checkbox"  name="amnt_typeable" checked="checked"  value="1">';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Allow More Quantity Over Current Stock';
            data+='</label><br>';
            }
            data+='<input class="form-check-input dc_amnt" type="checkbox" id="dc_amnt"  name="total_price_is" checked="checked" value="1">';
            data+=' <label class="form-check-label fs-5" for="flexRadioDefault1">'
            data+=' Allow Total Amount is 0 ?'
            data+='</label><br>';
            data+='<input class="form-check-input" type="checkbox"  name="stock_item_price_typeabe" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Allow Custom Price of Stock Item';
            data+='</label><br>'
            data+='<input class="form-check-input" type="checkbox"  name="amount_typeabe" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Allow Custom Amount of Stock Item';
            data+='</label><br>';
            data+='<input class="form-check-input" type="checkbox"  name="ch_4_dup_vou_no" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Check and Prevent duplicate " Voucher Number " ?';
            data+='</label><br>';
            data+='<input class="form-check-input" type="checkbox"  name="remark_is" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Show Remarks field  with each row ?';
            data+='</label><br>'
            if(voucher==19){
            data+='<input class="form-check-input commission_is" type="checkbox"  name="commission_is" checked="checked" value="1" >';
            data+='<label class="form-check-label fs-5" for="flexRadioDefault1">';
            data+='Allow Commission  with each Product/Item ?';
            data+='</label><br>'
            }
            $('.advance_setting').html(data);
            let com_id=$('.commission_is').prop("checked") ? '' : 1 ;

            $('.commission_type_id').val(com_id);
        }
        // Allow Larger Quantity than a Product/Item Current Stock
    });
    $('.advance_setting').on('click',function(){
        let com_id=$('.commission_is').prop("checked") ? '' : 1 ;
        $('.commission_type_id').val(com_id);
    })

    $('.select_date').on('change',function(){
       var fixt_date=$(this).val();
       var data='';
       if(fixt_date=='fix_date'){
        data+='<label for="formGroupExampleInput">Fixt Date:</label>'
        data+='<input type="date" name="fix_date_create" class="form-control " id="formGroupExampleInput" placeholder="Voucher Name" >';
        $('.date_show').html(data);
       }else{
        $('.date_show').empty();
       }
    });
    $('.voucher_type_id').on( 'change',function(e) {
        let mumber_method = $(this).val();
       if(mumber_method==2){
        $('.current_number').show();
        $('.mixcalculation').show();
        $(".manual").attr("disabled", false);
       }
      else if(mumber_method==3){
        $('.current_number').show();
        $('.mixcalculation').show();
        $(".manual").attr("disabled", false);
        $(".time_frame").attr("disabled", false);

       }else if(mumber_method==4){
          $('.mixcalculation').hide();
          $('.current_number').hide();
          $('.invoice').val('');
       }else{
        $('.current_number').show();
        $('.mixcalculation').show();
        $(".time_frame").attr("disabled", true);
        $(".manual").attr("disabled", true);
       }

    });

    $('.manual').empty().on( 'keyup',function(e) {
       let mumber_method = $(this).empty().val();
       let g= $('#qty').text();
       mumber_method=mumber_method+g;
       $('#qty1').empty().text(mumber_method);
    });

    $('#year').on('change',function(e){
        var m_names = ['January', 'February', 'March',
               'April', 'May', 'June', 'July',
               'August', 'September', 'October', 'November', 'December'];

        const d = new Date();
       let value=$(this).val();
       $('.text_year').val(timeframe(value,d,m_names));

    });
    $('#month').on('change',function(e){
        var m_names = ['January', 'February', 'March',
               'April', 'May', 'June', 'July',
               'August', 'September', 'October', 'November', 'December'];

        const d = new Date();
       let value=$(this).val();
       $('.text_month').val(timeframe(value,d,m_names));

    });
    $('#time').on('change',function(e){
        var m_names = ['January', 'February', 'March',
               'April', 'May', 'June', 'July',
               'August', 'September', 'October', 'November', 'December'];

        const d = new Date();
       let value=$(this).val();
       $('.text_time').val(timeframe(value,d,m_names));

    });


    $('.inc').click(function(e){
        e.preventDefault();
        let qty=$('#qty').text();
        qty++;
        $('.qty').text(qty);
        $('.current_no').val(qty);
        invoice_number();
    });
    $('.decrement').click(function(e){
        e.preventDefault();
        let qty=$('#qty').text();
        qty--;
        if(qty>=0)$('.qty').text(qty);
        $('.current_no').text(qty);
        invoice_number();
    });

    $('.manual, #year, #month, #time').on( 'keyup change',function(e) {
        invoice_number();
    })
});
function invoice_number(){
    let manual=$('.manual').val();
    let year=$('.text_year').val();
    let month=$('.text_month').val();
    let time=$('.text_time').val();
    let qty=$('#qty').text();
    let text=manual+year+month+time+qty+'';
    $('#invoice_number').empty().text(text);
    $('.invoice').empty().val(text);


}
function timeframe(value,d,m_names){
    let data='';
    if(value==1){
        data=d.getFullYear().toString().substr(-2)+"/";
    }else if(value==2){
    data=d.getFullYear().toString().substr(-2)+"-";

    }
    else if(value==3){
    data=d.getFullYear()+"/";

    }
    else if(value==4){
    data=d.getFullYear()+"-";

    }
    else if(value==5){
    data=("0" + (d.getMonth() + 1)).slice(-2)+"/";

    }
    else if(value==6){
    data=("0" + (d.getMonth() + 1)).slice(-2)+"-";

    }
    else if(value==7){
    data = m_names[d.getMonth()]+"/";

    }
    else if(value==8){
    data =m_names[d.getMonth()]+"-";

    }
    else if(value==9){
    data =d.getDate()+"/";

    }
    else if(value==10){
    data=d.getDate() +"-";

    }
    else if(value==11){
    data =String( d.getHours()).padStart(2, '0')+"/";

    }
    else if(value==12){
    data =String( d.getHours()).padStart(2, '0')+"-";

    }
    else if(value==13){
    data =String(d.getMinutes()).padStart(2, '0')+"/";

    }
    else if(value==14){
    data  =String(d.getMinutes()).padStart(2, '0')+ "-";

    }
    else if(value==15){
    data =String(d.getSeconds()).padStart(2, '0')+"/";

    }
    else if(value==16){
    data  =String(d.getSeconds()).padStart(2, '0')+ "-";

    }
    return data;
}


$(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

$(function() {
    // add new voucher ajax request
    $("#add_voucher_form").submit('turbolinks:request-end',function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_voucher_btn").text('Adding...');
        $.ajax({
                url: '{{ route("voucher.store") }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    claer_error();
                    swal_message(data.message, 'success', 'Successfully');
                    $("#add_voucher_btn").text('Add Voucher');
                    if({{$redirect}}==0){
                        setTimeout(function () {  window.location.href='{{route("voucher.create")}}'; },100);
                    }else{
                        setTimeout(function () {  window.location.href='{{route("voucher.index")}}'; },100);
                    }

                },
                error : function(data,status,xhr){
                    claer_error();
                    if(data.status==400){
                      swal_message(data.message, 'error', 'Error');
                    } if(data.status==422){
                        claer_error();
                      $('#error_voucher_name').text(data.responseJSON.data.voucher_name[0]);
                    }

                }
        });
    });

});
//data validation data clear
function claer_error(){
    $('#error_voucher_name').text('');
}
function swal_message(data, message, title_mas) {
        swal({
            title: title_mas,
            text: data,
            type: message,
            timer: '1500'
        });
   }
</script>
@endpush
@endsection

