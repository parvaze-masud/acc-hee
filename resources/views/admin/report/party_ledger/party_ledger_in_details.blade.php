@extends('layouts.backend.app')
@section('title','Party Ledger Details')
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
'title' => 'Party Ledger Details',
'print_layout'=>'landscape',
'print_header'=>'Party Ledger Details',
]);

<!-- Page-header component -->
@slot('header_body')
<form id="party_ledger_details_form" method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row ">
        <div class="col-md-4">
            <label>Party Name : </label>
            <select name="ledger_id" class="form-control js-example-basic-single ledger_id">
                <option value="0">--All--</option>
                {!!html_entity_decode($ledgers)!!}
            </select>
            <div class="row  m-0 p-1">
                <div class="col-md-6 m-0 p-0">
                    <label>Date From: </label>
                    <input type="text" name="from_date" class="form-control setup_date fs-5" value="{{ date('Y-m-d') }}" name="narratiaon">
                </div>
                <div class="col-md-6 m-0 p-0">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5" value="{{ date('Y-m-d') }}" name="narratiaon">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label></label>
            <div class="form-group">
                <label class="fs-6">Description : </label>
                <input class="form-check-input description" type="radio" name="description" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    None
                </label>
                <input class="form-check-input description" type="radio" name="description" value="2">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Summary
                </label>
                <input class="form-check-input description" type="radio" name="description" value="3">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Dr Cr
                </label>
                <input class="form-check-input description" type="radio" name="description" value="4" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Ledger
                </label>
                <input class="form-check-input description" type="radio" name="description" value="5">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Inventory
                </label>
                <input class="form-check-input credit_check" type="radio" name="description" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Old Style
                </label>
                <br>
                <label class="fs-6">SORT by :</label>
                <input class="form-check-input" type="radio" name="sort_by" value="1" checked="checked">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    None
                </label>
                <input class="form-check-input " type="radio" name="sort_by" value="2">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Debit
                </label>
                <input class="form-check-input last_update" type="radio" name="sort_by" value="3">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Credit
                </label>
                <input class="form-check-input last_update" type="radio" name="sort_by" value="4">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Dr Cr Combine
                </label><br>
                <label class="fs-6">SORT type :</label>
                <input class="form-check-input" type="radio" name="sort_type" value="1" checked="checked">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    A to Z
                </label>
                <input class="form-check-input" type="radio" name="sort_type" value="2">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Z to A
                </label>

            </div>
        </div>
        <div class="col-md-2">
            <label></label>
            <div class="form-group">
                <input class="form-check-input narratiaon" type="checkbox" name="last_update" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Narration
                </label>
                <input class="form-check-input user_info" type="checkbox" name="last_update" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    User Info
                </label>
                <input class="form-check-input inline_closing_blance" type="checkbox" name="last_update" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    In-line Closing Balance
                </label>
            </div>
            <button type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;"><span class="m-1 m-t-1"></span><span>Search</span></button>
        </div>
    </div>
