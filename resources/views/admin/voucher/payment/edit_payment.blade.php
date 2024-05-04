
@extends('layouts.backend.app')
@section('title',' Voucher Payment')
@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
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
                                <input type="text"name="invoice_no"   class="form-control m-1" value="{{$data->invoice_no}}" style="border-radius: 15px;"    style="color: green"/>
                                <span id='error_voucher_no' class="text-danger"></span>
                                <input type="hidden" class="form-control amount_decimals" value="{{company()->amount_decimals}}"/>
                                <input type="hidden" class="form-control tran_id" value="{{$data->tran_id}}"/>
                                <input type="hidden" name="delete_debit_credit_id" class="form-control delete_debit_credit_id" />
                                <input type="hidden" name="ch_4_dup_vou_no" class="form-control " value="{{$voucher->ch_4_dup_vou_no ?? ''}}" />
                                <input type="hidden" name="invoice" class="form-control" value="{{$voucher->invoice ?? ''}}" />
                                <input type="text" name="ref_no" class="form-control m-1" value="{{$data->ref_no}}" style="border-radius: 15px;" />
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
                                <select style="margin-top: 2px; border-radius: 15px;" name="unit_or_branch"  class="form-control m-1 js-example-basic-single  js-example-basic godown " required>
                                    @foreach ($branch_setup as $unit_branchs)
                                      <option {{ $unit_branchs->id==$data->unit_or_branch?'selected':''}}  value="{{ $unit_branchs->id }}">{{$unit_branchs->branch_name }}</option>
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
                  <div class="row">
                    <div class="table-responsive">
                      <table class="table customers " style=" border: none !important; margin-top:5px;" >
                        <thead>
                            <tr >
                                <th class="col-0.5" style="width:46px;" >#</th>
                                <th class="col-0.5">Dr/Cr  </th>
                                <th class="col-5">Ledger Name</th>
                                <th class="col-1.5">Blance</th>
                                <th class="col-1.5">Dedit</th>
                                <th class="col-1.5">Credit</th>
                                @if( $voucher->remark_is==1)
                                 <th class="col-1 ">Remarks</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="orders">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class=" m-0 p-0"><button type="button" name="add" id="add" class="btn btn-success  cicle m-0  py-1">+</button></td>
                                <td></td>
                                <td colspan="2" class="text-right">Total: </td>
                               <td><input type="text" style="border-radius: 15px;font-weight: bold;" class="total_dedit form-control text-right" readonly></td>
                               <td><input type="text" style="border-radius: 15px;font-weight: bold;" class="total_credit form-control text-right" readonly></td>
                               <td></td>
                            </tr>
                        </tfoot>
                      </table>
                      </div>
                  </div>
                  <div align="center">
                    <button  type="submit" class="btn btn-info add_payment_btn" style="width:120px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span >Update</span></button>
                    @if (user_privileges_check('Voucher',$voucher->voucher_id,'delete_role'))
                     <button type="button"  class="btn btn-danger deleteIcon" style="width:120px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;" ></i></span><span >Delete</span></button>
                    @endif
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
  <script type="text/javascript" src="{{asset('voucher_setup/voucher_setup_receive.js')}}"></script>
  <script>
    $(document).ready(function(){
        var t_m_id=$('.tran_id').val();
        var amount_decimals=$('.amount_decimals').val();
        var debit_credit_amont= "{{$voucher->amnt_typeable ?? ''}}";
        var remark_is="{{$voucher->remark_is ?? ''}}";
        var dc_amnt="{{$voucher->dc_amnt ?? ''}}";
        var dup_row="{{$voucher->dup_row ?? ''}}";
        let p;
        $.ajax({
            type: 'GET',
            url: "{{ url('edit/debit-credit') }}",
            async: false,
            data: {
                tran_id:t_m_id
            },
            dataType: 'json',
            success: function (response) {
                    $.each(response.data, function(i, val) {
                        $('#orders').append(`<tr   style="margin:0px;padding:0px;" class="p-0 m-0"  id="row${i}">
                        <input class="form-control  ledger_id m-0 p-0"  name="ledger_id[]" type="hidden" value="${val.ledger_head_id}" data-type="ledger_id" id="ledger_id_${i}"  for="${i}"/>
                        <input class="form-control  debit_credit_id m-0 p-0"  name="debit_credit_id[]" type="hidden" value="${val.debit_credit_id}" data-type="debit_credit_id" id="debit_credit_id_${i}"  for="${i}"/>
                        <td  class="m-0 p-0"><button  type="button" name="remove" id="${i}" class="btn btn-danger btn_remove cicle m-0  py-1">-</button></td>
                        <td  class="m-0 p-0">
                            <select  name="DrCr[]" id="DrCr" data-field-name="DrCr"  class="form-control  js-example-basic-single  DrCr "  for="${i}">
                                <option  ${val.dr_cr=="Dr"?'selected':''} value="Dr">Dr</option>
                                <option  ${val.dr_cr=="Cr" ?'selected':''} value="Cr">Cr</option>
                            </select>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control ledger_name  autocomplete_txt" name="ledger_name[]" data-field-name="ledger_name"  type="text" data-type="ledger_name" value="${val.ledger_name}" id="ledger_name_${i}" " autocomplete="off" for="${i}"  />
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control  blance  text-right " name="blance[]"  data-field-name="blance" type="text" class="blance" id="blance_${i}"
                                value="${(val.nature_group==1||val.nature_group==3)
                                ?(parseFloat(val.debit_sum_1-val.credit_sum_1)).toFixed(amount_decimals) +' Dr'
                                :((val.nature_group==2||val.nature_group==4)
                                ?(parseFloat(val.credit_sum_2-val.debit_sum_2).toFixed(amount_decimals) +' Cr'):'')}" for="${i}"/>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control debit text-right "  name="debit[]"  data-field-name="debit" type="number" data-type="debit"  value="${ parseFloat(val.debit).toFixed(amount_decimals)}"  ${val.dr_cr=="Dr"?'':'readonly'} id="debit_${i}"   for="${i}"/>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control credit text-right" type="number"   name="credit[]" id="credit_${i}" value="${val.credit.toFixed(amount_decimals)}"  for="${i}"  ${val.dr_cr=="Cr" ?'':'readonly'} />
                        </td>
                        <td  class="m-0 p-0  ${remark_is==0?'d-none':''}">
                            <input class="form-control remark " name="remark[]"  type="text"  id="remark_${i}"  value="${val.remark?val.remark:''}" autocomplete="off" for="${i}"/>
                        </td>
                        </tr>`);
                    p=i;
                });
            }
        });

        var rowCount=p;

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
          var arr = [];
          $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr('id');
              $('#row'+button_id+'').remove();
              arr.push($(this).closest('tr').find('.debit_credit_id').val());
              $('.delete_debit_credit_id').val(arr);
            });
      function addrow (rowCount)
       {
            if(rowCount==null){
                rowCount=1;
            }else{
                rowCount=rowCount;
            }
            for(var row=1; row<6;row++) {
                rowCount++;
                    $('#orders').append(`<tr   style="margin:0px;padding:0px;" class="p-0 m-0"  id="row${rowCount}">
                        <input class="form-control  ledger_id m-0 p-0"  name="ledger_id[]" type="hidden" data-type="ledger_id" id="ledger_id_${rowCount}"  for="${rowCount}"/>
                        <td  class="m-0 p-0"><button  type="button" name="remove" id="${rowCount}" class="btn btn-danger btn_remove cicle m-0  py-1">-</button></td>
                        <td  class="m-0 p-0">
                            <select  name="DrCr[]" id="DrCr" data-field-name="DrCr"  class="form-control  js-example-basic-single  DrCr " >
                                <option value="Dr">Dr</option>
                                <option value="Cr">Cr</option>
                            </select>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control ledger_name  autocomplete_txt" name="ledger_name[]" data-field-name="ledger_name"  type="text" data-type="ledger_name" id="ledger_name_${rowCount}" " autocomplete="off" for="${rowCount}"  />
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control blance text-right " name="blance[]"  data-field-name="blance" type="text" class="blance" id="blance_${rowCount}"  for="${rowCount}"/>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control debit  text-right "  name="debit[]" data-field-name="debit" type="number" step="any" data-type="debit" id="debit_${rowCount}"  for="${rowCount}"/>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control credit  text-right" type="number" step="any"  name="credit[]" id="credit_${rowCount}"   for="${rowCount}" readonly/>
                        </td>
                        <td  class="m-0 p-0">
                            <input class="form-control  "  type="text" data-type="" id="${rowCount}" " autocomplete="off" for="${rowCount}"/>
                        </td>
                        </tr>`);
                }
        }
        button_debit_or_credit_total();
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


        $('#orders').on('change','.credit, .debit ',function(){

            $(this).val(parseFloat($(this).val()).toFixed(amount_decimals));
        })
        $('#orders').on('click','.credit, .debit ',function(){
            // $(this).closest('tr').find('.DrCr').val(toFixed(amount_decimals));
            if($(this).val()<=0){
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
            button_debit_or_credit_total();
        })
        function button_debit_or_credit_total(){
            let debit=0;
            let credit=0;
            $('#orders tr').each(function(i){
                if(parseFloat($(this).find('.debit').val())) debit+=parseFloat($(this).find('.debit').val());
                if(parseFloat($(this).find('.credit').val())) credit+=parseFloat($(this).find('.credit').val());
            })
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
        $('#orders').on('keyup','.total_debit_val, .total_credit_val',function(){
            button_debit_or_credit_total();

        })
        $('#orders').on('keyup','.credit, .debit ',function(){
            button_debit_or_credit_total();

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
                        $(this).closest('tr').find('.debit').val();
                        $(this).closest('tr').find('.debit').val('');
                        $(this).closest('tr').find('.debit').css({backgroundColor: 'red'});
                    }else{
                        $(this).closest('tr').find('.debit').css({backgroundColor: 'white'});
                    }
               }
            }
         })

        $('#orders').on('change','tr','.DrCr,.credit, .debit ',function(){
            button_debit_or_credit_total();
        })
        $(document).on('click', '.btn_remove', function() {
           button_debit_or_credit_total();
         });
        function DrCrCalculation(type){
            let debit=0;
            let credit=0;
            $('#orders tr').each(function(i){
                if(parseFloat($(this).find('.debit').val())) debit+=parseFloat($(this).find('.debit').val());
                if(parseFloat($(this).find('.credit').val())) credit+=parseFloat($(this).find('.credit').val());
            })

            if(debit>credit && type == 'credit'){
                $('.total_credit').val(parseFloat(debit).toFixed(amount_decimals));
                return parseFloat(debit)-parseFloat(credit);
            }
            else if(debit<credit && type == 'debit'){
                $('.total_dedit').val(parseFloat(credit).toFixed(amount_decimals));
                return parseFloat(credit)-parseFloat(debit);
            }


        }

        function getId(element){
            var id, idArr;
            id = element.attr('id');
            idArr = id.split("_");
            return idArr[idArr.length - 1];
          }


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
                change: function (event, ui) {
                    if (ui.item == null) {
                        if($(this).attr('name')==='ledger_name[]')$(this).closest('tr').find('.ledger_id').val('');
                        $(this).focus();
                    }
               },
                select: function( event, selectedData ) {
                    if(selectedData && selectedData.item && selectedData.item.data){
                        var rowNo, data;
                        rowNo = getId(currentEle);
                        data = selectedData.item.data;
                        currentEle.css({backgroundColor: 'white'});
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
                    }
                }
            });
        }
      function registerEvents() {
      $(document).on('focus','.autocomplete_txt', handleAutocomplete);
        }
      registerEvents();
});
</script>
<script>
$(document).ready(function(){
   $("#edit_received_id").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        var id=$('.tran_id').val();
        $("#edit_received_btn").text('Upadte');
        $.ajax({
            url: "{{ url('voucher-payment') }}" + '/' + id,
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data,status,xhr) {
                    swal_message(data.message,'success','Successfully');
                    $('#error_voucher_no').text('');
                    setTimeout(function () {  window.location.href='{{route("daybook-report.index")}}'; },100);
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
    // delete payment ajax request
$(document).on('click', '.deleteIcon', function(e) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id =$('.tran_id').val();
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
                    url: "{{ url('voucher-payment') }}" + '/' + id ,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success: function (data) {
                        swal_message(data.message,'success','Successfully');
                        setTimeout(function () {  window.location.href='{{route("daybook-report.index")}}'; },100);
                    },
                    error: function () {
                        swal_message(data.responseJSON.message,'error','Error');
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
input_checking('ledger');
</script>
@endpush
@endsection

