@extends('layouts.backend.app')
@section('title',' Voucher Receive')
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

    .table> :not(:first-child) {
        border-top: 0px solid currentColor;
    }

    textarea.form-control {
        min-height: calc(1.5em + -2.25rem + 42px);
        ;
    }
</style>
@endpush
@section('admin_content')
<div class="pcoded-content  " style="background-color: #e5e5cd!important">
    <div class="pcoded-inner-content  ">
        <br>
        <!-- Main-body start -->
        <div class="main-body ">
            <div class="page-wrapper m-t-0 m-l-1  p-10">
                <!-- Page-header start -->
                <div class="page-header m-2 p-0">
                    <div class="row align-items-end" style="margin-bottom: 0%px !important;">
                        <div class="col-lg-8 ">
                            <div class="page-header-title m p-0" style="margin-bottom:7px !important;">
                                <div class="d-inline ">
                                    <h4 style="color: green;font-weight: bold;">{{$voucher->voucher_name}} [Create]</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div style="float: right; margin-left: 5px;">
                                <a style=" float:right;text-decoration: none; " href="{{route('voucher-dashboard')}}"><span class="fa fa-info-circle m-1" style="font-size:27px; color:#00b8e6;"></span><span style="float:right;margin:2px; padding-top:5px; color: color: white;#">Help</span></a>
                            </div>
                            <div style="float: right;margin-left:9px">
                                <a style=" float:right;text-decoration: none; " href="{{route('voucher-dashboard')}}"><span class="fa fa-times-circle-o m-1" style="font-size:27px; color:#ff6666;"></span><span style="float:right;margin:2px; padding-top:5px; ">Close</span></a>
                            </div>
                            <div style="float: right; margin-left:9px">
                                <a style=" float: right;text-decoration: none; " href="{{route('daybook-report.index')}}"><span class="fa fa-eye m-1" style="font-size:27px; color:#00b8e6;"></span><span style="float:right;margin:2px; padding-top:5px; ">View</span></a>
                            </div>

                        </div>
                        <hr style="margin-bottom: 0px;">
                    </div>
                </div>
                <form id="add_received_id" method="POST">
                    @csrf
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-3 " style="float: right;">
                                        <label style="float: right; margin:2px;">Invoice No:</label><br><br>
                                        <label style="float: right;  margin:2px; margin-right:29px;">Ref No:</label>
                                    </div>
                                    <div class="col-sm-9 m-0 p-0" style="margin-left: 5px;!important;">
                                        <input type="text" name="invoice_no" class="form-control m-1" value="{{$voucher_invoice}}" style="border-radius: 15px;" {{$voucher_invoice?'readonly':''}} style="color: green" />
                                        <span id='error_voucher_no' class="text-danger"></span>
                                        <input type="hidden" name="voucher_id" class="form-control voucher_id" value="{{$voucher->voucher_id ?? ''}}" />
                                        <input type="hidden" name="ch_4_dup_vou_no" class="form-control " value="{{$voucher->ch_4_dup_vou_no ?? ''}}" />
                                        <input type="hidden" name="invoice" class="form-control" value="{{$voucher->invoice ?? ''}}" />
                                        <input type="text" name="ref_no" class="form-control m-1" style="border-radius: 15px;" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row " style="margin-top: 5px;">
                                    <div class="col-sm-4 " style="float: right;">
                                        <label style="float: right; margin:2px; margin-right: 82px;;">Date:</label><br><br>
                                        <label style="float: right;  margin:2px; margin-right: 26px;" for="exampleInputEmail1">Unit / Branch:</label>
                                    </div>
                                    <div class="col-sm-8 m-0 p-0" style="margin-left: 5px;!important;">
                                        <input type="date" name="invoice_date" class="form-control " style="margin-bottom: 4px !important;border-radius: 15px;" value="{{$voucher_date}}" />
                                        <select style="margin-top: 2px; border-radius: 15px;" name="unit_or_branch" class="form-control m-1 js-example-basic-single  js-example-basic  " required>
                                            @foreach ($branch_setup as $unit_branchs)
                                            <option value="{{ $unit_branchs->id }}">{{$unit_branchs->branch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label style="margin-left:2px; ">Narration:</label>
                                <textarea style="margin-left:2px; border-radius: 15px;" name="narration" rows="2.5" cols="2.5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 {{$voucher->godown_motive==3?'d-none ':'' }}">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Godowns :</label>
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
                            <table class="table customers " style=" border: none !important; margin-top:5px;">
                                <thead>
                                    <tr>
                                        <th class="col-0.5" style="width:46px;">#</th>
                                        <th class="col-0.5">Dr/Cr </th>
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
                                        <td><input type="text" style="font-weight: bold;" class="total_qty form-control text-right"></td>
                                        <td></td>
                                        <td><input type="text" style="font-weight: bold;" class="total_amount form-control text-right" readonly></td>
                                        <td><input type="text" style="font-weight: bold;" class="total_dedit form-control text-right" readonly></td>
                                        <td><input type="text" style="font-weight: bold;" class="total_credit form-control text-right" readonly></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div align="center">
                        <button type="submit" class="btn btn-info add_received_btn" style="width:116px;border-radius: 15px;"><span class="m-1 m-t-1" style="color:#404040"><i class="fa fa-save" style="font-size:18px;"></i></span><span>Save</span></button>
                        <a class="btn btn-danger" style="border-radius: 15px;" href="{{route('voucher-dashboard')}}"><span class="m-1 m-t-1" style="color:#404040;!important"><i class="fa fa-times-circle" style="font-size:20px;"></i></span><span>Cancel</span></a>
                    </div>

                    <div id="styleSelector"></div>

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
    $(document).ready(function() {
        var amount_decimals = "{{company()->amount_decimals}}";
        var debit_credit_amont = "{{$voucher->amnt_typeable ?? ''}}";
        var remark_is = "{{$voucher->remark_is ?? ''}}";
        var dup_row = "{{$voucher->dup_row ?? ''}}";
        var dc_amnt = "{{$voucher->dc_amnt ?? ''}}";
        var stock_item_price_typeabe = "{{$voucher->stock_item_price_typeabe ?? ''}}";
        var total_qty_is = "{{$voucher->total_qty_is ?? ''}}";
        var total_price_is = "{{$voucher->total_price_is ?? ''}}";
        var amount_typeabe = "{{$voucher->amount_typeabe ?? ''}}";
        var godown_motive = "{{$voucher->godown_motive ?? ''}}";
        var rowCount = 1;
        //row append function
        addrow();
        $('#add').click(function() {
            rowCount += 5;
            addrow(rowCount);
        });

        function getId(element) {
            var id, idArr;
            id = element.attr('id');
            idArr = id.split("_");
            return idArr[idArr.length - 1];
        }
        //row remove
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr('id');
            $('#row' + button_id + '').remove();
        });
        //row append table
        function addrow(rowCount) {
            if (rowCount == null) {
                rowCount = 1;
            } else {
                rowCount = rowCount;
            }
            let godown_id = $('.godown').val();
            let godown_name = $('.godown option:selected').text()
            for (var row = 1; row < 6; row++) {
                rowCount++;
                let remark = ``;
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
                                    <textarea  style="resize: none;" class="form-control ledger_name  autocomplete_txt" name="ledger_name[]" data-field-name="ledger_name"  type="text" data-type="ledger_name" id="ledger_name_${rowCount}" " autocomplete="off" for="${rowCount}" rows="1" ></textarea>
                                </td>
                                <td  class="m-0 p-0">
                                    <input class="form-control blance text-right "   data-field-name="blance"  name="blance[]" type="text" class="blance" id="blance_${rowCount}"  for="${rowCount}"  readonly/>
                                </td>
                                <td  class="m-0 p-0">
                                    <textarea style="resize: none;" class="form-control product_name  autocomplete_txt" name="product_name[]" data-field-name="product_name"  type="text" data-type="product_name" id="product_name_${rowCount}"  autocomplete="off" for="${rowCount}" rows="1"></textarea>
                                    <input class="form-control product_id"   data-field-name="product_id"  name="product_id[]" type="hidden" id="product_id_${rowCount}"  for="${rowCount}"  readonly/>
                                </td>
                                <td  class="m-0 p-0 ${godown_motive==3?'d-none':''} ${godown_motive==4?'d-none':''}">
                                    <textarea style="resize: none;" class="form-control godown_name autocomplete_txt " name="godown_name[]"   data-field-name="godown_name" type="text"  id="godown_name_${rowCount}"  for="${rowCount}" ${godown_motive==2?'readonly':''}  autocomplete="off"  rows="1">${godown_name}</textarea>
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
        $('#orders').on('change', 'tr', function() {
            var DrCr = $(this).find('.DrCr').val();
            var credit = $(this).find('.credit').val();
            var debit = $(this).find('.debit').val();
            if (DrCr == 'Cr') {
                if (debit) {
                    $(this).find('.debit').val('');
                    let check_blance = $(this).closest('tr').find('.blance').val().search("Cr");
                    if (check_blance == -1) {
                        if (debit_credit_amont == 0) {
                            if (parseFloat($(this).closest('tr').find('.blance').val()) < parseFloat(debit)) {
                                $(this).closest('tr').find('.credit').val('');
                                $(this).closest('tr').find('.credit').css({
                                    backgroundColor: 'red'
                                });
                            } else {
                                $(this).closest('tr').find('.credit').css({
                                    backgroundColor: 'white'
                                });
                                $(this).find('.credit').val(debit);
                            }
                        } else {
                            $(this).find('.credit').val(debit);
                            $(this).closest('tr').find('.debit').css({
                                backgroundColor: ''
                            });
                        }
                    } else {
                        $(this).find('.credit').val(debit);
                        $(this).closest('tr').find('.debit').css({
                            backgroundColor: ''
                        });
                    }
                    $(this).find('td .credit').attr('readonly', false);
                    $(this).find('td .debit').attr('readonly', true);
                }
                $(this).find('td .credit').attr('readonly', false);
                $(this).find('td .debit').attr('readonly', true);
            } else if (DrCr == 'Dr') {
                if (credit) {
                    $(this).find('.credit').val('');
                    let check_blance = $(this).closest('tr').find('.blance').val().search("Dr");
                    if (check_blance == -1) {
                        if (debit_credit_amont == 0) {
                            if (parseFloat($(this).closest('tr').find('.blance').val()) < parseFloat(credit)) {
                                $(this).closest('tr').find('.debit').val('');
                                $(this).closest('tr').find('.debit').css({
                                    backgroundColor: 'red'
                                });
                            } else {
                                $(this).find('.debit').val(credit);
                            }
                        } else {
                            $(this).find('.debit').val(credit);
                            $(this).closest('tr').find('.credit').css({
                                backgroundColor: ''
                            });
                        }
                    } else {
                        $(this).find('.debit').val(credit);
                        $(this).closest('tr').find('.credit').css({
                            backgroundColor: ''
                        });
                    }
                    $(this).find('td .debit').attr('readonly', false);
                    $(this).find('td .credit').attr('readonly', true);
                }
                $(this).find('td .debit').attr('readonly', false);
                $(this).find('td .credit').attr('readonly', true);

            }
        })

        $('#orders').on('click', '.credit, .debit', function() {
            if ($(this).val() <= 0) {
                if ($(this).closest('tr').find('.amount').val().length == 0 || $(this).closest('tr').find('.amount').val() == 0) {
                    if ($(this).attr('class').search('credit') >= 0 && $(this).closest('tr').find('.DrCr').val() == 'Cr') {
                        let check_blance = $(this).closest('tr').find('.blance').val().search("Cr");
                        if (check_blance == -1) {
                            if (debit_credit_amont == 0) {
                                if (parseFloat($(this).closest('tr').find('.blance').val()) < parseFloat(DrCrCalculation('credit'))) {
                                    $(this).closest('tr').find('.credit').val('');
                                    $(this).closest('tr').find('.credit').css({
                                        backgroundColor: 'red'
                                    });
                                } else {
                                    $(this).val(parseFloat(DrCrCalculation('credit')).toFixed(amount_decimals));
                                    $(this).closest('tr').find('.credit').css({
                                        backgroundColor: 'white'
                                    });
                                }
                            } else {
                                $(this).val(parseFloat(DrCrCalculation('credit')).toFixed(amount_decimals));
                            }
                        } else {
                            $(this).val(parseFloat(DrCrCalculation('credit')).toFixed(amount_decimals));
                        }
                    } else if ($(this).attr('class').search('debit') >= 0 && $(this).closest('tr').find('.DrCr').val() == 'Dr') {
                        let check_blance = $(this).closest('tr').find('.blance').val().search("Dr");
                        if (check_blance == -1) {
                            if (debit_credit_amont == 0) {
                                if (parseFloat($(this).closest('tr').find('.blance').val()) < parseFloat(DrCrCalculation('debit'))) {
                                    $(this).closest('tr').find('.debit').val('');
                                    $(this).closest('tr').find('.debit').css({
                                        backgroundColor: 'red'
                                    });
                                } else {
                                    $(this).val(parseFloat(DrCrCalculation('debit')).toFixed(amount_decimals));
                                    $(this).closest('tr').find('.debit').css({
                                        backgroundColor: 'white'
                                    });
                                }
                            } else {
                                $(this).val(parseFloat(DrCrCalculation('debit')).toFixed(amount_decimals));
                            }
                        } else {
                            $(this).val(parseFloat(DrCrCalculation('debit')).toFixed(amount_decimals));
                        }

                    }
                }
            }
            calculation_total();
        })
        $('#orders').on('change', '.credit, .debit ', function() {

            $(this).val(parseFloat($(this).val()).toFixed(amount_decimals));
        })
        // debit credit calculation
        function calculation_total() {
            let debit = 0;
            let credit = 0;
            let qty = 0;
            let amount = 0;
            $('#orders tr').each(function(i) {
                if (parseFloat($(this).find('.debit').val())) debit += parseFloat($(this).find('.debit').val());
                if (parseFloat($(this).find('.credit').val())) credit += parseFloat($(this).find('.credit').val());
                if (parseFloat($(this).find('.qty').val())) qty += parseFloat($(this).find('.qty').val());
                if (parseFloat($(this).find('.amount').val())) amount += parseFloat($(this).find('.amount').val());
            })
            $('.total_qty').val(parseFloat(qty).toFixed(amount_decimals));
            $('.total_amount').val(parseFloat(amount).toFixed(amount_decimals));
            $('.total_dedit').val(parseFloat(debit).toFixed(amount_decimals));
            $('.total_credit').val(parseFloat(credit).toFixed(amount_decimals));
            if (debit != credit) {
                $(":submit").attr("disabled", true);
            } else {
                $(":submit").attr("disabled", false);
            }
            if (dc_amnt == 0) {
                if (debit == 0 || debit == '') {
                    $(":submit").attr("disabled", true);
                } else {
                    if (debit == credit) {
                        $(":submit").attr("disabled", false);
                    }
                }
                if (credit == 0 || credit == '') {
                    $(":submit").attr("disabled", true);
                } else {
                    if (debit == credit) {
                        $(":submit").attr("disabled", false);
                    }
                }
            }

        }

        $('#orders').on('keyup change', '.credit, .debit,.qty,.rate', function() {
            let qty = $(this).closest('tr').find('.qty').val();
            let rate = $(this).closest('tr').find('.rate').val();
            let DrCr = $(this).closest('tr').find('.DrCr').val();

            let ledger_id = $(this).closest('tr').find('.ledger_id').val();
            let product_id = $(this).closest('tr').find('.product_id').val();
            $(this).closest('tr').find('.amount').val(parseFloat(qty * rate).toFixed(amount_decimals));
            if (product_id.length != 0) {
                if (ledger_id.length != 0) {
                    if (DrCr == 'Dr') {
                        $(this).closest('tr').find('.ledger_in_id').val($(this).closest('tr').find('.ledger_id').val());
                    } else if (DrCr == 'Cr') {
                        $(this).closest('tr').find('.ledger_out_id').val($(this).closest('tr').find('.ledger_id').val());
                    }
                } else {
                    if ($(this).closest('tr').prev().find('.ledger_in_id').val()) {
                        $(this).closest('tr').find('.ledger_in_id').val($(this).closest('tr').prev().find('.ledger_in_id').val());
                    } else if ($(this).closest('tr').prev().find('.ledger_out_id').val()) {
                        $(this).closest('tr').find('.ledger_out_id').val($(this).closest('tr').prev().find('.ledger_out_id').val())
                    }
                }
                let product_wise_debit_sum = 0
                let prevTr = '';
                $('#orders tr').each(function(i) {
                    if ($(this).find('.ledger_name').val()) {
                        if (prevTr) {
                            let DrCr = prevTr.find('.DrCr').val()
                            if (DrCr === 'Dr') prevTr.find('.debit').val(product_wise_debit_sum);
                            else if (DrCr === 'Cr') prevTr.find('.credit').val(product_wise_debit_sum);
                            product_wise_debit_sum = 0;
                        }
                        prevTr = $(this);
                        product_wise_debit_sum = ($(this).find('.qty').val() * ($(this).find('.rate').val()));
                        let DrCr = $(this).find('.DrCr').val()
                        if (DrCr === 'Dr') $(this).find('.debit').val(product_wise_debit_sum);
                        else if (DrCr === 'Cr') $(this).find('.credit').val(product_wise_debit_sum);
                    } else {

                        product_wise_debit_sum += ($(this).find('.qty').val() * ($(this).find('.rate').val()));
                    }
                });
                if (prevTr) {
                    let DrCr = prevTr.find('.DrCr').val()
                    if (DrCr === 'Dr') prevTr.find('.debit').val(product_wise_debit_sum);
                    else if (DrCr === 'Cr') prevTr.find('.credit').val(product_wise_debit_sum);
                    product_wise_debit_sum = 0;
                }

            }
            calculation_total();
        })

        $('#orders').on('keyup ', '.credit', function() {
            let check_blance = $(this).closest('tr').find('.blance').val().search("Cr");
            if (check_blance == -1) {
                if (debit_credit_amont == 0) {

                    if (parseFloat($(this).closest('tr').find('.blance').val()) < parseFloat($(this).closest('tr').find('.credit').val())) {
                        $(this).closest('tr').find('.credit').val('');
                        $(this).closest('tr').find('.credit').css({
                            backgroundColor: 'red'
                        });
                    } else {
                        $(this).closest('tr').find('.credit').css({
                            backgroundColor: 'white'
                        });
                    }
                }
            }
        })
        $('#orders').on('keyup', '.debit', function() {
            let check_blance = $(this).closest('tr').find('.blance').val().search("Dr");
            if (check_blance == -1) {
                if (debit_credit_amont == 0) {
                    if (parseFloat($(this).closest('tr').find('.blance').val()) < parseFloat($(this).closest('tr').find('.debit').val())) {
                        $(this).closest('tr').find('.debit').val('');
                        $(this).closest('tr').find('.debit').css({
                            backgroundColor: 'red'
                        });
                    } else {
                        $(this).closest('tr').find('.debit').css({
                            backgroundColor: 'white'
                        });
                    }
                }
            }
        })
        calculation_total();
        $('#orders').on('change', 'tr', '.DrCr,.credit, .debit ', function() {
            calculation_total();
        })
        $(document).on('click', '.btn_remove', function() {
            calculation_total();
        });
        // calculation debit credit
        function DrCrCalculation(type) {
            let debit = 0;
            let credit = 0;
            let qty = 0;
            let amount = 0;
            $('#orders tr').each(function(i) {
                if (parseFloat($(this).find('.debit').val())) debit += parseFloat($(this).find('.debit').val());
                if (parseFloat($(this).find('.credit').val())) credit += parseFloat($(this).find('.credit').val());
                if (parseFloat($(this).find('.qty').val())) qty += parseFloat($(this).find('.qty').val());
                if (parseFloat($(this).find('.amount').val())) amount += parseFloat($(this).find('.amount').val());
            })
            $('.total_qty').val(parseFloat(qty).toFixed(amount_decimals));
            $('.total_amount').val(parseFloat(amount).toFixed(amount_decimals));
            if (debit > credit && type == 'credit') {

                $('.total_credit').val(parseFloat(debit).toFixed(amount_decimals));
                return parseFloat(debit) - parseFloat(credit);
            } else if (debit < credit && type == 'debit') {
                $('.total_dedit').val(parseFloat(credit).toFixed(amount_decimals));
                return parseFloat(credit) - parseFloat(debit);
            }
        }

        // auto searching
        function getId(element) {
            var id, idArr;
            id = element.attr('id');
            idArr = id.split("_");
            return idArr[idArr.length - 1];
        }

        var ledger_check = [];

        function handleAutocomplete() {

            var fieldName, currentEle, DrCr;
            currentEle = $(this);

            fieldName = currentEle.data('field-name');
            DrCr = $(this).closest('tr').find('.DrCr').val()

            if (typeof fieldName === 'undefined') {
                return false;
            }

            currentEle.autocomplete({
                delay: 500,
                source: function(data, cb) {
                    $.ajax({
                        url: '{{route("searching-ledger-data") }}',
                        method: 'GET',
                        dataType: 'json',
                        timeout: 1000,
                        data: {
                            name: data.term,
                            fieldName: fieldName,
                            voucher_id: "{{$voucher->voucher_id}}",
                            DrCr: DrCr
                        },
                        success: function(res) {
                            var result;
                            result = [{
                                label: 'There is no matching record found for ' + data.term,
                                value: ''
                            }];
                            if (res.length) {
                                result = $.map(res, function(obj) {
                                    return {
                                        label: obj[fieldName],
                                        value: obj[fieldName],
                                        data: obj
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
                select: function(event, selectedData) {
                    if (selectedData && selectedData.item && selectedData.item.data) {
                        var rowNo, data;
                        rowNo = getId(currentEle);
                        data = selectedData.item.data;
                        currentEle.css({ backgroundColor:''});
                        // textarea auto expand
                        if (selectedData.item.data.ledger_name) {
                            auto_expand_tr(rowNo, $('#ledger_name_' + rowNo)[0].scrollWidth, selectedData.item.data.ledger_name);
                        } else if (selectedData.item.data.product_name) {
                            auto_expand_tr(rowNo, $('#product_name_' + rowNo)[0].scrollWidth, selectedData.item.data.product_name);
                        } else if (selectedData.item.data.godown_name) {
                            auto_expand_tr(rowNo, $('#godown_name_' + rowNo)[0].scrollWidth, selectedData.item.data.godown_name);
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
            $(document).on('focus', '.autocomplete_txt', handleAutocomplete);
        }
        registerEvents();
    });
    //auto_expand_tr
    function auto_expand_tr(rowNo, inputWidth, data) {
        let Length = data.trim().length;
        let inputHeight = Math.ceil((Length * 15) / inputWidth);
        let maxinputHeight = $(`#ledger_name_${rowNo}`)[0].scrollHeight;
        if (maxinputHeight < (inputHeight * 17)) {
            $(`#row${rowNo}`).find('input,textarea,button,select').height(0).height((inputHeight * 17)).trigger("change");
        }
    }
</script>
<script>
    // insert journal
    $(document).ready(function() {
        $("#add_received_id").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_received_btn").text('Add');
            $.ajax({
                url: '{{ route("voucher-journal.store") }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data, status, xhr) {
                    swal_message(data.message,'success','Successfully');
                    setTimeout(function() {
                        window.location.href ='{{route("daybook-report.index")}}';
                    }, 100);
                    $('#error_voucher_no').text('');
                },
                error: function(data, status, xhr) {
                    if (data.status == 404) {
                        swal_message(data.responseJSON.message,'error','Error');
                    }
                    if (data.status == 422) {
                        $('#error_voucher_no').text(data.responseJSON.data.invoice_no[0]);
                    }
                }
            });
        });
    });
    input_checking('ledger');
    input_checking('godown');
    input_checking('product');
</script>
@endpush
@endsection
