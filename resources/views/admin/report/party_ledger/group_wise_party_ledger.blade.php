
@extends('layouts.backend.app')
@section('title','Group Wise  Party Ledger')
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
    'title' => 'Group Wise  Party Ledger',
    'print_layout'=>'landscape',
    'print_header'=>'Group Wise  Party Ledger',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="group_wise_party_form"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-3">
                <label>Accounts Group :</label>
                <select name="group_id" class="form-control  js-example-basic-single  group_id" required>
                    <option value="">--Select--</option>
                    {!!html_entity_decode($group_chart_data)!!}
                </select>
            </div>
            <div class="col-md-3">
                <label></label>
                <div class="form-group mb-0" style="position: relative">
                    <input class="form-check-input ledger_alias" type="checkbox"  name="ledger_alias"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Ledger Alias
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <input class="form-check-input opening_blance" type="checkbox"  name="opening_blance"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Opening Balance
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <input class="form-check-input debit_amount" type="checkbox"  name="debit_amount"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Debit Amount
                    </label>
                    <input class="form-check-input credit_amount" type="checkbox"  name="credit_amount"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Credit Amount
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <input class="form-check-input  closing_blance" type="checkbox"  name="closing_blance"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Closing Balance
                    </label>
               </div>

            </div>
            <div class="col-md-3">
                <div class="row  m-0 p-0">
                    <div class="col-md-6 m-0 p-0">
                        <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$form_date?? date('Y-m-d')}}">
                    </div>
                    <div class="col-md-6 m-0 p-0">
                        <label>Date To : </label>
                        <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date?? date('Y-m-d') }}">
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
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers ">
        <thead>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;">SL.</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="alias_checkbox">Alias</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;" class="opening_checkbox">Opening Balance</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="debit_checkbox">Debit Amount</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;" class="credit_checkbox">Credit Amount</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="closing_checkbox">Closing Balance</th>
            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;"></th>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;" class="alias_checkbox"></th>
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
<script type="text/javascript" src="{{asset('dist/jquery-simple-tree-table.js')}}"></script>
<script>
var amount_decimals="{{company()->amount_decimals}}";
let  total_opening=0; total_debit=0; total_credit=0;total_clasing=0; i=1;
// group chart  id check
if({{$group_id??0}}!=0){
     $('.group_id').val('{{$group_id??0}}');
}
// group wise  party ledger quantity
$(document).ready(function () {
    // get party ledger
    function get_group_party_ledger_initial_show(){
            $.ajax({
                url: '{{ route("group-wise-party-ledger-get-data") }}',
                    method: 'GET',
                    data: {
                        to_date:$('.to_date').val(),
                        from_date:$('.from_date').val(),
                        group_id:$(".group_id").val(),
                    },
                    dataType: 'json',
                    success: function(response) {
                        get_group_wise_party_ledger(response)
                    },
                    error : function(data,status,xhr){
                    }
            });
        }
    // group chart get id check
    if({{$group_id??0}}!=0){
         get_group_party_ledger_initial_show();
    }
    $("#group_wise_party_form").submit(function(e) {
            total_opening=0; total_debit=0; total_credit=0;total_clasing=0 ; i=1;
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route("group-wise-party-ledger-get-data") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                    result=[];
                    get_group_wise_party_ledger(response)
                    },
                    error : function(data,status,xhr){

                    }
            });
    });
// group wise party ledger function
function get_group_wise_party_ledger(response){
    const children_sum= calculateSumOfChildren(response.data);
    var tree=getTreeView(response.data,children_sum);
       $('.item_body').html(tree);
        get_hover();
        $('.total_opening').text(total_opening.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_debit').text(total_debit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_credit').text(total_credit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing').text(total_clasing.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

        //checking condition
        $(".alias_checkbox").css("display", $(".ledger_alias" ).is(':checked')==true?'':'none');
        $(".opening_checkbox").css("display", $(".opening_blance" ).is(':checked')==true?'':'none');
        $(".debit_checkbox").css("display", $(".debit_amount" ).is(':checked')==true?'':'none');
        $(".credit_checkbox").css("display", $(".credit_amount" ).is(':checked')==true?'':'none');
        $(".closing_checkbox").css("display", $(".closing_blance" ).is(':checked')==true?'':'none');
     }
});

var result = [];

// calcucation child summation
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

function  getTreeView(arr,children_sum,depth = 0 ,chart_id=0){
        var eol = '<?php echo str_replace(array("\n","\r"),array('\\n','\\r'),PHP_EOL) ?>';
        let htmlFragments = [];
        arr.forEach(function (v) {
                a='&nbsp;&nbsp;&nbsp;&nbsp;';
                h=  a.repeat(depth);
                    if(chart_id!=v.group_chart_id){
                            htmlFragments.push(`<tr id="${v.group_chart_id + '-' + v.under}" class='left left-data group_chart_id table-row table-row_tree'>
                                <td class="td"></td>
                                <td style='width: 3%; border: 1px solid #ddd; font-size: 16px; color: #0B55C4'><p style="margin-left:${(h + a + a).length}px;" class="text-wrap mb-0 pb-0 ">${v.group_chart_name}</p></td>
                                <td class="td"></td>
                              `);
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
                   if(v.ledger_head_id){
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

                    htmlFragments.push(`<tr id="${v.ledger_head_id}" class="table-row table-row_id">
                                <td style="width: 1%;  border: 1px solid #ddd;">${i++}</td>
                                <td  style="width: 5%;  border: 1px solid #ddd;font-size: 16px;"><p style="margin-left:${(h+a+a+a).length}px" class="text-wrap mb-0 pb-0">${v.ledger_name}</p></td>
                                <td class='alias_checkbox' style='width: 3%;  border: 1px solid #ddd; font-size: 16px;'>${(v.alias||'')}</td>
                                <td class='opening_checkbox' style='width: 3%;  border: 1px solid #ddd; font-size: 16px;'class='opening'>${(openingBalance)}</td>
                                <td class='debit_checkbox' style='width: 3%;  border: 1px solid #ddd; font-size: 16px;'class='inwards'>${(((v.total_debit||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                                <td class='credit_checkbox' style='width: 3%;  border: 1px solid #ddd; font-size: 16px;'class='outwards'>${(((v.total_credit||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                                <td class='closing_checkbox' style='width: 3%;  border: 1px solid #ddd; font-size: 16px;'class='clasing'>${(currentBalance)}</td>
                            </tr>`);
                   }
                if ('children' in v){
                    htmlFragments.push(getTreeView(v.children,children_sum,depth + 1,chart_id));
                }
        });
        return htmlFragments.join('');
}
//get  all data show
$(document).ready(function () {
    // party ledger  wise summary route
    $('.sd').on('click','.table-row_id',function(e){
        e.preventDefault();
        let ledger_id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        url = "{{route('party-ledger-id-wise', ['ledger_id' =>':ledger_id', 'form_date' =>':form_date','to_date' =>':to_date'])}}";
        url = url.replace(':ledger_id',ledger_id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        window.location=url;
    });
   // group  party ledger wise summary route
    $('.sd').on('click','.table-row_tree',function(e){
        e.preventDefault();
        let  group_chart_id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        url = "{{route('group-wise-party-ledger-id-wise', ['group_chart_id' =>':group_chart_id', 'form_date' =>':form_date','to_date' =>':to_date'])}}";
        url = url.replace(':group_chart_id',group_chart_id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        window.location=url;
    })
});
</script>
@endpush
@endsection
