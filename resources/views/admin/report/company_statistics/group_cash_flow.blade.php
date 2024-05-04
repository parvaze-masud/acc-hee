
@extends('layouts.backend.app')
@section('title',' Group Cash Flow')
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
    'title' => 'Group Cash Flow',
    'print_layout'=>'landscape',
    'print_header'=>'Group Cash Flow ',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="group_cash_flow_form"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-4 ">
                <label></label>
                <select name="group_id" id="group_id" class="form-control  js-example-basic-single  group_id left-data group_id_add" required>
                    <option value="">--Select--</option>
                    {!!html_entity_decode($group_chart_data)!!}
                </select>
            </div>
            <div class="col-md-4 ">
                <div class="row  m-0 p-0">
                    <div class="col-md-6 m-0 p-0">
                        <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$form_date??company()->financial_year_start }}" >
                    </div>
                    <div class="col-md-6 m-0 p-0">
                        <label>Date To : </label>
                        <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date??date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label></label>
                <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
            </div>
        </div>
    </form>
@endslot

<!-- Main body component -->
@slot('main_body')
 <div class="dt-responsive table-responsive cell-border sd tableFixHead_report " >
 </div>
@endslot
@endcomponent
<br>
@push('js')
<!-- table hover js -->
<script type="text/javascript" src="{{asset('libraries/assets/table-hover.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/jquery-simple-tree-table.js')}}"></script>
<script>
if({{$group_id??0}}!=0){
     $('.group_id').val({{$group_id??0}});
}

