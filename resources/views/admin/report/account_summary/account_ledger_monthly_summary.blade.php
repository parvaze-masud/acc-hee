@extends('layouts.backend.app')
@section('title','Account Ledger Monthly Summary')
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
 .table-scroll thead tr:nth-child(2) th {
    top: 30px;
}
.th{
    border: 1px solid #ddd;font-weight: bold;
}
.td{
    border: 1px solid #ddd; font-size: 16px;
}

table {width:100%;grid-template-columns: auto auto;}

</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Account Ledger Monthly Summary',
    'print_layout'=>'landscape',
    'print_header'=>'Account Ledger Monthly Summary',
]);

<!-- Page-header component -->
@slot('header_body')
 <form  id="add_ledger_monthly_summary_form"  method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row m-0 p-0">
        <div class="col-md-3">
            <label>Accounts Ledger : </label>
            <select name="ledger_id" class="form-control  js-example-basic-single  ledger_id" required>
                <option value="">--Select--</option>
            </select>
        </div>
        <div class="col-md-3  m-0 p-0">
            <div class="row  m-0 p-0 ">
                <div class="col-md-6 m-0 p-0 start_date">
                    <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$form_date??date('Y-m-d')}}" >
                </div>
                <div class="col-md-6 m-0 p-0 end_date">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date??date('Y-m-d') }}" >
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <br>
            <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
        </div>
    </div>
</form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd  tableFixHead_report">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers table-scroll">
        <thead>
            <tr>
                <th style="width: 1%;">SL.</th>
                <th style="width: 3%;  border: 1px solid #ddd;">Date</th>
                <th class="th"  style=" width: 5%;text-align:center;">Debit</th>
                <th class="th" style=" width: 5%;text-align:center; ">Credit</th>
                <th class="th"  style=" width: 5%;text-align:center;">Closing Balance</th>
            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 5%;" class="th">Total :</th>
                <th  style="width: 2%;font-size: 18px;" class="th total_debit"></th>
                <th  style="width: 2%;font-size: 18px;" class="th total_credit"></th>
                <th  style="width: 5%;font-size: 18px;" class="th total_closing_blance"></th>
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
<script type="text/javascript" src="{{asset('ledger&item_select_option.js')}}"></script>
<script>

    get_ledger_recursive('{{route("stock-ledger-select-option-tree")}}');
    var amount_decimals="{{company()->amount_decimals}}";
    if({{$ledger_id??0}}!=0){
        $('.ledger_id').val({{$ledger_id??0}});
    }
    $(document).ready(function () {
        function  get_ledger_monthly_summary_initial_show(){
            $.ajax({
                    url: "{{ route('account-ledger-monthly-summary-data')}}",
                    type: 'GET',
                    dataType: 'json',
                    data:{
                        to_date:$('.to_date').val(),
                        from_date:$('.from_date').val(),
                        ledger_id:$('.ledger_id').val()
                    },
                    success: function(response) {
                        get_ledger_monthly_summary_val(response.data);
                    }
            });
        }
        if({{$ledger_id??0}}!=0){
            get_ledger_monthly_summary_initial_show();
        }
    });
    // add ledger monthly summary form
    $("#add_ledger_monthly_summary_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("account-ledger-monthly-summary-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  get_ledger_monthly_summary_val(response.data)
                },
                error : function(data,status,xhr){
                }
        });
    });

    let   totalDebit=0;totalCredit=0;closingBlance=0,dr_cr_text='';

    // stock item monthly summary

    function  get_ledger_monthly_summary_val(response) {
        totalDebit = 0;
        totalCredit = 0;
        closingBlance = 0;
        dr_cr_text=response.group_chart_nature.nature_group == 1 ||  response.group_chart_nature.nature_group == 3?"Dr":'Cr';

        const opening = response.op_party_ledger[0] || { op_total_debit: 0,op_total_credit: 0 };
        let total_op_val;
        let total_op_sign;
            if(response.group_chart_nature.nature_group == 1 ||response.group_chart_nature.nature_group == 3){
                total_op_val=((response.group_chart_nature.opening_balance) + ((opening.op_total_debit || 0) - (opening.op_total_credit || 0)));
                total_op_sign = total_op_val >= 0 ? 'Dr' : 'Cr';
            }else{
                total_op_val=((response.group_chart_nature.opening_balance) + ((opening.op_total_credit || 0) - (opening.op_total_debit || 0)))
                total_op_sign = total_op_val >= 0 ? 'Cr' : 'Dr';
            }
            const openingBalance = Math.abs(total_op_val).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +  total_op_sign;

        let htmlFragments = [];

        // Opening Balance Row
        htmlFragments.push(`<tr>
                                <td style="width: 1%;  border: 1px solid #ddd;"></td>
                                <td colspan="3" style="width: 3%;"class="td">Opening Balance</td>
                                <td style="width: 3%;"class="td">${(openingBalance||0)}</td>
                            </tr>`);

        // Current Stock Rows
        if(response.party_ledger[0]){
            response.party_ledger.forEach((v, key) => {
                let closing_val;
                let total_closing_sign
                totalDebit += (v.debit_sum || 0);
                totalCredit += (v.credit_sum || 0);

                if(response.group_chart_nature.nature_group == 1 ||response.group_chart_nature.nature_group == 3){
                    closing_val= (parseFloat(v.debit_sum|| 0) - parseFloat(v.credit_sum || 0));
                    total_closing_sign= closing_val >= 0 ? 'Dr' : 'Cr';
                }else{
                    closing_val= (parseFloat(v.credit_sum || 0) - parseFloat( v.debit_sum|| 0));
                    total_closing_sign = closing_val >= 0 ? 'Cr' : 'Dr';
                }
                const currentBalance =Math.abs(closing_val).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +  total_closing_sign;

              closingBlance=parseFloat(closingBlance)+parseFloat(currentBalance);
                htmlFragments.push(`<tr id="${v.transaction_date}" class="left left-data editIcon table-row">
                                        <td style="width: 1%;  border: 1px solid #ddd;">${(key + 1)}</td>
                                        <td class="td" style="width: 3%;" class="text-wrap">${new Date(v.transaction_date).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</td>
                                        <td class="td" style="width: 3%;">${(v.debit_sum || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                        <td class="td" style="width: 3%;">${(v.credit_sum || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                        <td class="td" style="width: 3%;"> ${(currentBalance||0)}</td>

                                </tr>`);
            });
        }
        // Append the fragment to the DOM once
        $(".item_body").html(htmlFragments.join(''));
        // Update total values
        $('.total_debit').text((totalDebit||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_credit').text((totalCredit|| 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_closing_blance').text(((closingBlance||0)+(total_op_val||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' '+dr_cr_text);
        get_hover();
    }

// stock item  wise  voucher  route
$('.sd').on('click','.table-row',function(e){
    e.preventDefault();
    let date=$(this).closest('tr').attr('id');
    let ledger_id=$('.ledger_id').val();
    url = "{{route('account-ledger-voucher-month-id-wise', ['ledger_id'=>':ledger_id','date' =>':date'])}}";
    url = url.replace(':date',date);
    url = url.replace(':ledger_id',ledger_id);
    window.location=url;
});
</script>
@endpush
@endsection
