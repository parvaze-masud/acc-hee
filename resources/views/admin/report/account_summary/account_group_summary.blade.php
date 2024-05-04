
@extends('layouts.backend.app')
@section('title','Account Group Summary')
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
    table {width:100%;grid-template-columns: auto auto;}
    .td{
        width: 3%;  border: 1px solid #ddd; font-size: 16px; color: #0B55C4;
    }
    .table-scroll thead tr:nth-child(2) th {
        top: 30px;
    }
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Account Group Summary',
    'print_layout'=>'landscape',
    'print_header'=>'Account Group Summary',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="account_group_summary_form"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-4">
                <label>Accounts Group :</label>
                <select name="group_id" class="form-control  js-example-basic-single  group_id" required>
                    <option value="">--Select--</option>
                    {!!html_entity_decode($group_chart_data)!!}
                </select>
            </div>
            <div class="col-md-4">
                <div class="row  m-0 p-0">
                    <div class="col-md-6 m-0 p-0">
                        <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$form_date?? company()->financial_year_start }}">
                    </div>
                    <div class="col-md-6 m-0 p-0">
                        <label>Date To : </label>
                        <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date??date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label></label><br>
                <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
            </div>
        </div>
    </form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_report">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers tree table-scroll">
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">SL</th>
                <th rowspan="2" style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>
                <th rowspan="2" style="width: 2%;  border: 1px solid #ddd;font-weight: bold;" class="opening_checkbox">Opening Balance</th>
                <th colspan="2" style=" width: 5%; border: 1px solid #ddd;font-weight: bold; text-align:center;">Transactions</th>
                <th rowspan="2" style="width: 3%;  border: 1px solid #ddd;font-weight: bold; text-align:center;" class="closing_checkbox">Closing Balance</th>
            </tr>
            <tr>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="debit_checkbox">Debit Amount</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;" class="credit_checkbox">Credit Amount</th>

            </tr>

        </thead>
        <tbody id="myTable" class="item_body ">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;"></th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Total :</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_opening opening_checkbox"></th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_debit debit_checkbox"></th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_credit credit_checkbox"></th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;font-size: 18px;"  class="total_clasing closing_checkbox"></th>


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
var amount_decimals="{{company()->amount_decimals}}";
let  total_opening=0; total_debit=0; total_credit=0;total_clasing=0;i=1;
// group chart  id check
if({{$group_id??0}}!=0){
     $('.group_id').val('{{$group_id??0}}');
}
// group wise  party ledger quantity
$(document).ready(function () {
    // get party ledger
    function get_account_group_summary_initial_show(){
            $.ajax({
                url: '{{ route("account-group-summary-data") }}',
                    method: 'GET',
                    data: {
                        to_date:$('.to_date').val(),
                        from_date:$('.from_date').val(),
                        group_id:$(".group_id").val(),
                    },
                    dataType: 'json',
                    success: function(response) {
                        get_account_group_summary(response)
                    },
                    error : function(data,status,xhr){
                    }
            });
        }
    // group chart get id check
    if({{$group_id??0}}!=0){
         get_account_group_summary_initial_show();
    }

    $("#account_group_summary_form").submit(function(e) {
            total_opening=0; total_debit=0; total_credit=0;total_clasing=0;i=1;
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route("account-group-summary-data") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                    result=[];
                    get_account_group_summary(response)
                    },
                    error : function(data,status,xhr){

                    }
            });
 });

