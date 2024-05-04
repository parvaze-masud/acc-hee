
@extends('layouts.backend.app')
@section('title','Cash Flow Summary')
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
 .tree-node {
      display: none;
}
.tree-node.show {
    display: table-row;
}
.th{
    border: 1px solid #ddd;font-weight: bold;
}
.td{
    border: 1px solid #ddd; font-size: 16px;
}
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Cash Flow Summary',
    'print_layout'=>'landscape',
    'print_header'=>'Cash Flow Summary',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="cash_flow_form"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-4 ">
                <div class="row  m-0 p-0">
                    <div class="col-md-6 m-0 p-0">
                        <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{company()->financial_year_start }}">
                    </div>
                    <div class="col-md-6 m-0 p-0">
                        <label>Date To : </label>
                        <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{ date('Y-m-d') }}">
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
<div class="dt-responsive table-responsive cell-border sd tableFixHead">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers ">
        <thead>
            <tr>
                <th style="width: 1%;" class="th">SL.</th>
                <th style="width: 3%;"class="th">Particulars</th>
                <th style="width: 2%;"class="th">Inflow</th>
                <th style="width: 3%;"class="th">Outflow</th>
            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;"class="th"></th>
                <th style="width: 3%;"class="th text-right">Total</th>
                <th style="width: 2%; font-size: 18px"class="th total_debit"></th>
                <th style="width: 3%;font-size: 18px"class="th total_credit"></th>
            </tr>
        </tfoot>
    </table>
    <div class="col-sm-12 text-center">
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
let  total_debit=0; total_credit=0;i=1;
$(document).ready(function () {

// get cash flow
function  get_cash_flow_initial_show(){
  $.ajax({
        url: "{{ url('cash-flow-summary-get-data')}}",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          get_cash_flow(response)
        }
    })
 }
 get_cash_flow_initial_show();

// get cash flow
 $("#cash_flow_form").submit(function(e) {
      total_debit=0; total_credit=0;i=1;
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("cash-flow-summary-get-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                   get_cash_flow(response)
                },
                error : function(data,status,xhr){

                }
        });
});

function get_cash_flow(response){
      const children_sum= calculateSumOfChildren(response.data);
       $('.item_body').html(getTreeView(response.data,children_sum));
       $('.total_debit').text(((total_debit||0)||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
       $('.total_credit').text((total_credit||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

     }
});

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
            };
        }

        const currentNode = result[node.group_chart_id];
        currentNode.group_debit += node.group_debit || 0;
        currentNode.group_credit += node.group_credit || 0;
        if (node.children) {
            node.children.forEach(processNode);
        }
    }
    arr.forEach(processNode);
    return Object.values(result);
}

    function getTreeView(arr, children_sum, depth = 0, chart_id = 0,group=1,under_id='') {
    let html = [];
    let under_unique=0;
    arr.forEach(function (v) {
        a = '&nbsp;&nbsp;&nbsp;&nbsp;';
        h = a.repeat(depth);
        if(v.under!=0){
            if (chart_id != v.group_chart_id) {
                        if(group==v.under){
                            if(under_unique!=v.under){
                                under_id+=' '+v.under
                                under_unique=v.under;
                            }
                        }
                    html.push(`<tr id="${v.group_chart_id}" class='${under_id} table-row  ${group==v.under?'tree-node':''} left left-data'   data-id='${v.group_chart_id}' data-parent='${v.under}'>
                                <td style='width: 1%;  border: 1px solid #ddd;'></td>
                                <td style='width: 3%;  border: 1px solid #ddd; font-size: 16px; color: #0B55C4'><span class="group_chart">${h+a +v.group_chart_name}</span>
                                            <span>
                                            ${v.ledger_head_id?'<i class="fa fa-plus fa-lg"  ></i>':v.children?'<i class="fa fa-plus fa-lg" aria-hidden="true"></i>':''}
                                                <i class="fa fa-minus fa-lg"  aria-hidden="true" style="display: none;"></i>
                                            </span>
                               </td>`);

                        let matchingChild = children_sum.find(c =>v.group_chart_id == c.group_chart_id);
                        if (matchingChild) {
                            html.push(`<td style='width: 3%; color: #0B55C4' class="td">${(matchingChild.group_debit || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                       <td style='width: 3%; color: #0B55C4' class="td">${((((matchingChild.group_credit||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                                </tr>`);
                        }
                    chart_id = v.group_chart_id;
            }
            if (v.op_total_debit != null || v.op_total_credit != null) {
                        total_debit += (v.op_total_debit || 0);
                        total_credit += (v.op_total_credit|| 0);
                html.push(`<tr id="${v.ledger_head_id}" class="${under_id} ledger_id table-row tree-node " data-id_data-parent="${v.under}" data-parent="${v.group_chart_id}">
                               <td class="sl" style="width: 1%;  border: 1px solid #ddd;">${i++}</td>
                               <td style="width: 5%; " class="td">${h+a+a+v.ledger_name}</td>
                               <td style='width: 3%;'class='td opening'>${(v.op_total_debit || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                              <td style='width: 3%; 'class='td inwards'>${((v.op_total_credit||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                          </tr>`);
            }
        }
            if ('children' in v) {
                let arr_gruop_id=[1,2,3,4,5,6];
                let group_id=(arr_gruop_id.includes(v.group_chart_id)?0:v.group_chart_id)
                html.push(getTreeView(v.children, children_sum, depth + 1, chart_id,group_id,under_id));
            }
        });

    return html.join("");
}


//get  all data show
$(document).ready(function () {

    // group cash flow
    $('.sd').on('click','.group_chart',function(e){
        e.preventDefault();
        let   id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        url = "{{route('group-cash-flow-id-wise', ['id' =>':id', 'form_date' =>':form_date','to_date' =>':to_date'])}}";
        url = url.replace(':id',id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        window.location=url;
    });
    $('.sd').on('click','.ledger_id',function(e){
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
<script>
    // table expand collapse rows
     document.addEventListener('DOMContentLoaded', function() {
       const dataTable = document.getElementById('tableId');

       dataTable.addEventListener('click', function(e) {
         const target = e.target;

         const tr = target.closest('tr');

         $(tr).find('i:eq(1)').toggle('show');
         $(tr).find('i:eq(0)').toggle('show');

         if (tr) {
             const nodeId = tr.dataset.id;
             const childNodes = document.querySelectorAll(`tr[data-parent="${nodeId}"]`);
             let key=0;
             childNodes.forEach(node => {
                 node.classList.toggle('show');
             });
             const childNodes1 = document.getElementsByClassName(`${nodeId}`);
             [...childNodes1]?.forEach(node => {
                 if(node.classList.contains('show')){
                     let parent=node.getAttribute("data-parent");
                     if(key!=parent && parent!=nodeId){
                         const childNodes1 = document.querySelector(`tr[data-id="${parent}"]`).click();
                         key=parent;
                     }
                 }
             });
         }
       });
     });
   </script>
@endpush
@endsection
