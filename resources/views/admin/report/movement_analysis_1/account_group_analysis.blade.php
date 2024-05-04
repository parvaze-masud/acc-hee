
@extends('layouts.backend.app')
@section('title','Accounts Group Analysis')
@push('css')
 <!-- model style -->
 <link rel="stylesheet" type="text/css" href="{{asset('libraries/assets/modal-style.css')}}">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
 .table-scroll thead tr:nth-child(2) th {
    top: 30px;
}
.th{
    border: 1px solid #ddd;font-weight: bold;
}
.td1{
    border: 1px solid #ddd; font-size: 16px;
}
.td2{
    border: 1px solid #ddd;font-size: 16px;
}
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Accounts Group Analysis',
    'print_layout'=>'landscape',
    'print_header'=>'Accounts Group Analysis',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="add_group_analysis"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-4">
                <label>Group Name :</label>
                <select name="group_id" class="form-control  js-example-basic-single  group_id" required>
                    <option value="">--Select--</option>
                    {!!html_entity_decode($group_chart_data)!!}
                </select>
            </div>
            <div class="col-md-4">
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
                <label></label><br>
                <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
            </div>
           </div>
        </div>
    </form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_report">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers table-scroll">
        <thead>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 1%; text-align:center;"class="th">SL.</th>
                    <th rowspan="2" style="width: 5%; table-layout: fixed;"class="th">Particulars</th>
                    <th colspan="3" style=" width: 5%; text-align:center;"class="th">Purchase</th>
                    <th colspan="3" style=" width: 5%; text-align:center;"class="th">Sales</th>
                </tr>
                <tr>
                    <th style="width: 2%;  overflow: hidden;" class="th">Quantity</th>
                    <th style="width: 2%;  overflow: hidden;" class="th">Rate</th>
                    <th style="width: 2%;  overflow: hidden;" class="th">Value</th>
                    <th style="width: 2%;  overflow: hidden;" class="th">Quantity</th>
                    <th style="width: 2%;  overflow: hidden;" class="th">Rate</th>
                    <th style="width: 2%;  overflow: hidden;" class="th">Value</th>
                </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;" class="th"></th>
                <th style="width: 3%;"class="th">Total :</th>
                <th style="width: 3%; font-size: 18px;"  class="total_purchase_qty th"></th>
                <th style="width: 2%; font-size: 18px;"  class="total_purchase_rate th"></th>
                <th style="width: 3%; font-size: 18px;"  class="total_purchase_value th"></th>
                <th style="width: 2%; font-size: 18px;"  class="total_sales_qty th"></th>
                <th style="width: 3%; font-size: 18px;"  class="total_sales_rate th"></th>
                <th style="width: 2%; font-size: 18px;"  class="total_sales_value th"></th>

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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
let i=1;
var amount_decimals="{{company()->amount_decimals}}";
let  total_sales_qty=0;total_sales_value=0; total_purchase_qty=0;total_purchase_value=0;