var amount_decimals="{{company()->amount_decimals}}";
let total_debit=0,total_credit=0;
$(document).ready(function () {
    //get group cash flow initial show
    function  get_group_cash_flow_initial_show(){
        $.ajax({
            url: "{{ url('group-cash-flow-get-data')}}",
            type: 'GET',
            dataType: 'json',
            data:{
                to_date:$('.to_date').val(),
                from_date:$('.from_date').val(),
                group_id:$('.group_id').val()
            },
            success: function(response) {

            get_cash_flow(response)
            }
        })
    }
    if({{$group_id??0}}!=0){
        get_group_cash_flow_initial_show();
    }
    $("#group_cash_flow_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("group-cash-flow-get-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  result=[];
                   get_cash_flow(response)
                },
                error : function(data,status,xhr){

                }
        });
    });

    function get_cash_flow(response){
        addTotalFromChildren(response.data)
        const children_sum= calculateSumOfChildren(response.data);
        var tree=getTreeView(response.data,children_sum);
            var html='';
                        html +='<table  id="tableId"  style=" border-collapse: collapse;"   class="table  customers wrap" >';
                            html +='<thead >';
                                html+='<tr>';
                                    html+= '<th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;">SL.</th>';
                                    html+= '<th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>';
                                    html+= '<th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Inflow</th>';
                                    html+='<th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Outflow</th>';
                                html+='</tr>';
                            html+='</thead>';
                            html+='<tbody id="myTable" class="qw">';
                                html+=tree;
                            html+='</tbody>';
                            html +='<tfoot>';
                                    html+= '<th style="width: 1%;  border: 1px solid #ddd; font-weight: bold;">SL.</th>';
                                    html+= '<th style="width: 3%;  border: 1px solid #ddd; font-weight: bold;">Total</th>';
                                    html+= '<th class="total_debit" style="width: 2%;  border: 1px solid #ddd; font-weight: bold;font-size: 18px"></th>';
                                    html+='<th class="total_credit" style="width: 3%;  border: 1px solid #ddd; font-weight: bold;font-size: 18px"></th>';
                            html+='</tfoot>';
                        html+='</table>';
                        html += `<div class="col-sm-12 text-center hide-btn" >
                            <span><b>Copyright &copy; 2014-2022 <a href="http://www.hamko-ict.com/">Hamko-ICT.</a> All rights reserved.</b></span>
                        </div>`
                $(".sd").html(html);
                $('#tableId').simpleTreeTable({
                        opened: [],
                        iconPosition: 'td:eq(1) > span'
                    });
                get_hover();
                    let debit_sum=0,credit_sum=0;
                    $('tbody').find('tr .sl').each(function(i){
                    $(this).text(i+1);
                    debit_sum+=parseFloat($(this).closest('tr').find('.debit_data').text().replace(",", ""));
                    credit_sum+=parseFloat($(this).closest('tr').find('.credit_data').text().replace(",", ""));
                    });
                    $('.total_debit').text(debit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('.total_credit').text(credit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))

        }
});

    var result = [];
    function calculateSumOfChildren(arr) {
            arr.reduce(function(res, value) {
            if (!res[value.group_chart_id]) {
                res[value.group_chart_id] = { group_chart_id: value.group_chart_id, group_debit: 0,group_credit: 0 };
                result.push(res[value.group_chart_id])
            }
            res[value.group_chart_id].group_debit += value.group_debit;
            res[value.group_chart_id].group_credit += value.group_credit;

            if ('children' in value){
                    calculateSumOfChildren(value.children);
            }
            return res;
            }, {});
            return result;


    }
    function addTotalFromChildren(arr){ //Important function
        arr.forEach(obj => { //For each element of the array
            if("children" in obj) { //Check if element has children
            addTotalFromChildren(obj.children) //Then, we need to calculate the add total for those children
            obj.group_debit= (obj.children.reduce((a, v) => a += v.group_debit, 0)+obj?.group_debit||0),
            obj.group_credit= (obj.children.reduce((b, v) => b += v.group_credit, 0)+obj?.group_credit||0) //then we calculate the sum of those total
            }
        })
    }
    function  getTreeView(arr,children_sum,depth = 0 ,chart_id=0){
        let  total_debit=0, total_credit=0;

            var eol = '<?php echo str_replace(array("\n","\r"),array('\\n','\\r'),PHP_EOL) ?>';
            html = '';
            let data_targer=" ";
            arr.forEach(function (v) {
                    a='&nbsp;&nbsp;&nbsp;&nbsp;';
                    h=  a.repeat(depth);
                    if(v.under!=0){
                        if(chart_id!=v.group_chart_id){
                            html+="<tr class='left left-data editIcon table-row-tree "+v.group_chart_id+"' data-node-id='"+v.group_chart_id+"' data-node-pid='"+v.under+"'>";
                                html+="<td  style='width: 1%;  border: 1px solid #ddd;'></td>";
                                html+="<td style='width: 3%;  border: 1px solid #ddd; font-size: 16px; color: #0B55C4'><span>" + h + a + v.group_chart_name + '</span></td>';
                                children_sum.forEach(function (c) {
                                    if(v.group_chart_id==c.group_chart_id) {
                                    html+="<td style='width: 3%;  border: 1px solid #ddd; font-size: 16px; color: #0B55C4'>"+(((c.group_debit?c.group_debit:0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))+"</td>";
                                    html+="<td style='width: 3%;  border: 1px solid #ddd; font-size: 16px; color: #0B55C4'>"+(((c.group_credit?c.group_credit:0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))+"</td>";
                                    return false;
                                    }
                                });
                                html+="</tr>";
                            chart_id=v.group_chart_id;
                        }
                        if(v.ledger_name!=null){
                            html+=`<tr id="${v.ledger_head_id}"  data-node-id="" data-node-pid="${v.group_chart_id}" class="left left-data editIcon table-row"  data-toggle="modal" data-target="#EditLedgerModel">
                                    <td class="sl" style="width: 1%;  border: 1px solid #ddd;"></td>
                                    <td   style="width: 5%;  border: 1px solid #ddd;font-size: 16px;"><span>${h+h+a+v.ledger_name}<span></td>
                                    <td   class="debit_data" style="width: 3%;  border: 1px solid #ddd; font-size: 18px">${(v.op_total_debit?(v.op_total_debit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')):0.00)}</td>
                                    <td    class="credit_data"  style="width: 3%;  border: 1px solid #ddd; font-size: 18px">${(v.op_total_credit?(v.op_total_credit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')):0.00)}</td>
                                </tr>`;
                        }

                    }
                    if ('children' in v){
                    html += getTreeView(v.children,children_sum,depth + 1,chart_id);
                    }
            });

                return html;
    }
     //get  all data show
$(document).ready(function () {
    $('.sd').on('click','.table-row',function(e){
        e.preventDefault();
        let   id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        url = "{{route('ledger-cash-flow-id-wise', ['id' =>':id', 'form_date' =>':form_date','to_date' =>':to_date'])}}";
        url = url.replace(':id',id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        window.location=url;
     })
});
</script>
@endpush
@endsection
