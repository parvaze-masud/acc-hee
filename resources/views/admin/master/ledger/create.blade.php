@extends('layouts.backend.app')
@section('title','Ledger')
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
<!-- ledger add model  -->
@component('components.create', [
    'title'    => 'Ledger Voucher [New]',
    'help_route'=>route('ledger.index'),
    'close_route'=>route('master-dashboard'),
    'veiw_route'=>route('ledger.index'),
    'form_id' => 'add_ledger_form',
    'method'=> 'POST',
])
@php
 $page_wise_setting_data=page_wise_setting(Auth::user()->id,2);
 if($page_wise_setting_data){
    $redirect=$page_wise_setting_data->redirect_page;
    $last_insert=$page_wise_setting_data->last_insert_data_set;
 }else{
    $redirect=3;
    $last_insert=0;
 }
@endphp
 
    @slot('body')
    <div class="row  m-1">
        <div class="form-group col-lg-6">
            <div class="form-group ">
                <label  for="exampleInputEmail1">Ledger Name :</label>
                    <input type="text" name="ledger_name" class="form-control form-control-lg" placeholder="Enter Ledger Name" required>
                    <span id='error_ledger_name' class=" text-danger"></span>
            </div>
            <div class="form-group">
                    <label for="formGroupExampleInput"> Bangla Name Optional :</label>
                    <input type="text" name="bangla_ledger_name" class="form-control " id="formGroupExampleInput" placeholder="Bangla Ledger Name" >
            </div>
            <div class="form-group ">
                <label  for="exampleInputEmail1">Alias :</label>
                <input type="text" name="alias" class="form-control form-control-lg" placeholder="Enter Alias" >
                <span id='error_alias' class=" text-danger"></span>
            </div>
            <div class="form-group ">
                <label  for="exampleInputEmail1">Under Group :</label>
                    <select name="group_id" id="group_id" class="form-control  js-example-basic-single  group_id left-data add_group_id" required>
                        <option value="" >Select</option>
                        {!!html_entity_decode($group_chart_id)!!}
                    </select>
            </div>
            <div class="row">
                <div class="form-group ">
                    <label  for="exampleInputEmail1">Unit/Branch :</label>
                        <select name="unit_or_branch"  class="form-control  js-example-basic-single unit_or_branch" required>
                            <option value="0">--Select--</option>
                            @foreach (unit_branch() as $branch)
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="border border-dark m-1">
                <div class="form-group m-2">
                    <label  for="exampleInputEmail1">Nature of Activities:</label>
                    <select name="nature_activity" id="nature_activity" class="form-control  js-example-basic-single  nature_activity left-data" >
                        <option value="Not Selected">Not Selected</option>
                        <option value="Operating">Operating</option>
                        <option value="Investing">Investing</option>
                        <option value="Financing">Financing</option>
                    </select>
                </div>
                <div class="form-group m-2">
                    <label  for="exampleInputEmail1">Inventory Value Affected ? </label>
                        <select name="inventory_value" id="inventory_value" class="form-control  js-example-basic-single  inventory_value " >
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                </div>
            </div>
            <div class="border border-success m-1 ">
                <div class="form-group m-2">
                    <label  for="exampleInputEmail1">Starting Balance :</label>
                    <input type="number" name="opening_balance" class="form-control form-control-lg" placeholder="Enter Starting Balance">
                </div>
                <div class="form-group m-2">
                    <label  for="exampleInputEmail1">Dr/Cr : </label>
                        <select name="DrCr" id="DrCr" class="form-control  js-example-basic-single  DrCr " >
                            <option value="Dr">Dr</option>
                            <option value="Cr">Cr</option>
                        </select>
                </div>
            </div>
            <div class="form-group ">
                <label  for="exampleInputEmail1">Credit Limit :</label>
                <input type="number" name="credit_limit" class="form-control form-control-lg" placeholder="Enter Credit Limit" >
            </div>
        </div>
        <div class="form-group col-lg-6 ">
            <div class="border border-success">
                <div class="form-group m-2 ">
                    <label  for="exampleInputEmail1">Mailing Name : </label>
                    <input type="text" name="mailing_name" class="form-control form-control-lg" placeholder="Enter Mailing mailing_name" >
                </div>
                <div class="form-group m-2 ">
                    <label  for="exampleInputEmail1">Mobile : </label>
                    <input type="text" name="mobile" class="form-control form-control-lg" placeholder="Enter Mobile">
                </div>
                <div class="form-group m-2 ">
                    <label  for="exampleInputEmail1">Mailing Address : </label>
                    <textarea name="mailing_add" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group m-2">
                        <label  for="exampleInputEmail1">National ID : </label>
                        <input type="text" name="national_id" class="form-control form-control-lg" placeholder="Enter National ID">
                </div>
                <div class="form-group m-2 ">
                    <label  for="exampleInputEmail1">Trade Licence No :</label>
                        <input type="text" name="trade_licence_no" class="form-control form-control-lg" placeholder="Enter Trade Licence No">
                </div>
            </div>
        </div>
    </div>
    @endslot
    @slot('footer')
        <div class="col-lg-6 ">
            <div class="form-group">
                <button type="submit" id="add_ledger_btn" class="btn hor-grd btn-grd-primary  btn-block" style="width:100%">Add</button>
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
$('.add_group_id').on('change', function() {
    localStorage.setItem("add_group_id", $('.add_group_id').val());

});
if({{$last_insert}}==5){ 
    $('.add_group_id').val(localStorage.getItem("add_group_id"))
}
$(function() {
    // add new ledger ajax request
    $("#add_ledger_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_ledger_btn").text('Adding...');
        $.ajax({
                url: '{{ route("ledger.store") }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data,status,xhr) {
                    claer_error();
                    swal_message(data.message, 'success', 'Successfully');
                    $("#add_ledger_btn").text('Add');
                    $("#add_ledger_form")[0].reset();
                    $("#AddLedgerModel").modal('hide');
                    $("#add_ledger_form").get(0).reset();
                    if({{$redirect}}==1){
                        setTimeout(function () {  window.location.href='{{route("ledger.index")}}'; },100);
                    }else{
                        setTimeout(function () {  window.location.href='{{route("ledger.create")}}'; },100);
                    }  
                    

                },
                error : function(data,status,xhr){
                    claer_error();
                    if(data.status==404){
                        swal_message(data.message, 'error', 'Error');
                    } if(data.status==422){
                        claer_error();
                        $('#error_ledger_name').text(data.responseJSON.data.ledger_name?data.responseJSON.data.ledger_name[0]:'');
                        $('#error_alias').text(data.responseJSON.data.alias?data.responseJSON.data.alias[0]:'');
                    }

                }
        });
    });
});
//data validation data clear
function claer_error(){
    $('#error_ledger_name').text('');
    $('#error_alias').text('');
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