// group wise party ledger function
function  get_account_group_summary(response){
    const children_sum= calculateSumOfChildren(response.data);
       $('.item_body').html(getTreeView(response.data,children_sum));
       $('.total_opening').text((total_opening||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
       $('.total_debit').text(((total_debit||0)||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
       $('.total_credit').text((total_credit||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
       $('.total_clasing').text((total_clasing||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
     }
});

// alcucation child summation
function calculateSumOfChildren(arr) {
    const result = {};

    function sumProperties(obj, prop) {
        return obj.reduce((acc, val) => acc + (val[prop] || 0), 0);
    }

    function processNode(node) {
        if (!result[node.group_chart_id]) {
            result[node.group_chart_id] = {
                group_chart_id: node.group_chart_id,
                group_debit: 0,
                group_credit: 0,
                op_group_debit: 0,
                op_group_credit: 0
            };
        }

        const currentNode = result[node.group_chart_id];
        currentNode. group_debit += node.group_debit || 0;
        currentNode.group_credit += node.group_credit || 0;
        currentNode.op_group_debit += node.op_group_debit || 0;
        currentNode.op_group_credit += node.op_group_credit || 0;
        if (node.children) {
            node.children.forEach(processNode);
        }
    }

    arr.forEach(processNode);

    return Object.values(result);
}

i=1;
function getTreeView(arr, children_sum, depth = 0, chart_id = 0) {

    let htmlFragments = [];
    arr.forEach(function (v) {
        a = '&nbsp;&nbsp;&nbsp;&nbsp;';
        h = a.repeat(depth);
      if (v.under != 0) {
            if (chart_id != v.group_chart_id) {

                htmlFragments.push(`<tr id="${v.group_chart_id + '-' + v.under}" class='left left-data group_chart_id table-row'><td class="td"></td> <td style='width: 3%; border: 1px solid #ddd; font-size: 16px; color: #0B55C4'><p style="margin-left:${(h + a + a).length}px;" class="text-wrap mb-0 pb-0 ">${v.group_chart_name}</p></td>`);

                let matchingChild = children_sum.find(c =>v.group_chart_id == c.group_chart_id);
                if (matchingChild) {
                    let total_op_val;
                    let total_op_sign;
                    let total_closing_val;
                    let total_closing_sign;
                    if(v.nature_group == 1 || v.nature_group == 3){
                        total_op_val=((matchingChild.op_group_debit || 0) - (matchingChild.op_group_credit || 0));
                        total_op_sign = total_op_val >= 0 ? 'Dr' : 'Cr';
                    }else{
                        total_op_val=((matchingChild.op_group_credit || 0) -(matchingChild.op_group_debit || 0))
                        total_op_sign = total_op_val >= 0 ? 'Cr' : 'Dr';
                    }
                    const totalOpeningBalance = Math.abs(total_op_val).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +  total_op_sign;
                    if(v.nature_group == 1 || v.nature_group == 3){
                        total_closing_val=(((matchingChild.op_group_debit || 0) - (matchingChild.op_group_credit || 0) + (matchingChild.group_debit || 0)) - (matchingChild.group_credit || 0));
                        total_closing_sign = total_closing_val >= 0 ? 'Dr' : 'Cr';
                    }else{
                        total_closing_val=((matchingChild.op_group_credit || 0) - (matchingChild.op_group_debit || 0) + (matchingChild.group_credit || 0)) - (matchingChild.group_debit || 0);
                        total_closing_sign = total_closing_val >= 0 ? 'Cr' : 'Dr';
                    }
                    const totalCurrentBalance = Math.abs(total_closing_val).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' + total_closing_sign;

                    htmlFragments.push(`<td class="td">  ${totalOpeningBalance}</td>
                                        <td class="td"> ${((matchingChild.group_debit || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')} </td>
                                        <td class="td"> ${((matchingChild.group_credit || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                        <td class="td"> ${totalCurrentBalance} </td>`);
                    }

                htmlFragments.push(`</tr>`);
                chart_id = v.group_chart_id;
            }

            if (v.ledger_head_id) {
                    let opening_val;
                    let op_sign;
                    let clasing_val;
                    let closing_sign;
                    if(v.nature_group == 1 || v.nature_group == 3){
                        opening_val=parseFloat(v.opening_balance||0)+(v.op_total_debit || 0) - (v.op_total_credit || 0);
                        op_sign = opening_val >= 0 ? 'Dr' : 'Cr';
                    }else{
                        opening_val=parseFloat(v.opening_balance||0)+(v.op_total_credit || 0) - (v.op_total_debit || 0);
                        op_sign = opening_val >= 0 ? 'Cr' : 'Dr';
                    }
                    total_opening =total_opening+ parseFloat(opening_val);
                    const openingBalance = Math.abs(opening_val).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +  op_sign;

                    total_debit += (v.total_debit || 0);
                    total_credit += (v.total_credit || 0);
                    if(v.nature_group == 1 || v.nature_group == 3){
                        clasing_val=parseFloat(v.opening_balance||0)+(((v.op_total_debit||0) - (v.op_total_credit||0) + (v.total_debit||0)) - (v.total_credit||0));
                        closing_sign=clasing_val >= 0 ? 'Dr' : 'Cr';
                    }else{
                        clasing_val=parseFloat(v.opening_balance||0)+(((v.op_total_credit || 0) - (v.op_total_debit || 0) + (v.total_credit || 0)) - (v.total_debit || 0));
                        closing_sign=clasing_val >= 0 ? 'Cr' : 'Dr';
                    }


                    total_clasing = parseFloat(total_clasing)+parseFloat(clasing_val);
                    const currentBalance = Math.abs(clasing_val).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +closing_sign;

                    htmlFragments.push(`<tr id="${v.ledger_head_id}" class="left left-data table-row ledger_id" >
                                            <td class="sl" style="width: 1%;  border: 1px solid #ddd;">${i++}</td>
                                            <td style='width: 3%;  border: 1px solid #ddd; font-size: 16px;' ><p style="margin-left:${(h + a + a + a).length}px" class="text-wrap mb-0 pb-0">${v.ledger_name}</p></td>
                                            <td  class='td opening'>${(openingBalance)} </td>
                                            <td class='td'>${((v.total_debit || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')} </td>
                                            <td class='td'>${((v.total_credit || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')} </td>
                                            <td class='td'> ${(currentBalance)}</td>
                                    </tr>`);
            }
      }
            if ('children' in v) {
                htmlFragments.push(getTreeView(v.children, children_sum, depth + 1, chart_id));
            }

    });

    return htmlFragments.join('');
}

//get  all data show
$(document).ready(function () {
    // month   wise ledger route
    $('.sd').on('click','.ledger_id',function(e){
        e.preventDefault();
        let ledger_id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        url = "{{route('account-ledger-monthly-summary-id-wise', ['ledger_id' =>':ledger_id', 'form_date' =>':form_date','to_date' =>':to_date'])}}";
        url = url.replace(':ledger_id',ledger_id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        window.location=url;
    });
   // group   ledger wise summary route
   $('.sd').on('click','.group_chart_id',function(e){
        e.preventDefault();
        let  group_chart_id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        url = "{{route('account-group-summary-id-wise', ['group_chart_id' =>':group_chart_id', 'form_date' =>':form_date','to_date' =>':to_date'])}}";
        url = url.replace(':group_chart_id',group_chart_id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        window.location=url;
    })
});
</script>
@endpush
@endsection
