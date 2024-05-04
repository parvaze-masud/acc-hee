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
    'title' => 'Accounts Ledger [edit]',
    'help_route'=>route('ledger.index'),
    'close_route'=>route('master-dashboard'),
    'veiw_route'=>route('ledger.index'),
    'form_id' => 'edit_ledger_form',
    'method'=> 'PUT',
])
    @slot('body')
        <div class="row m-1" >
            <div class="form-group col-lg-6">
                <div class="form-group ">
                    <label  for="exampleInputEmail1">Ledger Name :</label>
                        <input type="hidden" class="id" name="id" >
                        <input type="text" name="ledger_name" class="form-control form-control-lg ledger_name" placeholder="Enter Ledger Name" required>
                        <span id='edit_error_ledger_name' class=" text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput"> Bangla Name Optional :</label>
                    <input type="text" name="bangla_ledger_name" class="form-control bangla_ledger_name" id="formGroupExampleInput" placeholder="Bangla Ledger Name" >
               </div>
                <div class="form-group ">
                    <label  for="exampleInputEmail1">Alias :</label>
                        <input type="text" name="alias" class="form-control form-control-lg alias" placeholder="Enter Alias" >
                        <span id='edit_error_alias' class="text-danger"></span>
                </div>
                <div class="form-group ">
                    <label  for="exampleInputEmail1">Under Group :</label>
                        <select name="group_id" id="group_id" class="form-control  js-example-basic-single  group_id left-data" required>
                            <option value="0">Select</option>
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
                        <select name="nature_activity" id="nature_activity" class="form-control  js-example-basic-single    nature_activity left-data" >
                            <option value="Not Selected">Not Selected</option>
                            <option value="Operating">Operating</option>
                            <option value="Investing">Investing</option>
                            <option value="Financing">Financing</option>
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <label  for="exampleInputEmail1">Inventory Value Affected ? </label>
                            <select name="inventory_value" id="inventory_value" class="form-control   js-example-basic-single  inventory_value left-data" >
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                    </div>
                </div>
                <div class="border border-success m-1 ">
                    <div class="form-group m-2">
                        <label  for="exampleInputEmail1">Starting Balance :</label>
                            <input type="number" name="opening_balance" step="any" class="form-control form-control-lg opening_balance" placeholder="Enter Starting Balance">
                    </div>
                    <div class="form-group m-2">
                        <label  for="exampleInputEmail1">Dr/Cr : </label>
                            <select name="DrCr" id="DrCr" class="form-control  js-example-basic-single   DrCr left-data" >
                                <option value="Dr">Dr</option>
                                <option value="Cr">Cr</option>
                            </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label  for="exampleInputEmail1">Credit Limit :</label>
                        <input type="number" name="credit_limit" class="form-control form-control-lg credit_limit" placeholder="Enter Credit Limit"   >
                </div>
            </div>
            <div class="form-group col-lg-6 ">
                <div class="border border-success">
                    <div class="form-group m-2 ">
                        <label  for="exampleInputEmail1">Mailing Name : </label>
                            <input type="text" name="mailing_name" class="form-control form-control-lg mailing_name" placeholder="Enter Mailing mailing_name" >
                    </div>
                    <div class="form-group m-2 ">
                        <label  for="exampleInputEmail1">Mobile : </label>
                            <input type="text" name="mobile" class="form-control form-control-lg mobile" placeholder="Enter Mobile">
                    </div>
                    <div class="form-group m-2 ">
                        <label  for="exampleInputEmail1">Mailing Address : </label>
                        <textarea name="mailing_add" class="form-control  mailing_add" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="form-group m-2">
                        <label  for="exampleInputEmail1">National ID : </label>
                            <input type="text" name="national_id" class="form-control form-control-lg national_id" placeholder="Enter National ID">

                    </div>
                    <div class="form-group m-2 ">
                        <label  for="exampleInputEmail1">Trade Licence No :</label>
                            <input type="text" name="trade_licence_no" class="form-control form-control-lg trade_licence_no" placeholder="Enter Trade Licence No">
                    </div>
               </div>
            </div>
        </div>
    @endslot
    @slot('footer')
        <div class="col-lg-4 ">
            <div class="form-group" style="margin-left:2px; ">
                <button type="submit" id="edit_ledger_btn" class="btn btn-primary" style="width:100%">Update</button>
            </div>
        </div>
        <div class="col-lg-4">
            @if(user_privileges_check('master','Ledger','delete_role'))
                <div class="form-group">
                    <button  type="button" class="btn btn-danger deleteIcon"  data-dismiss="modal" style="width:100%">Delete</button>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <a class=" btn hor-grd btn-grd-success btn-block " href="{{route('master-dashboard')}}" style="width:100%">Close</a>
            </div>
        </div>
    @endslot
 @endcomponent
@push('js')
<!-- table hover js -->
<script>
let data="{{$data}}";

edit_ledger()
//ledger edit function
function edit_ledger(){
    let  response = JSON.parse(data.replace(/&quot;/g,'"'));
    $(".id").val(response.ledger_head_id );
    $(".ledger_name").val(response.ledger_name);
    $('.bangla_ledger_name').val(response.bangla_ledger_name);
    $('.alias').val(response.alias);
    $(".group_id").val(response.group_id).trigger('change');
    $(".unit_or_branch").val(response.unit_or_branch).trigger('change');
    $(".nature_activity").val(response.nature_activity).trigger('change');
    $(".inventory_value").val(response.inventory_value).trigger('change');
    $('.opening_balance').val(Math.abs(response.opening_balance));
    $(".DrCr").val(response.DrCr).trigger('change');
    $('.credit_limit').val(response.credit_limit);
    $('.mailing_name').val(response.mailing_name);
    $('.mobile').val(response.mobile);
    $('.mailing_add').val(response.mailing_add).trigger('change');
    $('.national_id').val(response.national_id);
    $('.trade_licence_no').val(response.trade_licence_no);

}

     // update group chart ajax request
     $("#edit_ledger_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        var id = $('.id').val();
        $("#edit_ledger_btn").text('Adding...');
        $.ajax({
            url: "{{ url('ledger') }}" + '/' + id ,
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data,status,xhr) {
                    claer_error()
                    swal_message(data.message, 'success', 'Successfully');
                    claer_error()
                    $("#edit_ledger_btn").text('Update');
                    $("#edit_ledger_form")[0].reset();
                    $("#EditLedgerModel").modal('hide');
                    setTimeout(function () {  window.location.href='{{route("ledger.index")}}'; },100);
            },
            error : function(data,status,xhr){
                    if(data.status==404){
                        swal_message(data.message, 'error', 'Error');
                    } if(data.status==422){
                        claer_error();
                        $('#edit_error_ledger_name').text(data.responseJSON.data.ledger_name?data.responseJSON.data.ledger_name[0]:'');
                        $('#edit_error_alias').text(data.responseJSON.data.alias?data.responseJSON.data.alias[0]:'');
                    }

                }
        });
    })
//data validation data clear
function claer_error(){
    $('#error_group_chart_name').text('');
}
// delete ledger ajax request
$(document).on('click', '.deleteIcon', function(e) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id = $('.id').val();
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    url: "{{ url('ledger') }}" + '/' + id ,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success: function (data) {
                        swal_message(data.message, 'success', 'Successfully');
                        location.replace('{{route("ledger.index") }}')
                    },
                    error: function () {
                        location.replace('{{ route("ledger.index") }}')
                        swal_message(data.message, 'error', 'Error');
                    }
                });
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swal(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                )
            }
        })
    });
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

