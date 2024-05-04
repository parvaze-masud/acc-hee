@extends('layouts.backend.app')
@section('title','Approve')
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
    .card-block {
        padding: 0.25rem;
    }
    .card {
        margin-bottom: -29px;
    }
    body {
        overflow: hidden;
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
                                            <form id="add_stock_item_prce_form" method="POST">
                                                @csrf
                                                {{ method_field('POST') }}
                                                <div class="row">
                                                    <div class="col-md-3">
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
                                                    <div class="col-md-3">
                                                        <label>Voucher:</label>
                                                        <select name="voucher_id" class="form-control js-example-basic-single voucher_id">
                                                            <option value="0">--ALL--</option>
                                                            @php  $voucher_type_id= 0;  @endphp
                                                            @foreach ($vouchers as $voucher)
                                                              @if($voucher->voucher_type_id==19||$voucher->voucher_type_id==21||$voucher->voucher_type_id==22||$voucher->voucher_type_id==24)
                                                                @if($voucher_type_id!=$voucher->voucher_type_id)
                                                                @php  $voucher_type_id=$voucher->voucher_type_id;  @endphp
                                                                    <option style="color:red;"  value="v{{$voucher->voucher_type_id??''}}">{{$voucher->voucher_type??''}}</option>
                                                                @endif
                                                                <option value="{{$voucher->voucher_id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$voucher->voucher_name}}</option>
                                                               @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Select Status:</label>
                                                        <select name="delivery_status" class="form-control js-example-basic-single delivery_status">
                                                            <option value="">ALL</option>
                                                            <option value="0">Pending</option>
                                                            <option value="1">Approved</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label></label>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:100%">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
                                                <div class="dt-responsive table-responsive cell-border sd tableFixHead_double_header">
                                                    <table  id="tableId"  style=" border-collapse: collapse;"   class="table  customers " >
                                                         <thead >
                                                                <tr>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">SL</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Bill Date</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Invoice<br>No</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Voucher<br>Type</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Distribution<br>Center</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >Cutstomer</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >Balance Query</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Note</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >View</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >Approve Status</th>
                                                               </tr>
                                                            </thead>
                                                        <tbody class="qw" id="myTable">
                                                        </tbody>
                                                            <tfoot>
                                                               <tr>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">SL</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Bill Date</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Invoice<br>No</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Voucher<br>Type</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Distribution<br>Center</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >Cutstomer</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >Balance Query</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;">Note</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >View</th>
                                                                    <th style="width: 3%;  border: 1px solid #ddd;" >Approve Status</th>
                                                               </tr>
                                                            </tfoot>
                                                        </table>
                                                        <div class="col-sm-12 text-center" >
                                                           <span><b>Copyright &copy; 2014-2022 <a href="http://www.hamko-ict.com/">Hamko-ICT.</a> All rights reserved.</b></span>
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
                    var  html = '';
                    $.each(response.data, function(key, v) {
                        html += '<tr  class="left left-data  table-row"  data-toggle="modal">';
                        html += '<td class="sl" style="width: 3%;  border: 1px solid #ddd;">' + (key + 1) + '</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd;">'+join( new Date(v.transaction_date), options,' ')+'</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd;">'+(v.invoice_no?v.invoice_no:'')+'</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd;color:#0B55C4;"><input type="hidden" class="voucher_name" value="'+v.tran_id+'" />'+(v.voucher_name?v.voucher_name:'')+'</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd;">'+(v.godown_name?v.godown_name:'')+'</td>';
                        html += '<td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">' +(v.ledger_name?v.ledger_name:'')+ '</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">';
                        html += '<i>CL: '+(v.credit_limit?v.credit_limit.toFixed('{{company()->amount_decimals}}').replace(/\d(?=(\d{3})+\.)/g, '$&,'):parseFloat(0.00))+'</i><br>';
                        if(v.voucher_type_id==19||v.voucher_type_id==24){
                        if(v.debit_credit_sum.split(",")[0]==2||v.debit_credit_sum.split(",")[0]==4){
                            html += '<i>BL: '+(parseFloat(v.debit_credit_sum.split(",")[1])-parseFloat(v.debit_credit_sum.split(",")[2])).toFixed('{{company()->amount_decimals}}').replace(/\d(?=(\d{3})+\.)/g, '$&,')+' Cr</i>';
                        }else if(v.debit_credit_sum.split(",")[0]==1||v.debit_credit_sum.split(",")[0]==3)
                        html += '<i>BL: '+(parseFloat(v.debit_credit_sum.split(",")[2])-parseFloat(v.debit_credit_sum.split(",")[1])).toFixed('{{company()->amount_decimals}}').replace(/\d(?=(\d{3})+\.)/g, '$&,')+' Dr</i>';
                        }
                        html += '</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd;">'+(v.credit_limit?v.credit_limit:'')+ '</td>';
                        html += '<td  style="width: 3%;  border: 1px solid #ddd;color:#0B55C4;font-size: 16px;">Challan</td>';
                        if(v.delivery_status==0){
                            html += '<td  style="width: 3%;  border: 1px solid #ddd;color:#0B55C4; font-size: 16px;" class="approveIcon"><input type="hidden" class="approve" value="'+v.tran_id+'"/>Approve Now</td>';
                        }else if(v.delivery_status==1){
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;"><div style="color:black;" ><i>Delivery Pending  <br>' + (v.order_approver ? JSON.parse(v.order_approver) : '') + '</i></div> </td>';
                        }else if(v.delivery_status==2){
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;"><div style="color:black;" ><i>Delivery Complade  <br>' + (v.order_approver ? JSON.parse(v.order_approver) : '') + '</i></div> </td>';
                        }
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
// delete commission ajax request
$(document).on('click', '.approveIcon', function(e) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
         var id =$(this).find('.approve').val();
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    url: "{{ url('delivery-approved') }}" + '/' + id ,
                    type : "GET",
                    success:  (response)=> {
                        let html = '<div style="color:black;" ><i>Delivery Pending  <br>'+ (response.data.other_details ? JSON.parse(response.data.other_details) : '') + '</i></div>';
                         $(this).html(html);
                        swal_message(response.message,'success','Successfully');
                    },
                    error: function () {
                        swal_message(response.message,'error','Error');
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
// alert message
function swal_message(data,message,m_title){
  swal({
      title:m_title,
      text: data,
      type: message,
      timer: '1500'
  });

}


</script>
@endpush
@endsection