// group  analysis
$(document).ready(function () {
 $("#add_group_analysis").submit(function(e) {
    total_sales_qty=0;total_sales_value=0; total_purchase_qty=0;total_purchase_value=0,i=1;
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{route("account-group-analysis-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  account_group_analysis(response)
                },
                error : function(data,status,xhr){

                }
        });
});

// stock group analysis function
function account_group_analysis(response){
    const children_sum= calculateSumOfChildren(response.data);
    var tree=getTreeView(response.data,children_sum);
       $('.item_body').html(tree);
        get_hover();
        $('.total_purchase_qty').text(total_purchase_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_purchase_rate').text((((total_purchase_value||0)/(total_purchase_qty||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_purchase_value').text(total_purchase_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_sales_qty').text(total_sales_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_sales_rate').text((((total_sales_value||0)/(total_sales_qty||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_sales_value').text(total_sales_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

     }
});

// calcucation child summation
function calculateSumOfChildren(arr) {
    const result = {};

    function sumProperties(obj, prop) {
        return obj.reduce((acc, val) => acc + (val[prop] || 0), 0);
    }

    function processNode(node) {
        if (!result[node.stock_group_id]) {
            result[node.stock_group_id] = {
                stock_group_id: node.stock_group_id,
                stock_qty_sales: 0,
                stock_qty_purchase: 0,
                stock_total_sales: 0,
                stock_total_purchase: 0

            };
        }
        const currentNode = result[node.stock_group_id];
        currentNode.stock_qty_sales += node.stock_qty_sales || 0;
        currentNode.stock_qty_purchase += node.stock_qty_purchase || 0;
        currentNode.stock_total_sales += node.stock_total_sales || 0;
        currentNode.stock_total_purchase+= node.stock_total_purchase || 0;
        if (node.children) {
            node.children.forEach(processNode);
        }
    }

    arr.forEach(processNode);

    return Object.values(result);
}

function getTreeView(arr, children_sum, depth = 0, chart_id = 0) {
    let html = [];
    arr.forEach(function (v) {
        a = '&nbsp;&nbsp;';
        h = a.repeat(depth);

        if (chart_id != v.stock_group_id) {
            html.push(`<tr id="${v.stock_group_id+'-'+v.under}" class="left left-data table-row_tree">
                       <td style='width: 1%;  border: 1px solid #ddd;'></td>
                      <td style='width: 3%;color: #0B55C4' class="td1"><p style="margin-left:${(h+a+a).length}px;" class="text-wrap mb-0 pb-0 ">${v.stock_group_name}</p></td>`);

            let matchingChild = children_sum.find(c => v.stock_group_id == c.stock_group_id);
            if (matchingChild) {
                html.push(`<td style='width: 3%;color: #0B55C4'class="td1">${(Math.abs(matchingChild.stock_qty_purchase||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           <td style='width: 3%;color: #0B55C4'class="td1">${((Math.abs(matchingChild.stock_total_purchase||0)/Math.abs(matchingChild.stock_qty_purchase||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           <td style='width: 3%;color: #0B55C4'class="td1">${((Math.abs(matchingChild.stock_total_purchase||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                           <td style='width: 3%;color: #0B55C4'class="td1">${(matchingChild.stock_qty_sales||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           <td style='width: 3%;color: #0B55C4'class="td1">${(((matchingChild.stock_total_sales||0)/(matchingChild.stock_qty_sales||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                           <td style='width: 3%;color: #0B55C4'class="td1">${(matchingChild.stock_total_sales||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        </tr>`);

            }
            chart_id = v.stock_group_id;
        }

        if (v.stock_qty_sales_total != null || v.tock_qty_sales_return_total != null) {
            total_sales_qty+=(v.stock_qty_sales_total||0);
            total_sales_value+=(v.stock_total_sales_value||0);
            total_purchase_qty+=(v.stock_qty_purchase_total||0);
            total_purchase_value+=(v.stock_total_purchase_value||0);

            html.push(`<tr id="${v.stock_item_id}" class="left left-data editIcon table-row">
                        <td class="sl" style="width: 1%;  border: 1px solid #ddd;">${i++}</td>
                        <td style="width: 5%;" class="td2"><p style="margin-left:${(h+a+a+a).length}px" class="text-wrap mb-0 pb-0">${v.product_name}</p></td>
                        <td style='width: 3%;'class="td2">${((Math.abs(v.stock_qty_purchase_total||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                        <td style='width: 3%;'class="td2">${((Math.abs(v.stock_qty_purchase_total||0)/Math.abs(v.stock_qty_purchase_total||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td style='width: 3%;'class="td2">${((Math.abs(v.stock_qty_purchase_total||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                        <td style='width: 3%;'class="td2">${(((v.stock_qty_sales_total||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                        <td style='width: 3%;'class="td2">${(Math.abs((v.stock_total_sales_value||0)/(v.stock_qty_sales_total||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td style='width: 3%;'class="td2">${(((v.stock_total_sales_value||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                   </tr>`);
        }
        if ('children' in v) {
            html.push(getTreeView(v.children, children_sum, depth + 1, chart_id));
        }
    });
    return html.join("");
}

</script>
@endpush
@endsection