</form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_report_party_ledger">
    <table id="tableId" style=" border-collapse: collapse;" class="table table-striped customers ">
        <thead>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;">SL.</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Opening Balance</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Debit</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Credit</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="closing_checkbox">Current Balance</th>
            </tr>
        </thead>
        <tbody id="myTable" class="ledger_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;">SL.</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Opening Balance</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Debit</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Credit</th>
              <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="closing_checkbox">Current Balance</th>
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
    // table header fixed
    let display_height = $(window).height();
    $('.tableFixHead_report_party_ledger').css('height', `${display_height-350}px`);
    var amount_decimals = "{{company()->amount_decimals}}";
    $(document).ready(function() {
        $("#party_ledger_details_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            let ledger_id = $(".ledger_id").val();
            $.ajax({
                url: '{{ route("party-ledger-details-get-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (ledger_id == 0) {
                        get_party_ledger_val(response)
                    } else {
                        get_current_party_ledger_val(response)
                    }
                },
                error: function(data, status, xhr) {

                }
            });
        });

        function get_party_ledger_val(response) {
        const fragment = document.createDocumentFragment();

        response.data.forEach((v, key) => {
                let balance;
                let sign;
                let closingBalance;
                let closingsign;
                 if(v.nature_group == 1 || v.nature_group == 3){
                     balance= parseFloat(v.opening_balance) + (parseFloat(v.op_group_debit || 0) - parseFloat(v.op_group_credit || 0))
                     sign = balance >= 0 ? 'Dr' : 'Cr';
                 }else{
                    balance= parseFloat(v.opening_balance) + (parseFloat(v.op_group_credit || 0) - parseFloat(v.op_group_debit || 0));
                    sign = balance >= 0 ? 'Cr' : 'Dr';
                 }

                const openingBalance = Math.abs(balance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' + sign;
                const totalDebit = (v.total_debit || 0).toFixed(amount_decimals);
                const totalCredit = (v.total_credit || 0).toFixed(amount_decimals);

                if(v.nature_group == 1 || v.nature_group == 3){
                    closingBalance= ((((parseFloat(v.op_group_debit || 0) - parseFloat(v.op_group_credit || 0)) +
                        (parseFloat(v.total_debit || 0)) - parseFloat(v.total_credit || 0)) + (v.opening_balance))) ;
                    closingsign = closingBalance >= 0 ? 'Dr' : 'Cr';
                }else{
                    closingBalance= ((((parseFloat(v.op_group_credit || 0) - parseFloat(v.op_group_debit || 0)) +
                        (parseFloat(v.total_credit || 0)) - parseFloat(v.total_debit || 0)) + (v.opening_balance)));
                    closingsign = closingBalance >= 0 ? 'Cr' : 'Dr';
                }
                const currentBalance = Math.abs(balance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +closingsign;

            const row = document.createElement('tr');
            row.className = 'left left-data editIcon table-row';
            row.innerHTML = `
                <td style="width: 1%; border: 1px solid #ddd;">${key + 1}</td>
                <td style="width: 3%; border: 1px solid #ddd; font-size: 16px;">${v.ledger_name || ''}</td>
                <td style="width: 3%; border: 1px solid #ddd; font-size: 20px;">${openingBalance}</td>
                <td style="width: 2%; border: 1px solid #ddd; font-size: 20px;">${totalDebit.replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                <td style="width: 2%; border: 1px solid #ddd; font-size: 20px;">${totalCredit.replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                <td style="width: 3%; border: 1px solid #ddd; font-size: 20px;">${currentBalance}</td>
            `;

            fragment.appendChild(row);
        });
       $(".ledger_body").html(fragment);
        get_hover();
    }
});

    function get_current_party_ledger_val(response) {
        let dr_cr;
        var html = '';
        html += '<table   id="tableId"  style=" border-collapse: collapse;"   class="table  customers wrap" >';
        html += '<thead >';
        html += '<tr>';
        html += '<th style="width: 1%;  border: 1px solid #ddd;">SL.</th>';
        html += '<th style="width: 1%;  border: 1px solid #ddd;">Date</th>';
        html += '<th style="width: 6%;  border: 1px solid #ddd;">Particulars</th>';
        html += '<th style="width: 1%;  border: 1px solid #ddd;">Voucher Type</th>';
        html += '<th style="width: 1%;  border: 1px solid #ddd;" >Voucher No</th>';
        html += '<th style="width: 2%;  border: 1px solid #ddd;" >Debit</th>';
        html += '<th style="width: 2%;  border: 1px solid #ddd;" >Credit</th>';
        if ($(".inline_closing_blance").is(':checked')) {
            html += '<th style="width: 2%;  border: 1px solid #ddd;" >Blance</th>';
        }
        html += '</tr>';
        html += '</thead>';
        html += '<tbody id="myTable" class="qw">';
        //Opening Balance
        if ($(".inline_closing_blance").is(':checked')) {
            if ((response.data.group_chart_nature.nature_group == 1) || (response.data.group_chart_nature.nature_group == 3)) {
                let debit_opening = (response.data.op_party_ledger[0] ? (parseFloat(response.data.op_party_ledger[0].op_total_debit1 ? response.data.op_party_ledger[0].op_total_debit1 : 0) - parseFloat(response.data.op_party_ledger[0].op_total_credit1 ? response.data.op_party_ledger[0].op_total_credit1 : 0)) : 0) + (response.data.group_chart_nature.opening_balance || 0);;
                html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2"  style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">Opening Balance :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + (debit_opening ? debit_opening : 0).toFixed(amount_decimals) + ' Dr</td> </tr>';
            }
            if ((response.data.group_chart_nature.nature_group == 2) || (response.data.group_chart_nature.nature_group == 4)) {
                let credit_opning = (response.data.op_party_ledger[0] ? (parseFloat(response.data.op_party_ledger[0].op_total_credit2 ? response.data.op_party_ledger[0].op_total_credit2 : 0) - parseFloat(response.data.op_party_ledger[0].op_total_debit2 ? response.data.op_party_ledger[0].op_total_debit2 : 0)) : 0) + (response.data.group_chart_nature.opening_balance || 0);
                html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td text-aline  colspan="2" style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">Opening Balance :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + (credit_opning ? credit_opning : 0).toFixed(amount_decimals) + ' Cr</td> </tr>';
            }

        }

        let closing_blance = 0,
            debit = 0,
            credit = 0,
            ledger_dr_cr;

        // ledger array
        $.each(response.data.party_ledger, function(key, v) {
            ledger_dr_cr = v.DrCr;
            debit += parseFloat(v.debit_sum ? v.debit_sum : 0);
            credit += parseFloat(v.credit_sum ? v.credit_sum : 0);
            html += '<tr id=' + v.tran_id + "," + v.voucher_type_id + ' class="left left-data editIcon table-row"> ';
            html += '<td  style="width: 1%;  border: 1px solid #ddd;">' + (key + 1) + '</td>';
            html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px;">' + join(new Date(v.transaction_date), options, ' ') + '</td>';
            html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px; "><i style="font-weight: bold">' + (v.ledger_name ? v.ledger_name : '') + '</i>';
            // ledger
            if (($("input[type='radio'].description:checked").val() == 4) || (($("input[type='radio'].description:checked").val() == 5))) {
                if (response.data.description_ledger[key] != undefined) {
                    for (var i = 0, l1 = response.data.description_ledger[key].length; i < l1; i++) {
                        if (response.data.description_ledger[key][i].tran_id == v.tran_id) {
                            html += '<table><tbody width: 100%;><td width: 100%;"><i style="font-size: 13px;">' + response.data.description_ledger[key][i].ledger_name + '</i></td><td width: 100%; tyle="text-align: right;"><i style="font-size: 15px;font-weight: bold">' + (response.data.description_ledger[key][i].dr_cr == "Dr" ? ((response.data.description_ledger[key][i].debit).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' Dr ') : (response.data.description_ledger[key][i].credit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' Cr ')) + '</i></td></tbody></table>';
                        }
                    }
                }
            }

            // stock out
            if ($("input[type='radio'].description:checked").val() == 5) {
                if (response.data.description_stock_out[key] != undefined) {
                    for (var i = 0, l1 = response.data.description_stock_out[key].length; i < l1; i++) {
                        if (response.data.description_stock_out[key][i].stock_out_tran_id == (v.tran_id)) {
                            html += '<table><tbody width: 100%;><td width: 100%;"><i style="font-size: 13px;">' + response.data.description_stock_out[key][i].product_name + '</i></td><td width: 100%;><i style="font-size: 15px;font-weight: bold">' + (response.data.description_stock_out[key][i].qty) + (response.data.description_stock_out[key][i].symbol) + '</i></td><td><i style="font-size: 15px;font-weight: bold ">' + (response.data.description_stock_out[key][i].rate) + '/' + (response.data.description_stock_out[key][i].symbol) + '</i></td><td><i style="font-size: 15px; font-weight: bold">' + (response.data.description_stock_out[key][i].total).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</i></td></tbody></table>';
                        }
                    }
                }

                // stock in
                if (response.data.description_stock_in[key] != undefined) {
                    for (var i = 0, l1 = response.data.description_stock_in[key].length; i < l1; i++) {
                        if (response.data.description_stock_in[key][i].stock_in_tran_id == v.tran_id) {
                            html += '<table><tbody width: 100%;><td width: 100%;"><i style="font-size: 13px;">' + response.data.description_stock_in[key][i].product_name + '</i></td><td width: 100%;><i style="font-size: 15px;font-weight: bold">' + (response.data.description_stock_in[key][i].qty) + (response.data.description_stock_in[key][i].symbol) + '</i></td><td><i style="font-size: 15px;font-weight: bold ">' + (response.data.description_stock_in[key][i].rate) + '/' + (response.data.description_stock_in[key][i].symbol) + '</i></td><td><i style="font-size: 15px; font-weight: bold">' + (response.data.description_stock_in[key][i].total).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</i></td></tbody></table>';
                        }
                    }
                }
            }
            if ($(".user_info").is(':checked')) {
                html += '<div > <i style="font-size: 12px;">' + JSON.parse(v.other_details) + '</i></div>';
            }
            if (($(".narratiaon").is(':checked'))) {
                html += '<div> <i style="font-size: 12px;">' + (v.narration ? v.narration : '') + '</i></div>';
            }
            html += '</td>';
            html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px;"><a class="party_ledger_voucher" style=" text-decoration: none; font-size: 16px;color:#0B55C4;" href="#">' + v.voucher_name + '</a></td>';
            html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px;">' + v.invoice_no + '</td>';
            html += '<td  style="width: 2%;  border: 1px solid #ddd; text-align: right; font-size: 20px;">' + (v.debit ? (v.debit_sum ? v.debit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '') : '') + '</td>';
            html += '<td  style="width: 2%;  border: 1px solid #ddd;text-align: right; font-size: 20px;">' + (v.credit ? (v.credit_sum ? v.credit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '') : '') + '</td>';
            if (response.data.group_chart_nature.nature_group == 1 || response.data.group_chart_nature.nature_group == 3) {
                dr_cr = "Dr";
                if (key == 0) {
                    closing_blance += (response.data.op_party_ledger[0] ? ((parseFloat(response.data.op_party_ledger[0].op_total_debit1 || 0) - parseFloat(response.data.op_party_ledger[0].op_total_credit1 || 0)) + (parseFloat(v.debit_sum || 0) - parseFloat(v.credit_sum || 0))) : 0) + (response.data.group_chart_nature.opening_balance || 0);
                } else {
                    closing_blance += ((parseFloat(v.debit_sum ? v.debit_sum : 0) - parseFloat(v.credit_sum ? v.credit_sum : 0)));
                }
                if ($(".inline_closing_blance").is(':checked')) {
                    html += '<td  style="width: 2%;  border: 1px solid #ddd;text-align: right; font-size: 20px;">' + (closing_blance || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' Dr</td>';
                }
            }
            if (response.data.group_chart_nature.nature_group == 2 || response.data.group_chart_nature.nature_group == 4) {
                dr_cr = "Cr";
                if (key == 0) {
                    closing_blance += (response.data.op_party_ledger[0] ? ((parseFloat(response.data.op_party_ledger[0].op_total_credit2 || 0) - parseFloat(response.data.op_party_ledger[0].op_total_debit2 || 0)) + (parseFloat(v.credit_sum || 0) - parseFloat(v.debit_sum || 0))) : 0) + (response.data.group_chart_nature.opening_balance || 0);
                } else {
                    closing_blance += ((parseFloat(v.credit_sum || 0) - parseFloat(v.debit_sum || 0)));
                }
                if ($(".inline_closing_blance").is(':checked')) {
                    html += '<td  style="width: 1%;  border: 1px solid #ddd;text-align: right; font-size: 20px;">' + (closing_blance || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' Cr</td>';
                }
            }

            html += "</tr> ";
        });

        // Opening Balance
        if ($(".inline_closing_blance").is(':checked')) {
            html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2" style="width: 1%;font-weight: bold;  border: 1px solid #ddd;font-size: 18px;text-align: right;">Closing Balance  :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + (parseFloat(closing_blance || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + (dr_cr || '') + '</td> </tr>';
        } else {
            html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2" style="width: 1%; border: 1px solid #ddd;font-size: 18px; text-align: right;">Current Balance  :</td><td style="width: 1%;  border: 1px solid #ddd; font-size: 20px; text-align: right; ">' + (debit).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td><td style="width: 1%;  border: 1px solid #ddd; font-size: 20px; text-align: right;">' + (credit).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td></tr>';
            if (response.data.group_chart_nature.nature_group == 1 || response.data.group_chart_nature.nature_group == 3) {
                let debit_opening_blance = (response.data.op_party_ledger[0] ? (parseFloat(response.data.op_party_ledger[0].op_total_debit1 || 0) - parseFloat(response.data.op_party_ledger[0].op_total_credit1 || 0)) : 0) + (response.data.group_chart_nature.opening_balance || 0);
                html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2" style="width: 1%;   border: 1px solid #ddd;font-size: 18px; text-align: right;">Opening Balance :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + (debit_opening_blance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td> </tr>';
                html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2" style="width: 1%; font-weight: bold; border: 1px solid #ddd;font-size: 18px;text-align: right;">Closing Balance  :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + ((debit_opening_blance + parseFloat(debit || 0)) - (credit || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td> </tr>';
            }
            if (response.data.group_chart_nature.nature_group == 2 || response.data.group_chart_nature.nature_group == 4) {
                let credit_opning_blance = (response.data.op_party_ledger[0] ? (parseFloat(response.data.op_party_ledger[0].op_total_credit2 || 0) - parseFloat(response.data.op_party_ledger[0].op_total_debit2 || 0)) : 0) + (response.data.group_chart_nature.opening_balance || 0);
                html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2"  style="width: 1%;   border: 1px solid #ddd;font-size: 18px;  text-align: right;">Opening Balance :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + (credit_opning_blance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td> </tr>';
                html += '<tr class="left left-data editIcon table-row"><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td><td colspan="2" style="width: 1%; font-weight: bold; border: 1px solid #ddd;font-size: 18px;  text-align: right;">Closing Balance  :</td><td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;">' + ((credit_opning_blance + (credit || 0)) - (debit||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td> </tr>';
            }
        }

        html += '</tbody>';
        html += '</table>';
        $(".sd").html(html);
        get_hover();
    }

    //get  all data show
    $(document).ready(function() {

        $('.sd').on('click', '.customers tbody tr .party_ledger_voucher', function(e) {
            e.preventDefault();
            let day_book_arr = $(this).closest('tr').attr('id').split(",");;
            window.location = "{{url('voucher-receipt/edit')}}" + '/' + day_book_arr[0];
            if (day_book_arr[1] == 14) {
                window.location = "{{url('voucher-receipt/edit')}}" + '/' + day_book_arr[0];
            } else if (day_book_arr[1] == 8) {
                window.location = "{{url('voucher-payment')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 1) {
                window.location = "{{url('voucher-contra')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 10) {
                window.location = "{{url('voucher-purchase')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 24) {
                window.location = "{{url('voucher-grn')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 19) {
                window.location = "{{url('voucher-sales')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 23) {
                window.location = "{{url('voucher-gtn')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 29) {
                window.location = "{{url('voucher-purchase-return')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 22) {
                window.location = "{{url('voucher-transfer')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 25) {
                window.location = "{{url('voucher-sales-return')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 21) {
                window.location = "{{url('voucher-stock-journal')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 6) {
                window.location = "{{url('voucher-journal')}}" + '/' + day_book_arr[0] + '/edit';
            } else if (day_book_arr[1] == 28) {
                window.location = "{{url('voucher-commission')}}" + '/' + day_book_arr[0] + '/edit';
            }

        })
    });
</script>
@endpush
@endsection
