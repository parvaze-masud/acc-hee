
@extends('layouts.backend.app')
@section('title',' Voucher Journal')
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('libraries/css/jquery-ui.theme.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('libraries/css/jquery-ui.min.css')}}">
<!-- model style -->
<style>
   .form-control {
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
    textarea.form-control {
    min-height: calc(1.5em + -2.25rem + 42px);;
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
                        <a  style=" float:right;text-decoration: none; " href="{{route('voucher-dashboard')}}"><span class="fa fa-info-circle m-1" style="font-size:27px; color:#00b8e6;"></span><span style="float:right;margin:2px; padding-top:5px; color: color: white;#">Help</span></a>
                    </div>
                    <div style="float: right;margin-left:9px" >
                      <a  style=" float:right;text-decoration: none; " href="{{route('voucher-dashboard')}}"><span class="fa fa-times-circle-o m-1" style="font-size:27px; color:#ff6666;"></span><span style="float:right;margin:2px; padding-top:5px; ">Close</span></a>
                   </div>
                   <div style="float: right; margin-left:9px">
                      <a  style=" float: right;text-decoration: none; " href="{{route('daybook-report.index')}}"><span class="fa fa-eye m-1" style="font-size:27px; color:#00b8e6;"></span><span style="float:right;margin:2px; padding-top:5px; ">View</span></a>
                  </div>

                </div>
                    <hr style="margin-bottom: 0px;">
              </div>
            </div>
            <form id="edit_received_id"  method="POST">
                @csrf
                {{ method_field("PUT") }}
            <div class="page-body">
                  <div class="row">
                    <div class="col-sm-4" >
                       <div class="row">
                            <div class="col-sm-3 " style="float: right;" >
                                <label style="float: right; margin:2px;">Invoice No:</label><br><br>
                                <label style="float: right;  margin:2px; margin-right:29px;">Ref No:</label>
                            </div>
                            <div class="col-sm-9 m-0 p-0"  style="margin-left: 5px;!important;" >
                                <input type="text" name="invoice_no"   class="form-control m-1" value="{{$data->invoice_no}}" style="border-radius: 15px;"    style="color: green"   required/>
                                <span id='error_voucher_no' class="text-danger"></span>
                                <input type="hidden" name="ch_4_dup_vou_no" class="form-control " value="{{$voucher->ch_4_dup_vou_no ?? ''}}"/>
                                <input type="hidden" name="invoice" class="form-control" value="{{$voucher->invoice ?? ''}}" />
                                <input type="hidden" name="voucher_id" class="form-control voucher_id" value="{{$voucher->voucher_id ?? ''}}" />
                                <input type="text" name="ref_no" class="form-control m-1" value="{{$data->ref_no}}" style="border-radius: 15px;"/>
                                <input type="hidden" name="delete_stock_out_id" class="form-control delete_stock_out_id" />
                            </div>
                      </div>
                    </div>
                    <div class="col-sm-4" >
                        <div class="row " style="margin-top: 5px;">
                            <div class="col-sm-4 " style="float: right;" >
                                <label style="float: right; margin:2px; margin-right: 82px;;" >Date:</label><br><br>
                                <label  style="float: right;  margin:2px; margin-right: 26px;" for="exampleInputEmail1">Unit / Branch:</label>
                            </div>
                            <div class="col-sm-8 m-0 p-0"  style="margin-left: 5px;!important;" >
                                <input type="date"name="invoice_date"class="form-control " style="margin-bottom: 4px !important;border-radius: 15px;" value="{{$data->transaction_date}}"/>
                                <select style="margin-top: 2px; border-radius: 15px;" name="unit_or_branch"  class="form-control m-1 js-example-basic-single  js-example-basic unit_or_branch" required>
                                    @foreach ($branch_setup as $unit_branchs)
                                    <option  value="{{ $unit_branchs->id }}">{{$unit_branchs->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                      </div>
                    </div>
                    <div class="col-sm-4" >
                        <label style="margin-left:2px; ">Narration:</label>
                        <textarea style="margin-left:2px; border-radius: 15px;" name="narration" rows="2.5" cols="2.5" class="form-control" >{{$data->narration}}</textarea>
                    </div>
                  </div>
                  </div>
                  <div class="col-sm-4 {{$voucher->godown_motive==3?'d-none ':'' }}" >

                    <div class="form-group"  >
                        <label  for="exampleInputEmail1">Godowns :</label>
                        <select name="godown" class="form-control js-example-basic-single   godown left-data" required>
                            @if($voucher->godown_motive==3)
                                <option value="0"></option>
                            @else
                                @foreach ($godowns as $godown)
                                    <option value="{{$godown->godown_id}}">{{$godown->godown_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                  <div class="row">
                    <div class="table-responsive">
                      <table class="table customers " style=" border: none !important; margin-top:5px;" >
                        <thead>
                            <tr >
                                <th class="col-0.5" style="width:46px;">#</th>
                                <th class="col-0.5">Dr/Cr  </th>
                                <th class="col-1.5">Ledger Name</th>
                                <th class="col-1.5">Blance</th>
                                <th class="{{$voucher->remark_is==1?'col-1':'col-1'}}">Product Name</th>
                                <th class="col-1 {{$voucher->godown_motive==3?'d-none':'' }}{{$voucher->godown_motive==4?'d-none':'' }}">Godown</th>
                                <th class="col-1">Stock</th>
                                <th class="col-1">Quantity</th>
                                <th class="col-1">Price </th>
                                <th class="col-1">Amount</th>
                                <th class="col-1">Dedit</th>
                                <th class="col-1">Credit</th>
                                @if( $voucher->remark_is==1)
                                <th class="col-1">Remarks</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="orders">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class=" m-0 p-0"><button type="button" name="add" id="add" class="btn btn-success  cicle m-0  py-1">+</button></td>
                                <td colspan="2" class="text-right">Total: </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="text" style="font-weight: bold;"  class="total_qty form-control text-right" ></td>
                                <td></td>
                                <td><input type="text" style="font-weight: bold;" class="total_amount form-control text-right" readonly></td>
                               <td><input type="text"  style="font-weight: bold;" class="total_dedit form-control text-right" readonly></td>
                               <td><input type="text"  style="font-weight: bold;" class="total_credit form-control text-right" readonly></td>
                               <td></td>
                            </tr>
                        </tfoot>
                      </table>
                      </div>
                  </div>
                  <div align="center">
                    <button  type="submit" class="btn btn-info edit_journal" style="width:120px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span >Update</span></button>
                    <button type="button"  class="btn btn-danger deleteIcon" style="width:120px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span >Delete</span></button>
                    <a  class="btn btn-danger" style="border-radius: 15px;" href="{{route('voucher-dashboard')}}"><span class="m-1 m-t-1" style="color:#404040;!important"><i class="fa fa-times-circle" style="font-size:20px;" ></i></span><span>Cancel</span></a>
                 </div>
            </div>
         </form>
        </div>
       </div>
    </div>
</div>

  @push('js')

  <script type="text/javascript" src="{{asset('libraries/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('voucher_setup/vocher_setup_sales.js')}}"></script>

  <script>
   $('.unit_or_branch').val('{{$data->unit_or_branch}}');
    $(document).ready(function(){
        var amount_decimals="{{company()->amount_decimals}}";
        var debit_credit_amont= "{{$voucher->amnt_typeable ?? ''}}";
        var remark_is="{{$voucher->remark_is ?? ''}}";
        var dup_row="{{$voucher->dup_row ?? ''}}";
        var dc_amnt="{{$voucher->dc_amnt ?? ''}}";
        var stock_item_price_typeabe="{{$voucher->stock_item_price_typeabe ?? ''}}";
        var total_qty_is="{{$voucher->total_qty_is ?? ''}}";
        var total_price_is="{{$voucher->total_price_is ?? ''}}";
        var amount_typeabe="{{$voucher->amount_typeabe ?? ''}}";
        var godown_motive="{{$voucher->godown_motive ?? ''}}";
        var t_m_id="{{$data->tran_id}}";
        let p;
        $.ajax({
            type: 'GET',
            url: "{{ url('voucher-journal-edit')}}",
            async: false,
            data: {
                tran_id:t_m_id
            },
            dataType: 'json',
            success: function (response) {
             let debit_credit_check_in=0,debit_credit_check=0;
             $.each(response.data, function(i,val) {
                $('#orders').append(`<tr style="margin:0px;padding:0px;" class="p-0 m-0"  id="row${i}">
                                        <input class="form-control  stock_in_id m-0 p-0" type="hidden" name="stock_in_id[]" value="${val.in_stock_in_id?val.in_stock_in_id:''}" data-type="stock_in_id" id="stock_in_id_${i}" >
                                        <input class="form-control  stock_out_id m-0 p-0" type="hidden" name="stock_out_id[]" value="${val.out_stock_in_id?val.out_stock_in_id:''}" data-type="stock_out_id" id="stock_out_id_${i}">
                                    <td  class="m-0 p-0"><button  type="button" name="remove" id="${i}" class="btn btn-danger btn_remove cicle m-0  py-1">-</button></td>
                                    <input class="form-control  ledger_in_id m-0 p-0" type="hidden" name="ledger_in_id[]" data-type="ledger_in_id" id="ledger_in_id_${i}">
                                            <input class="form-control  ledger_out_id m-0 p-0" type="hidden" name="ledger_out_id[]" data-type="ledger_out_id" id="ledger_out_id_${i}">
                                    ${(val.debit_credit_id!=debit_credit_check_in) ? `
                                        <td  class="m-0 p-0">
                                            <input class="form-control  debit_credit_id m-0 p-0"  name="debit_credit_id[]" type="hidden" value="${val.debit_credit_id}" data-type="debit_credit_id" id="debit_credit_id_${i}"  for="${i}"/>
                                            <input class="form-control  ledger_id m-0 p-0" type="hidden" name="ledger_id[]" value="${val.ledger_head_id?val.ledger_head_id:''}" data-type="ledger_id" id="ledger_id_${i}"  for="${i}" />
                                            <select  id="DrCr" name="DrCr[]" class="form-control  js-example-basic-single  DrCr " >
                                                <option   ${val.dr_cr=="Dr"?'selected':''} value="Dr">Dr</option>
                                                <option  ${val.dr_cr=="Cr" ?'selected':''} value="Cr">Cr</option>
                                            </select>
                                        </td>
                                        <td  class="m-0 p-0">
                                            <textarea data-adaptheight  style="resize: none;" class="form-control ledger_name  autocomplete_txt" name="ledger_name[]" data-field-name="ledger_name"  type="text" data-type="ledger_name" id="ledger_name_${i}"  autocomplete="off" for="${i}" rows="1" >${val.ledger_name?val.ledger_name:''}</textarea>

                                        </td>
                                        <td  class="m-0 p-0">
                                            <input class="form-control blance text-right "   data-field-name="blance"  name="blance[]" type="text" class="blance" id="blance_${i}"  for="${i}"  readonly/>
                                        </td>
                                        ${debit_credit_check_in=val.debit_credit_id}`:`<td  class="m-0 p-0">
                                            <input class="form-control  debit_credit_id m-0 p-0"  name="debit_credit_id[]" type="hidden"  data-type="debit_credit_id" id="debit_credit_id_${i}"  for="${i}"/>
                                            <input class="form-control  ledger_id m-0 p-0" type="hidden" name="ledger_id[]" value="" data-type="ledger_id" id="ledger_id_${i}"  for="${i}" />
                                            <select  id="DrCr" name="DrCr[]" class="form-control  js-example-basic-single  DrCr " >
                                                <option  value="Dr">Dr</option>
                                                <option  value="Cr">Cr</option>
                                            </select>
                                        </td>
                                        <td  class="m-0 p-0">
                                            <textarea style="resize: none;"  class="form-control ledger_name  autocomplete_txt" name="ledger_name[]" data-field-name="ledger_name"  type="text" data-type="ledger_name" id="ledger_name_${i}"  autocomplete="off" for="${i}" rows="1" ></textarea>

                                        </td>
                                        <td  class="m-0 p-0">
                                            <input class="form-control blance text-right "   data-field-name="blance"  name="blance[]" type="text" class="blance" id="blance_${i}"  for="${i}"  readonly/>
                                        </td>`
                                    }
                                    <td  class="m-0 p-0">
                                        <textarea  style="resize: none;" class="form-control product_name  autocomplete_txt" name="product_name[]" data-field-name="product_name"  type="text" data-type="product_name" id="product_name_${i}"  autocomplete="off" for="${i}" rows="1">${val.in_product_name?val.in_product_name:(val.out_product_name?val.out_product_name:'')}</textarea>
                                        <input class="form-control product_id"   data-field-name="product_id"  name="product_id[]" type="hidden" class="blance" id="product_id_${i}"  for="${i}" value="${val.in_item_id?val.in_item_id:(val.out_item_id?val.out_item_id:'')}"  readonly/>
                                    </td>
                                    <td  class="m-0 p-0 ${godown_motive==3?'d-none':''} ${godown_motive==4?'d-none':''}">
                                        <textarea class="form-control godown_name autocomplete_txt " name="godown_name[]"   data-field-name="godown_name" type="text"  id="godown_name_${i}"  for="${i}" ${godown_motive==2?'readonly':''}  autocomplete="off"  rows="1">${val.in_godown_name?val.in_godown_name:(val.out_godowns_name?val.out_godowns_name:'')}</textarea>
                                        <input class="form-control godown_id text-right " name="godown_id[]"  data-field-name="godown_id" value="${val.in_godown_id?val.in_godown_id:(val.out_godown_id?val.out_godown_id:'')}" type="hidden"  id="godown_id_${i}"  for="${i}" readonly />
                                    </td>
                                    <td  class="m-0 p-0">
                                        <input class="form-control stock_out text-right"   data-field-name="stock_out" type="number" class="stock" id="stock_${i}"  for="${i}" readonly />
                                    </td>
                                    <td  class="m-0 p-0">
                                        <input class="form-control qty text-right " name="qty[]"  data-field-name="qty" type="number" value="${val.in_qty?val.in_qty:val.out_qty}" class="qty" id="qty_${i}"  for="${i}"  />

                                    </td>
                                    <td  class="m-0 p-0">
                                        <input class="form-control rate text-right "   name="rate[]" data-field-name="rate" type="number" value="${val.in_rate?val.in_rate:val.out_rate}"  step="any" data-type="rate" id="rate_${i}"  for="${i}" ${stock_item_price_typeabe==0?'readonly':''} />
                                    </td>

                                    <td  class="m-0 p-0">
                                        <input class="form-control amount  text-right" type="number" step="any"  name="amount[]" value="${val.in_total?val.in_total:val.out_total}"  id="amount_${i}" ${amount_typeabe==1?'readonly':''}   for="${i}"/>
                                    </td>

                                    ${(val.debit_credit_id!=debit_credit_check) ?`<td  class="m-0 p-0">
                                        <input class="form-control debit text-right " data-field-name="debit" name="debit[]" type="number" data-type="debit" id="debit_${i}" value="${val.debit.toFixed(amount_decimals)}"  for="${i}"/>
                                    </td>
                                    <td  class="m-0 p-0">
                                        <input class="form-control credit text-right" type="number" name="credit[]" id="credit_${i}"   value="${val.credit.toFixed(amount_decimals)}" for="${i}" readonly/>
                                    </td>${debit_credit_check=val.debit_credit_id}`:`<td  class="m-0 p-0">
                                        <input class="form-control debit text-right " data-field-name="debit" name="debit[]" type="number" data-type="debit" id="debit_${i}" value=""  for="${i}"/>
                                    </td>
                                    <td  class="m-0 p-0">
                                        <input class="form-control credit text-right" type="number" name="credit[]" id="credit_${i}"   value="" for="${i}" readonly/>
                                    </td>`}
                                ${remark_is==1 && `<td  class="m-0 p-0 "><input class="form-control remark"  name="remark[]" type="text" data-type=" id="remark_${i}"  autocomplete="off" for="${i}"/></td>`}
                            </tr>`);
                            let ledger_head_id =$('#ledger_id_'+i).val();
                                    $.ajax({
                                    url: '{{url("journal-data") }}',
                                    method: 'GET',
                                    dataType: 'json',
                                    async: false,
                                    data: {
                                        ledger_head_id:ledger_head_id,
                                        stock_item_id:val.in_item_id?val.in_item_id:(val.out_item_id?val.out_item_id:''),
                                    },
                                    success: function(response){
                                         $('#blance_'+i).val(response[0].balance==0?'':response[0].balance);
                                         $('#stock_'+i).val(response[0].stock==0?'':response[0].stock);
                                    }

                                });
                    p=i;
                });
            }
        });
       var rowCount=p;
        //row append function
          $('#add').click(function() {
                rowCount+=5;
                addrow (rowCount);
          });
          function getId(element){
                var id, idArr;
                id = element.attr('id');
                idArr = id.split("_");
                return idArr[idArr.length - 1];
          }
           //row remove
          $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr('id');
                $('#row'+button_id+'').remove();
            });
           //row append table
            function addrow (rowCount)
            {
                    if(rowCount==null){
                        rowCount=1;
                    }else{
                        rowCount=rowCount;
                    }
                    let godown_id=$('.godown').val();
                    let godown_name=$('.godown option:selected').text()
                    for(var row=1; row<6;row++) {
                            rowCount++;
                            let remark=``;
                            $('#orders').append(`<tr  style="margin:0px;padding:0px;" class="p-0 m-0"  id="row${rowCount}">
                                  <input class="form-control  ledger_id m-0 p-0" type="hidden" name="ledger_id[]" data-type="ledger_id" id="ledger_id_${rowCount}"  for="${rowCount}" />
                                  <input class="form-control  ledger_in_id m-0 p-0" type="hidden" name="ledger_in_id[]" data-type="ledger_in_id" id="ledger_in_id_${rowCount}">
                                  <input class="form-control  ledger_out_id m-0 p-0" type="hidden" name="ledger_out_id[]" data-type="ledger_out_id" id="ledger_out_id_${rowCount}">
                                <td  class="m-0 p-0"><button  type="button" name="remove" id="${rowCount}" class="btn btn-danger btn_remove cicle m-0  py-1">-</button></td>
                                <td  class="m-0 p-0">
                                    <select  id="DrCr" name="DrCr[]" class="form-control  js-example-basic-single  DrCr " >
                                        <option value="Dr">Dr</option>
                                        <option value="Cr">Cr</option>
                                    </select>
                                </td>
                                <td  class="m-0 p-0">
                                    <textarea   class="form-control ledger_name  autocomplete_txt" name="ledger_name[]" data-field-name="ledger_name"  type="text" data-type="ledger_name" id="ledger_name_${rowCount}" " autocomplete="off" for="${rowCount}" rows="1" ></textarea>
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control blance text-right "   data-field-name="blance"  name="blance[]" type="text" class="blance" id="blance_${rowCount}"  for="${rowCount}"  readonly/>
                                </td>
                                <td  class="m-0 p-0">
                                    <textarea class="form-control product_name  autocomplete_txt" name="product_name[]" data-field-name="product_name"  type="text" data-type="product_name" id="product_name_${rowCount}"  autocomplete="off" for="${rowCount}" rows="1"></textarea>
                                    <input class="form-control product_id"   data-field-name="product_id"  name="product_id[]" type="hidden" class="blance" id="product_id_${rowCount}"  for="${rowCount}"  readonly/>
                                </td>
                                <td  class="m-0 p-0 ${godown_motive==3?'d-none':''} ${godown_motive==4?'d-none':''}">
                                    <textarea class="form-control godown_name autocomplete_txt " name="godown_name[]"   data-field-name="godown_name" type="text"  id="godown_name_${rowCount}"  for="${rowCount}" ${godown_motive==2?'readonly':''}  autocomplete="off"  rows="1">${godown_name}</textarea>
                                    <input class="form-control godown_id text-right " name="godown_id[]"  data-field-name="godown_id" value="${godown_id}" type="hidden"  id="godown_id_${rowCount}"  for="${rowCount}" readonly />
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control stock_out text-right"   data-field-name="stock_out" type="number" class="stock" id="stock_${rowCount}"  for="${rowCount}" readonly />
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control qty text-right " name="qty[]"  data-field-name="qty" type="number" class="qty" id="qty_${rowCount}"  for="${rowCount}"  />
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control rate text-right "   name="rate[]" data-field-name="rate" type="number "  step="any" data-type="rate" id="rate_${rowCount}"  for="${rowCount}" ${stock_item_price_typeabe==0?'readonly':''} />
                                </td>

                                <td  class="m-0 p-0">
                                    <input class="form-control amount  text-right" type="number" step="any"  name="amount[]" id="amount_${rowCount}" ${amount_typeabe==1?'readonly':''}  for="${rowCount}"/>
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control debit text-right " data-field-name="debit" name="debit[]" type="number" data-type="debit" id="debit_${rowCount}"  for="${rowCount}"/>
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control credit text-right" type="number" name="credit[]" id="credit_${rowCount}"   for="${rowCount}" readonly/>
                                </td>
                                ${remark_is==1 && `<td  class="m-0 p-0 "><input class="form-control remark"  name="remark[]" type="text" data-type=" id="remark_${rowCount}"  autocomplete="off" for="${rowCount}"/></td>`}
                            </tr>`);
                        }
                        $('#orders').find('input,textarea,button,select').height($("textarea")[0].scrollHeight-10)

            }
        // select debit credit row
        $('#orders').on('change','.DrCr',function(){
            var DrCr=$(this).closest('tr').find('.DrCr').val();
            var credit=$(this).closest('tr').find('.credit').val();
            var debit= $(this).closest('tr').find('.debit').val();
            if( DrCr=='Cr'){
                if(debit){
                    $(this).closest('tr').find('.debit').val('');
                    let check_blance=$(this).closest('tr').find('.blance').val().search("Cr");
                    if(check_blance==-1){
                            if(debit_credit_amont==0){
                                if(parseFloat($(this).closest('tr').find('.blance').val())<parseFloat(debit)){
                                    $(this).closest('tr').find('.credit').val('');
                                    $(this).closest('tr').find('.credit').css({backgroundColor: 'red'});
                                }else{
                                    $(this).closest('tr').find('.credit').css({backgroundColor: 'white'});
                                    $(this).closest('tr').find('.credit').val(debit);
                                }
                          }else{
                            $(this).closest('tr').find('.credit').val(debit);
                            $(this).closest('tr').closest('tr').find('.debit').css({backgroundColor: ''});
                          }
                    }else{
                        $(this).closest('tr').find('.credit').val(debit);
                        $(this).closest('tr').find('.debit').css({backgroundColor: ''});
                    }
                    $(this).closest('tr').find('.credit').attr('readonly', false);
                    $(this).closest('tr').find('.debit').attr('readonly', true);
                }
                $(this).closest('tr').find('.credit').attr('readonly', false);
                $(this).closest('tr').find('.debit').attr('readonly', true);
            }else if(DrCr=='Dr'){
                if(credit){
                    $(this).closest('tr').find('.credit').val('');
                    let check_blance=$(this).closest('tr').find('.blance').val().search("Dr");
                    if(check_blance==-1){
                            if(debit_credit_amont==0){
                                if(parseFloat($(this).closest('tr').find('.blance').val())<parseFloat(credit)){
                                    $(this).closest('tr').find('.debit').val('');
                                    $(this).closest('tr').find('.debit').css({backgroundColor: 'red'});
                                }else{

                                    // $(this).closest('tr').find('.debit').css({backgroundColor: 'white'});
                                    $(this).closest('tr').find('.debit').val(credit);
                                }
                          }else{
                             $(this).closest('tr').find('.debit').val(credit);
                             $(this).closest('tr').find('.credit').css({backgroundColor: ''});
                          }
                    }else{
                        $(this).closest('tr').find('.debit').val(credit);
                        $(this).closest('tr').find('.credit').css({backgroundColor: ''});
                    }
                    $(this).closest('tr').find('.debit').attr('readonly', false);
                    $(this).closest('tr').find('.credit').attr('readonly', true);
                }
                $(this).closest('tr').find('.debit').attr('readonly', false);
                $(this).closest('tr').find('.credit').attr('readonly', true);

            }
        })

        $('#orders').on('click','.credit,.debit',function(){

            if($(this).val()<=0){
                if( $(this).closest('tr').find('.amount').val().length==0){
                    if($(this).attr('class').search('credit')>=0 && $(this).closest('tr').find('.DrCr').val()=='Cr'){
                        let check_blance=$(this).closest('tr').find('.blance').val().search("Cr");
                        if(check_blance==-1){
                            if(debit_credit_amont==0){
                                if(parseFloat($(this).closest('tr').find('.blance').val())<parseFloat(DrCrCalculation('credit'))){
                                    $(this).closest('tr').find('.credit').val('');
                                    $(this).closest('tr').find('.credit').css({backgroundColor: 'red'});
                                }else{
                                    $(this).val(parseFloat(DrCrCalculation('credit')).toFixed(amount_decimals));
                                    $(this).closest('tr').find('.credit').css({backgroundColor: 'white'});
                                }
                            }else{

                                $(this).val(parseFloat(DrCrCalculation('credit')).toFixed(amount_decimals));
                            }
                        }else{
                            $(this).val(parseFloat(DrCrCalculation('credit')).toFixed(amount_decimals));
                        }
                    }else if($(this).attr('class').search('debit')>=0 && $(this).closest('tr').find('.DrCr').val()=='Dr'){
                        let check_blance=$(this).closest('tr').find('.blance').val().search("Dr");
                        if(check_blance==-1){
                            if(debit_credit_amont==0){
                                if(parseFloat($(this).closest('tr').find('.blance').val())<parseFloat(DrCrCalculation('debit'))){
                                    $(this).closest('tr').find('.debit').val('');
                                    $(this).closest('tr').find('.debit').css({backgroundColor: 'red'});
                                }else{
                                    $(this).val(parseFloat(DrCrCalculation('debit')).toFixed(amount_decimals));
                                    $(this).closest('tr').find('.debit').css({backgroundColor: 'white'});
                                }
                            }else{
                                $(this).val(parseFloat(DrCrCalculation('debit')).toFixed(amount_decimals));
                            }
                        }else{
                                $(this).val(parseFloat(DrCrCalculation('debit')).toFixed(amount_decimals));
                        }

                    }
                }
            }
            calculation_total();

        })

        $('#orders').on('change','.credit, .debit ',function(){

            $(this).val(parseFloat($(this).val()).toFixed(amount_decimals));
        })
        // debit credit calculation
        function calculation_total(){
            let debit=0;
            let credit=0;
            let qty=0;
            let amount=0;
            $('#orders tr').each(function(i){
                if(parseFloat($(this).find('.debit').val())) debit+=parseFloat($(this).find('.debit').val());
                if(parseFloat($(this).find('.credit').val())) credit+=parseFloat($(this).find('.credit').val());
                if(parseFloat($(this).find('.qty').val())) qty+=parseFloat($(this).find('.qty').val());
                if(parseFloat($(this).find('.amount').val())) amount+=parseFloat($(this).find('.amount').val());
            })
            $('.total_qty').val(parseFloat(qty).toFixed(amount_decimals));
            $('.total_amount').val(parseFloat(amount).toFixed(amount_decimals));
            $('.total_dedit').val(parseFloat(debit).toFixed(amount_decimals));
            $('.total_credit').val(parseFloat(credit).toFixed(amount_decimals));
            if(debit!=credit){
                $(":submit").attr("disabled", true);
            }else{
                $(":submit").attr("disabled", false);
            }
            if(dc_amnt==0){
                if(debit==0||debit==''){
                  $(":submit").attr("disabled", true);
                }else{
                    if(debit==credit){
                     $(":submit").attr("disabled", false);
                    }
                }
                if(credit==0||credit==''){
                $(":submit").attr("disabled", true);
                }else{
                    if(debit==credit){
                      $(":submit").attr("disabled", false);
                    }
                }
            }

        }

        $('#orders').on('keyup ','.credit, .debit,.qty,.rate',function(){
            let qty=$(this).closest('tr').find('.qty').val();
            let rate=$(this).closest('tr').find('.rate').val();
            let DrCr=$(this).closest('tr').find('.DrCr').val();

            let ledger_id=$(this).closest('tr').find('.ledger_id').val();
            let product_id=$(this).closest('tr').find('.product_id').val();
            $(this).closest('tr').find('.amount').val(parseFloat(qty*rate).toFixed(amount_decimals));
        if(product_id.length!=0){
            if(ledger_id.length!=0){
                if(DrCr=='Dr'){
                    $(this).closest('tr').find('.ledger_in_id').val($(this).closest('tr').find('.ledger_id').val());
                }else if(DrCr=='Cr'){
                    $(this).closest('tr').find('.ledger_out_id').val($(this).closest('tr').find('.ledger_id').val());
                }
            }
                let product_wise_debit_sum=0
                let prevTr='';
                $('#orders tr').each(function(i){
                    if($(this).find('.ledger_name').val()){
                        if(prevTr){
                            let DrCr=prevTr.find('.DrCr').val()
                            if(DrCr==='Dr')prevTr.find('.debit').val(product_wise_debit_sum);
                            else if(DrCr==='Cr')prevTr.find('.credit').val(product_wise_debit_sum);
                            product_wise_debit_sum=0;
                        }
                        prevTr=$(this);
                        product_wise_debit_sum=($(this).find('.qty').val()*($(this).find('.rate').val()));
                        let DrCr=$(this).find('.DrCr').val()
                        if(DrCr==='Dr')$(this).find('.debit').val(product_wise_debit_sum);
                        else if(DrCr==='Cr')$(this).find('.credit').val(product_wise_debit_sum);
                    }else {
                        product_wise_debit_sum+=($(this).find('.qty').val()*($(this).find('.rate').val()));
                    }
                });
                if(prevTr){
                    let DrCr=prevTr.find('.DrCr').val()
                    if(DrCr==='Dr')prevTr.find('.debit').val(product_wise_debit_sum);
                    else if(DrCr==='Cr')prevTr.find('.credit').val(product_wise_debit_sum);
                    product_wise_debit_sum=0;
                }
                if($(this).closest('tr').prev().find('.ledger_in_id').val()){
                    $(this).closest('tr').find('.ledger_in_id').val($(this).closest('tr').prev().find('.ledger_in_id').val());
                }else if($(this).closest('tr').prev().find('.ledger_out_id').val()){
                    $(this).closest('tr').find('.ledger_out_id').val($(this).closest('tr').prev().find('.ledger_out_id').val())
                }
            }
            calculation_total();
        })

        $('#orders').on('keyup ','.credit',function(){
            let check_blance=$(this).closest('tr').find('.blance').val().search("Cr");
            if(check_blance==-1){
                if(debit_credit_amont==0){
                    if(parseFloat($(this).closest('tr').find('.blance').val())<parseFloat($(this).closest('tr').find('.credit').val())){
                        $(this).closest('tr').find('.credit').val('');
                        $(this).closest('tr').find('.credit').css({backgroundColor: 'red'});
                    }else{
                        $(this).closest('tr').find('.credit').css({backgroundColor: 'white'});
                    }
               }
            }
         })
         $('#orders').on('keyup','.debit',function(){
            let check_blance=$(this).closest('tr').find('.blance').val().search("Dr");
            if(check_blance==-1){
                if(debit_credit_amont==0){
                    if(parseFloat($(this).closest('tr').find('.blance').val())<parseFloat($(this).closest('tr').find('.debit').val())){
                        $(this).closest('tr').find('.debit').val('');
                        $(this).closest('tr').find('.debit').css({backgroundColor: 'red'});
                    }else{
                        $(this).closest('tr').find('.debit').css({backgroundColor: 'white'});
                    }
               }
            }
         })
         calculation_total();
        $('#orders').on('change','tr','.DrCr,.credit, .debit ',function(){
            calculation_total();
        })
        $(document).on('click', '.btn_remove', function() {
           calculation_total();
         });
         // calculation debit credit
        function DrCrCalculation(type){
            let debit=0;
            let credit=0;
            let qty=0;
            let amount=0;
            $('#orders tr').each(function(i){
                if(parseFloat($(this).find('.debit').val())) debit+=parseFloat($(this).find('.debit').val());
                if(parseFloat($(this).find('.credit').val())) credit+=parseFloat($(this).find('.credit').val());
                if(parseFloat($(this).find('.qty').val())) qty+=parseFloat($(this).find('.qty').val());
                if(parseFloat($(this).find('.amount').val())) amount+=parseFloat($(this).find('.amount').val());
            })
            $('.total_qty').val(parseFloat(qty).toFixed(amount_decimals));
            $('.total_amount').val(parseFloat(amount).toFixed(amount_decimals));
            if(debit>credit && type == 'credit'){
                $('.total_credit').val(parseFloat(debit).toFixed(amount_decimals));
                return parseFloat(debit)-parseFloat(credit);
            }
            else if(debit<credit && type == 'debit'){
                $('.total_dedit').val(parseFloat(credit).toFixed(amount_decimals));
                return parseFloat(credit)-parseFloat(debit);
            }
        }

        // auto searching
        function getId(element){
            var id, idArr;
            id = element.attr('id');
            idArr = id.split("_");
            return idArr[idArr.length - 1];
          }

        var ledger_check =[];
        function handleAutocomplete() {
            var fieldName, currentEle,DrCr;
            currentEle = $(this);

            fieldName = currentEle.data('field-name');
            DrCr=$(this).closest('tr').find('.DrCr').val()

            if(typeof fieldName === 'undefined') {
                return false;
            }
            currentEle.autocomplete({
                delay: 500,
                source: function( data, cb ) {
                    $.ajax({
                        url: '{{route("searching-ledger-data") }}',
                        method: 'GET',
                        dataType: 'json',
                        timeout: 1000,
                        data: {
                            name:  data.term,
                            fieldName: fieldName,
                            voucher_id:"{{$voucher->voucher_id}}",
                            DrCr:DrCr
                        },
                        success: function(res){
                            var result;
                            result = [
                                {
                                    label: 'There is no matching record found for '+data.term,
                                    value: ''
                                }
                            ];
                            if (res.length) {
                                result = $.map(res, function(obj){

                                    return {
                                        label: obj[fieldName],
                                        value: obj[fieldName],
                                        data : obj
                                    };
                                });
                            }

                            cb(result);
                        }
                    });

                },
                autoFocus: true,
                minLength: 1,
                change: function(event, ui) {
                    if (ui.item == null) {
                        if ($(this).attr('name') === 'product_name[]') $(this).closest('tr').find('.product_id').val('');
                        else if ($(this).attr('name') === 'godown_name[]') $(this).closest('tr').find('.godown_id').val('');
                        else if ($(this).attr('name') === 'ledger_name[]') $(this).closest('tr').find('.ledger_id').val('');
                        $(this).focus();

                    }
                },
                select: function( event, selectedData ) {
                    if(selectedData && selectedData.item && selectedData.item.data){
                        var rowNo, data;
                        rowNo = getId(currentEle);
                        data = selectedData.item.data;
                        // textarea auto expand
                        if(selectedData.item.data.ledger_name){
                            auto_expand_tr(rowNo,$('#ledger_name_'+rowNo)[0].scrollWidth,selectedData.item.data.ledger_name);
                        }else if(selectedData.item.data.product_name){
                            auto_expand_tr(rowNo,$('#product_name_'+rowNo)[0].scrollWidth,selectedData.item.data.product_name);
                        }else if(selectedData.item.data.godown_name){
                            auto_expand_tr(rowNo,$('#godown_name_'+rowNo)[0].scrollWidth,selectedData.item.data.godown_name);
                        }
                        if(data.ledger_head_id){
                            $('#ledger_id_'+rowNo).val(data.ledger_head_id);
                                $.ajax({
                                    url: '{{route("balance-debit-credit") }}',
                                    method: 'GET',
                                    dataType: 'json',
                                    async: false,
                                    data: {
                                        ledger_head_id:data.ledger_head_id
                                    },
                                    success: function(response){

                                        $('#blance_'+rowNo).val(response.data);
                                    }
                                });
                        }else if(data.godown_id){
                            $('#godown_name_'+rowNo).val(data.godown_name);
                            $('#godown_id_'+rowNo).val(data.godown_id);
                        }
                        else{
                            $('#product_id_'+rowNo).val(data.stock_item_id);
                            $('#per_'+rowNo).val(data.symbol);
                            $('#measure_id_'+rowNo).val(data.unit_of_measure_id);
                            //current stock check
                                $.ajax({
                                    url: '{{url("current-stock") }}',
                                    method: 'GET',
                                    dataType: 'json',
                                    async: false,
                                    data: {
                                        stock_item_id:data.stock_item_id,
                                    },
                                    success: function(response){
                                        if(response){
                                            $('#stock_'+rowNo).val((response.data));
                                        }else{
                                            $('#stock_'+rowNo).val('');
                                        }
                                    }
                                });
                                // stock item get price
                                $.ajax({
                                    url: '{{route("searching-stock-item-price") }}',
                                    method: 'GET',
                                    dataType: 'json',
                                    async: false,
                                    data: {
                                        stock_item_id:data.stock_item_id,
                                        voucher_id:"{{$voucher->voucher_id}}",
                                    },
                                    success: function(response){
                                        if(response){
                                            if(response.rate){
                                                $('#rate_'+rowNo).val(response.rate);
                                                selected_auto_value_change(1,currentEle,response.rate,amount_decimals);
                                                calculation_total();
                                            }else{
                                                $('#rate_'+rowNo).val(0);
                                                selected_auto_value_change(1,currentEle,0,amount_decimals);
                                                calculation_total();
                                            }

                                        }else{
                                            $('#rate_'+rowNo).val(0);
                                            selected_auto_value_change(1,currentEle,0,amount_decimals);
                                            calculation_total();
                                        }

                                    }
                                });
                        }
                    }
                }
            });
        }
      function registerEvents() {
      $(document).on('focus','.autocomplete_txt', handleAutocomplete);
        }
      registerEvents();
});
//auto_expand_tr
function auto_expand_tr(rowNo,inputWidth,data){
    let Length=data.trim().length;
    let inputHeight=Math.ceil((Length*15)/inputWidth);
    let maxinputHeight=$(`#ledger_name_${rowNo}`)[0].scrollHeight;
    if(maxinputHeight<(inputHeight*17)){
        $(`#row${rowNo}`).find('input,textarea,button,select').height(0).height((inputHeight*17)).trigger("change");
    }
}

</script>
<script>
// insert journal
$(document).ready(function(){
   $("#edit_received_id").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        var id="{{$data->tran_id}}";
        $("#edit_received_btn").text('Add');
        $.ajax({
                url:  "{{ url('voucher-journal') }}" + '/' + id,
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data,status,xhr) {
                    swal_message(data.message,'success','Successfully');
                    setTimeout(function () {  window.location.href='{{route("daybook-report.index")}}'; },100);
                    $('#error_voucher_no').text('');
                },
                error : function(data,status,xhr){
                    if(data.status==404){
                        swal_message(data.responseJSON.message,'error','Error');
                    } if(data.status==422){
                        $('#error_voucher_no').text(data.responseJSON.data.invoice_no[0]);
                    }
                }
        });
    });
// delete purchase ajax request
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
                    url: "{{ url('voucher-journal') }}" + '/' + id ,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success: function (data) {
                        window.location = "{{url('daybook-report')}}";
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
});
// select option  change godown
$('.godown').on('change',function(){
    let godown=$('.godown option:selected').text();
    let godown_val=$('.godown').val();
    $('#orders tr').find('.godown_name').each(function(){
    $('.godown_name').val(godown);
    $('.godown_id').val(godown_val);
    })
})
</script>
@endpush
@endsection

