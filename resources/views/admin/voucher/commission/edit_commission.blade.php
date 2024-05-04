
@extends('layouts.backend.app')
@section('title','Edit Voucher Commission')
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('libraries/css/jquery-ui.theme.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('libraries/css/jquery-ui.min.css')}}">
<!-- model style -->
<style> .form-control {
    font-size: 15px;
    border-radius: 3px;
    border: 1px solid #ccc;
    }
    textarea.form-control {
    min-height: calc(1.5em + 0.75rem + 42px);
   }
   .customers th {
    background-color: #1AB0C3;
    color: white;
}
.table > :not(:first-child) {
    border-top: 0px solid currentColor;
}
</style>
@endpush
@section('admin_content')
<div class="pcoded-content  " style="background-color: #e5e5cd!important">
    <div class="pcoded-inner-content  " >
      <br>
        <!-- Main-body start -->
        <div class="main-body ">
          <div class="page-wrapper m-t-0 m-l-1  p-10">
            <!-- Page-header start -->
            <div class="page-header m-2 p-0">
              <div class="row align-items-end" style="margin-bottom: 0%px !important;" >
                <div class="col-lg-8 ">
                  <div class="page-header-title m p-0" style="margin-bottom:7px !important;">
                    <div class="d-inline ">
                      <h4 style="color: green;font-weight: bold;">{{$voucher->voucher_name}} [Update]</h4>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 " >
                    <div style="float: right; margin-left: 5px;"  >
                        <a  style=" float:righttext-decoration: none; " href="{{route('voucher-purchase.create')}}"><span class="fa fa-info-circle m-1" style="font-size:27px; color:#00b8e6;"></span><span style="float:right;margin:2px; padding-top:5px; color: color: white;#">Help</span></a>
                    </div>
                    <div style="float: right;margin-left:9px" >
                      <a  style=" float:righttext-decoration: none; " href="{{route('voucher-dashboard')}}"><span class="fa fa-times-circle-o m-1" style="font-size:27px; color:#ff6666;"></span><span style="float:right;margin:2px; padding-top:5px; ">Close</span></a>
                   </div>
                   <div style="float: right; margin-left:9px">
                      <a  style=" float: righttext-decoration: none; " href="{{route('daybook-report.index')}}"><span class="fa fa-eye m-1" style="font-size:27px; color:#00b8e6;"></span><span style="float:right;margin:2px; padding-top:5px; ">View</span></a>
                  </div>

                </div>
                    <hr style="margin-bottom: 0px;">
              </div>

            </div>
                <div class="page-body">
                 <form id="show_commission_id" method="POST">
                        @csrf
                    <div class="row" style="border: 1px solid red;margin-left:3px;">
                        <div class="col-sm-4" >
                            <label>Party's A/C Name:</label>
                            <select  style="border-radius: 15px;" name="party_ledger_id"  class="form-control m-1 js-example-basic-single party_ledger_id" required>
                                    <option value="0">--Select--</option>
                                    {!!html_entity_decode($ledger_commission_tree)!!}
                            </select>
                        </div>
                        <div class="col-sm-4" >
                            <label>Commission Ledger : </label>
                            <select  style="border-radius: 15px;" name="commission_ledger_id"  class="form-control m-1 js-example-basic-single commission_ledger_id" required>
                                    <option value="0">--Select--</option>
                                    {!!html_entity_decode($ledger_commission_tree)!!}
                            </select>
                        </div>
                        <div class="col-sm-4" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Date From :</label>
                                    <input type="date" name="from_date" class="form-control from_date" value="{{$data->commission_from_date	}}"/>
                                </div>
                                <div class="col-sm-6">
                                    <label>Date From :</label>
                                    <input type="date" name="to_date" class="form-control to_date" value="{{$data->commission_to_date	}}"/>
                                </div>
                            </div>
                    </div>
                    <button  type="submit" class="btn btn-info m-2" style="width: 200px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span  >Search</span></button>
                </form>
                </div>
        <form id="edit_commission" method="POST">
            @csrf
            {{ method_field("PUT") }}
            <div class="row">
                <div class="col-sm-4" >
                    <label style="float: left; margin:2px;">Invoice No:</label>
                    <input type="text" name="invoice_no"   class="form-control m-1" value="{{$data->invoice_no}}"   style="color: green" required/>
                    <span id='error_voucher_no' class="text-danger"></span>
                    <input type="hidden" name="voucher_id" class="form-control voucher_id" value="{{$voucher->voucher_id ?? ''}}" />
                    <input type="hidden" name="ch_4_dup_vou_no" class="form-control " value="{{$voucher->ch_4_dup_vou_no ?? ''}}" >
                    <input type="hidden" name="invoice" class="form-control" value="{{$voucher->invoice ?? ''}}" />
                    <input type="hidden" name="party_ledger_id" class="form-control party_ledger"/>
                    <input type="hidden" name="commission_ledger_id" class="form-control commission_ledger"/>
                    <input type="hidden" name="commission_from_date" class="form-control commission_from_date"/>
                    <input type="hidden" name="commission_to_date" class="form-control commission_to_date"/>
                    <input type="hidden" name="credit_id" class="form-control" value="{{$debit_credit_data[1]->debit_credit_id}}">
                    <input type="hidden" name="debit_id" class="form-control" value="{{$debit_credit_data[0]->debit_credit_id}}">
                    <div class="row">
                        <div class="col-sm-6" >
                            <label style="float: left;  margin:2px; margin-right:29px;">Ref No:</label>
                            <input type="text" name="ref_no" class="form-control m-1" value="{{$data->ref_no}}"  required />
                        </div>
                        <div class="col-sm-6" >
                            <label style="float: left;  margin:2px; margin-right:29px;"> Date :</label>
                            <input type="date"name="invoice_date"  value="{{$data->transaction_date}}"class="form-control "/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <label style="margin-left:2px; ">Narration:</label>
                    <textarea style="margin:15px;" name="narration" rows="2.5" cols="2.5" class="form-control" >{{$data->narration??''}}</textarea>
                </div>
          </div>
            <div class="row">
                <div class="dt-responsive table-responsive cell-border sd ">
                    <table  id="example"  style=" border-collapse: collapse; "   class="table table-striped customers " >
                       <thead >
                            <tr>
                                <th style="width: 3%;  border: 1px solid #ddd;">SL</th>
                                <th style="width: 3%;  border: 1px solid #ddd;">Particulars</th>
                                <th style="width: 3%;  border: 1px solid #ddd;">Sales<br>Quantity</th>
                                <th style="width: 3%;  border: 1px solid #ddd;">Sales<br>Eff. Rate</th>
                                <th style="width: 3%;  border: 1px solid #ddd;" >Sales<br>Value</th>
                                <th style="width: 3%;  border: 1px solid #ddd;" >Commission<br>[Per Quantity]</th>
                                <th style="width: 3%;  border: 1px solid #ddd;" >Commission<br>[% of Sales Value]</th>
                                <th style="width: 3%;  border: 1px solid #ddd;" >Total Commission</th>
                            </tr>
                        </thead>
                       <tbody id="orders">
                      </tbody>
                      <tfoot>
                        <tr>
                            <th style="width: 3%;  border: 1px solid #ddd;">SL</th>
                            <th style="width: 3%;  border: 1px solid #ddd;">Total :</th>
                            <th style="width: 3%;  border: 1px solid #ddd;" class="sale_qty"></th>
                            <th style="width: 3%;  border: 1px solid #ddd;" class="sale_rate"></th>
                            <th style="width: 3%;  border: 1px solid #ddd;" class="sale_value"></th>
                            <th style="width: 3%;  border: 1px solid #ddd;" class="commission_per_qty"></th>
                            <th style="width: 3%;  border: 1px solid #ddd;" class="commission_per_value"></th>
                            <th style="width: 3%;  border: 1px solid #ddd;" ><input type="number" name="total_commission_per" class="form-control total_commission_per" readonly/> </th>
                        </tr>
                    <tfoot>
                </table>
            </div>
            </div>
            <div align="center">
              <button  type="submit" class="btn btn-info edit_commission_btn" style="width:120px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span  >Update</span></button>
              <button type="button"  class="btn btn-danger deleteIcon" style="width:120px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span >Delete</span></button>
              <a  class="btn btn-danger" style="border-radius: 15px;" href="{{route('voucher-dashboard')}}"><span class="m-1 m-t-1" style="color:#404040;!important"><i class="fa fa-times-circle" style="font-size:20px;" ></i></span><span>Cancel</span></a>
            </div>
        </form>
      </div>
    </div>
 </div>
</div>
</div>
@push('js')
<script type="text/javascript" src="{{asset('libraries/js/jquery-ui.min.js')}}"></script>
<script>
    // ledger edit show
    $('.party_ledger_id').val('{{$debit_credit_data[1]->ledger_head_id}}');
    $('.commission_ledger_id').val('{{$debit_credit_data[0]->ledger_head_id}}');

    let stock_item_commission="{{$stock_item_commission}}";
    // party ledger
    $('.party_ledger').val($('.party_ledger_id').val());
    $('.party_ledger_id').on('change',function(){
        $('.party_ledger').val($('.party_ledger_id').val());
    });

    // commission ledger
    $('.commission_ledger').val($('.commission_ledger_id').val());
    $('.commission_ledger_id').on('change',function(){
        $('.commission_ledger').val($('.commission_ledger_id').val());
    });

    // from date
    $('.commission_from_date').val($('.from_date').val());
    $('.from_date').on('click change',function(){
        $('.commission_from_date').val($('.from_date').val());
    });

    // to date
    $('.commission_to_date').val($('.to_date').val());
    $('.to_date').on('click change',function(){
        $('.commission_to_date').val($('.to_date').val());
    });

$(document).ready(function(){
     var html ='';
     var chart_id=0;
    $.each(JSON.parse(stock_item_commission.replace(/&quot;/g,'"')), function(key, v) {
            var  a='&nbsp;&nbsp;&nbsp;&nbsp;';
        if(chart_id!=v.stock_group_id ){
                html+="<tr class='left left-data editIcon table-row'><td  style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'>"+v.stock_group_name+"</td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td></tr>";

                chart_id=v.stock_group_id;
        }
            html+=`<tr id="${v.stock_comm_id}" class="left left-data editIcon table-row"  data-toggle="modal" data-target="#EditLedgerModel">
                <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                <td  style="width: 3%;  border: 1px solid #ddd;">${a+v.product_name}</td>
                <td  style="width: 3%;  border: 1px solid #ddd;">
                    <input type="number" step="any" name="parqty[]" value="${v.qty}" class="form-control parqty" readonly/>
                </td>
                <td  style="width: 3%;  border: 1px solid #ddd;">
                    <input type="number" step="any" name="par_rate[]" value="${(v.total)/(v.qty)}" class="form-control par_rate" readonly/>
                    <input type="hidden" step="any" name="stock_item_id[]" value="${v.stock_item_id}" class="form-control "/>
                    <input type="hidden" step="any" name="stock_comm_id[]" value="${v.stock_comm_id}" class="form-control "/>
                </td>
                <td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">
                    <input type="number" step="any" name="par_total" value="${v.total}" class="form-control par_total" readonly/>
                </td>
                <td  style="width: 3%;  border: 1px solid #ddd;">
                    <input type="number" step="any" name="commission_parqty[]" class="form-control commission_parqty" value="${v.com_rate}" />
                </td>
                <td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">
                    <input type="number" step="any" name="commission_sale_value[]" class="form-control commission_sale_value" value="${v.com_percent}" />
                </td>
                <td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">
                    <input type="number" step="any" name="commission_amount[]" class="form-control commission_amount" value="${v.com_total}" />
                </td>
            </tr>`;
        });
        $('#orders').append(html);
        $('tbody').find('tr .sl').each(function(i){
          $(this).text(i+1);
        });

    // voucher setup and setting variable
    var amount_decimals="{{company()->amount_decimals}}";

   // calculation total
    function calculation_total(){
        let commission_amount=0;
        $('#orders tr').each(function(i){
            if(parseFloat($(this).find('.commission_amount').val())) commission_amount+=parseFloat($(this).find('.commission_amount').val());
        })
        $('.total_commission_per').val(parseFloat(commission_amount).toFixed(amount_decimals));

    }
    calculation_total();
  $('#orders').on('keyup change','.commission_parqty',function(){
       let commission_parqty=$(this).closest('tr').find('.commission_parqty').val();
       let commission_parvalue=$(this).closest('tr').find('.commission_sale_value').val();
       let parqty=$(this).closest('tr').find('.parqty').val();
       let partotal=$(this).closest('tr').find('.par_total').val();
       if(commission_parqty){
            let total_comm=parseFloat(((parqty)/(partotal))*(100));
            $(this).closest('tr').find('.commission_sale_value').val(parseFloat((total_comm)*(commission_parqty)).toFixed(amount_decimals));
            $(this).closest('tr').find('.commission_amount').val(parseFloat((parqty)*(commission_parqty)).toFixed(amount_decimals));
       }
       calculation_total();
  });
  $('#orders').on('keyup change','.commission_sale_value',function(){
       let commission_parqty=$(this).closest('tr').find('.commission_parqty').val();
       let commission_parvalue=$(this).closest('tr').find('.commission_sale_value').val();
       let parqty=$(this).closest('tr').find('.parqty').val();
       let partotal=$(this).closest('tr').find('.par_total').val();
       if(commission_parvalue){
        let total_comm=parseFloat(((partotal)/(parqty))/(100));
            $(this).closest('tr').find('.commission_parqty').val(parseFloat((total_comm)*(commission_parvalue)).toFixed(amount_decimals));
            $(this).closest('tr').find('.commission_amount').val(parseFloat((total_comm/100)*(parseFloat((total_comm)*(commission_parvalue)))).toFixed(amount_decimals));
       }
      calculation_total();
  });

});

</script>
<script>
// insert purchase
$(document).ready(function(){
$("#show_commission_id").submit(function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  $("#add_purchase_btn").text('Add');
  $.ajax({
          url: '{{ url("show-commission") }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(data,status,xhr) {
            var html ='';
            var chart_id=0;
            $.each(data, function(key, v) {
                 var  a='&nbsp;&nbsp;&nbsp;&nbsp;';
                if(chart_id!=v.stock_group_id ){
                        html+="<tr class='left left-data editIcon table-row'><td  style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'>"+v.stock_group_name+"</td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td><td style='width: 3%;  border: 1px solid #ddd;'></td></tr>";

                        chart_id=v.stock_group_id;
                }
                html+=`<tr id="${v.stock_item_id}" class="left left-data editIcon table-row"  data-toggle="modal" data-target="#EditLedgerModel">
                    <td class="sl" style="width: 3%;  border: 1px solid #ddd;"></td>
                    <td  style="width: 3%;  border: 1px solid #ddd;">${a+v.product_name}</td>
                    <td  style="width: 3%;  border: 1px solid #ddd;">
                        <input type="number" step="any" name="parqty[]" value="${v.qty}" class="form-control parqty" readonly/>
                    </td>
                    <td  style="width: 3%;  border: 1px solid #ddd;">
                        <input type="number" step="any" name="par_rate[]" value="${(v.total)/(v.qty)}" class="form-control par_rate" readonly/>
                        <input type="hidden" step="any" name="stock_item_id[]" value="${v.stock_item_id}" class="form-control "/>
                    </td>
                    <td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">
                        <input type="number" step="any" name="par_total" value="${v.total}" class="form-control par_total" readonly/>
                    </td>
                    <td  style="width: 3%;  border: 1px solid #ddd;">
                        <input type="number" step="any" name="commission_parqty[]" class="form-control commission_parqty" />
                    </td>
                    <td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">
                        <input type="number" step="any" name="commission_sale_value[]" class="form-control commission_sale_value" />
                    </td>
                    <td class="nature_val"  style="width: 3%;  border: 1px solid #ddd;">
                        <input type="number" step="any" name="commission_amount[]" class="form-control commission_amount" />
                    </td>
                </tr>`;
                });
             $('#orders').empty();
             $('#orders').html(html);

                $('tbody').find('tr .sl').each(function(i){
                $(this).text(i+1);
                });
          },
          error : function(data,status,xhr){
              if(data.status==404){
                  swal_message(data.message,'error','Error');
              } if(data.status==422){
                $('#error_voucher_no').text(data.responseJSON.data.invoice_no[0]);

              }
          }
  });
});
$(document).ready(function(){
   $("#edit_commission").submit(function(e) {
        e.preventDefault();
        var id="{{$data->tran_id}}";
        const fd = new FormData(this);
        $("#edit_commission_btn").text('Add');
        $.ajax({
                url:  "{{ url('voucher-commission') }}" + '/' + id,
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data,status,xhr) {
                    swal_message(data.message,'success');
                    $('#error_voucher_no').text('');
                    setTimeout(function () {  window.location.href='{{route("daybook-report.index")}}'; },100);
                },
                error : function(data,status,xhr){
                    if(data.status==404){
                        swal_message(data.message,'error');
                    } if(data.status==422){
                        $('#error_voucher_no').text(data.responseJSON.data.invoice_no[0]);
                    }
                }
        });
    });
});
// delete commission ajax request
$(document).on('click', '.deleteIcon', function(e) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id ="{{$data->tran_id}}";
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
                    url: "{{ url('voucher-commission') }}" + '/' + id ,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success: function (data) {
                        setTimeout(function () {  window.location.href='{{route("daybook-report.index")}}'; },100);
                        swal_message(data.message,'success','Successfully');
                    },
                    error: function () {
                        swal_message(data.message,'error','Error');
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
});
</script>

@endpush
@endsection

