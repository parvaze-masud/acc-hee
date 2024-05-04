
@extends('layouts.backend.app')
@section('title','Stock Group Summary')
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
 .th{
    border: 1px solid #ddd;font-weight: bold; text-align:center;
 }
 .td{
    border: 1px solid #ddd; font-size:  100%;font-weight: bold;
 }
 .table-scroll thead tr:nth-child(2) th {
    top: 30px;
}

table {width:100%;grid-template-columns: auto auto;}


/* table td {
word-wrap:break-word;
white-space: normal;
} */
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Stock Group Summary',
    'print_layout'=>'landscape',
    'print_header'=>'Stock Group Summary',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="stock_group_summary_form"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-3">
                <label>Stock Group :</label>
                <select name="stock_group_id" class="form-control  js-example-basic-single  stock_group_id" required>
                    <option value="">--Select--</option>
                    <option value="0">Primary</option>
                    {!!html_entity_decode($stock_group)!!}
                </select>
                <label>Godown Name :</label>
                <select name="godown_id" class="form-control  js-example-basic-single godown_id" required>
                    <option value="0">All</option>
                    @foreach($godowns as $godown)
                    <option value="{{$godown->godown_id}}">{{$godown->godown_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-4">
                <label></label>
                <div class="form-group mb-0" style="position: relative">
                    <label class="fs-6">Opening Blance :</label>
                    <input class="form-check-input op_qty" type="checkbox"  name="op_qty"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Quantity
                    </label>
                    <input class="form-check-input op_rate " type="checkbox"    name="op_rate"   value="1"  >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Rate
                    </label>
                    <input class="form-check-input op_value" type="checkbox"    name="op_value"   value="1" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Value
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <label class="fs-6">Inwards Blance :</label>
                    <input class="form-check-input in_qty" type="checkbox"  name="in_qty"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Quantity
                    </label>
                    <input class="form-check-input in_rate" type="checkbox"    name="in_rate"   value="1"  >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Rate
                    </label>
                    <input class="form-check-input in_value" type="checkbox"    name="in_value"   value="1" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Value
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <label class="fs-6">Outwards Blance :</label>
                    <input class="form-check-input out_qty" type="checkbox"  name="out_qty"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Quantity
                    </label>
                    <input class="form-check-input out_rate" type="checkbox"    name="out_rate"   value="2"  >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Rate
                    </label>
                    <input class="form-check-input out_value" type="checkbox"    name="out_value"   value="3" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Value
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position:relative">
                <label class="fs-6">Closing Blance :</label>
                <input class="form-check-input clo_qty" type="checkbox"  name="clo_qty"  value="1" checked="checked" >
                <label class="form-check-label fs-6" for="flexRadioDefault1" >
                    Quantity
                </label>
                <input class="form-check-input clo_rate " type="checkbox"    name=" clo_rate"   value="1"  >
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Rate
                </label>
                <input class="form-check-input clo_value" type="checkbox"    name="clo_value"   value="1" >
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                Value
                </label>
           </div>

            </div>
            <div class="col-md-2">
                <label></label><br>
                <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
            </div>
        </div>
    </form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_stock_group_summary">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers table-scroll">
        <thead>
            <tr>
                <th rowspan="2" class="th" style="width: 1%;">SL.</th>
                <th rowspan="2" class="th" style="width: 5%;table-layout: fixed;" >Particulars</th>
                <th colspan="3" class="th" style=" width: 5%;">Opening Balance</th>
                <th colspan="3" class="th" style=" width: 5%;">Inward Balance</th>
                <th colspan="3" class="th" style=" width: 5%; ">Outward Balance</th>
                <th colspan="3" class="th" style=" width: 5%;">Closing Balance</th>

            </tr>
            <tr>
                <th class="th" style="width: 2%;  overflow: hidden;">Quantity</th>
                <th class="th" style="width: 2%;  overflow: hidden;">Rate</th>
                <th class="th" style="width: 5%;  overflow: hidden;">Value</th>
                <th class="th" style="width: 3%;  overflow: hidden;">Quantity</th>
                <th class="th" style="width: 3%;  overflow: hidden;">Rate</th>
                <th class="th" style="width: 5%;  overflow: hidden;">Value</th>
                <th class="th" style="width: 2%;  overflow: hidden;">Quantity</th>
                <th class="th" style="width: 2%;  overflow: hidden;">Rate</th>
                <th class="th" style="width: 5%;  overflow: hidden;">Value</th>
                <th class="th" style="width: 3%;  overflow: hidden;">Quantity</th>
                <th class="th"style="width: 3%;  overflow: hidden;">Rate</th>
                <th class="th" style="width: 5%; overflow: hidden;">Value</th>

            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th  style="width: 1%;"class="td_th"></th>
                <th  style="width: 5%;"class="td_th">Total :</th>
                <th  style="width: 2%; font-size: 18px;" class="th total_opening_qty"></th>
                <th  style="width: 2%; font-size: 18px;" class="th total_opening_rate"></th>
                <th  style="width: 5%; font-size: 18px;" class="th total_opening_value"></th>
                <th  style="width: 2%; font-size: 18px;" class="th total_inwards_qty"></th>
                <th  style="width: 2%; font-size: 18px;" class="th total_inwards_rate"></th>
                <th  style="width: 5%; font-size: 18px;" class="th total_inwards_value"></th>
                <th  style="width: 2%; font-size: 18px;" class="th total_outwards_qty"></th>
                <th  style="width: 3%; font-size: 18px;" class="th total_outwards_rate"></th>
                <th  style="width: 5%; font-size: 18px;" class="th total_outwards_value"></th>
                <th  style="width: 3%; font-size: 18px;" class="th total_clasing_qty"></th>
                <th style="width: 2%;  font-size: 18px;"  class="th total_clasing_rate"></th>
                <th  style="width: 5%; font-size: 18px;" class="th total_clasing_value"></th>
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
let  total_opening_qty=0;total_opening_value=0; total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0; total_outwards_value=0;total_clasing_qty=0;total_clasing_value=0; i=1;
var amount_decimals="{{company()->amount_decimals}}";

// stock group summary
$(document).ready(function () {
 $("#stock_group_summary_form").submit(function(e) {
    total_opening_qty=0;total_opening_value=0; total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0; total_outwards_value=0;total_clasing_qty=0;total_clasing_value=0; i=1;
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("report-stock-group-summary-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  get_stock_group_summary(response)
                },
                error : function(data,status,xhr){

                }
        });
});

// stock group summary  function
function get_stock_group_summary(response){
    const children_sum= calculateSumOfChildren(response.data);
    var tree=getTreeView(response.data,children_sum);
       $('.item_body').html(tree);
        get_hover();
        $('.total_opening_qty').text((total_opening_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_opening_rate').text((((Math.abs(total_opening_value)/Math.abs(total_opening_qty))||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_opening_value').text((total_opening_value||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_inwards_qty').text(total_inwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_inwards_rate').text(((Math.abs(total_inwards_value)/Math.abs(total_inwards_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_inwards_value').text(total_inwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_qty').text(total_outwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_rate').text(((Math.abs(total_outwards_value)/Math.abs(total_outwards_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_value').text(total_outwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing_qty').text(total_clasing_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing_rate').text(((Math.abs(total_clasing_value)/Math.abs(total_clasing_qty))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_clasing_value').text(total_clasing_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
     }
});

// calcucation children summation
function calculateSumOfChildren(arr) {
    const result = {};

    function sumProperties(obj, prop) {
        return obj.reduce((acc, val) => acc + (val[prop] || 0), 0);
    }

    function processNode(node) {
        if (!result[node.stock_group_id]) {
            result[node.stock_group_id] = {
                stock_group_id: node.stock_group_id,
                stock_qty_in: 0,
                stock_qty_out: 0,
                stock_qty_in_opening: 0,
                stock_qty_out_opening: 0,
                stock_total_sum_in: 0,
                stock_total_sum_out: 0,
                stock_total_value_sum_opening: 0,
                sum_current_value: 0
            };
        }

        const currentNode = result[node.stock_group_id];

        currentNode.stock_qty_in += node.stock_qty_in || 0;
        currentNode.stock_qty_out += node.stock_qty_out || 0;
        currentNode.stock_qty_in_opening += node.stock_qty_in_opening || 0;
        currentNode.stock_qty_out_opening += node.stock_qty_out_opening || 0;
        currentNode.stock_total_sum_in += node.stock_total_sum_in || 0;
        currentNode.stock_total_sum_out += node.stock_total_sum_out || 0;
        currentNode.stock_total_value_sum_opening += node.stock_total_value_sum_opening || 0;
        currentNode.sum_current_value += node.sum_current_value || 0;

        if (node.children) {
            node.children.forEach(processNode);
        }
    }

    arr.forEach(processNode);

    return Object.values(result);
}


// recursive function tree
function getTreeView(arr, children_sum, depth = 0, chart_id = 0) {
    const fragment = document.createDocumentFragment();

    arr.forEach((v) => {
        const a = '&nbsp;&nbsp;';
        const h = a.repeat(depth);

        if (chart_id !== v.stock_group_id) {
            const row = document.createElement('tr');
            row.className = 'left left-data editIcon';
            row.innerHTML = `
                <td style='width: 1%;  border: 1px solid #ddd;'></td>
                <td style='width: 3%; border: 1px solid #ddd; font-size: 16px; color: #0B55C4;'><p style="margin-left:${(h + a + a).length}px;" class="text-wrap mb-0 pb-0 ">${v.stock_group_name}</p></td>
            `;
            let matchingChild = children_sum.find(c => v.stock_group_id == c.stock_group_id);
            if (matchingChild) {
                   let stock_op_qty=(matchingChild.stock_qty_in_opening ||0)-(matchingChild.stock_qty_out_opening ||0);
                   let opening_rate_cal_group=dividevalue(matchingChild.stock_total_value_sum_opening,stock_op_qty);
                    row.innerHTML += `
                        <td class="td" style='width: 3%;'>${(stock_op_qty).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${(opening_rate_cal_group||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 5%;'>${(matchingChild.stock_total_value_sum_opening||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${((matchingChild.stock_qty_in || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${(((matchingChild.stock_total_sum_in || 0) / (matchingChild.stock_qty_in || 0)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 5%;'>${((matchingChild.stock_total_sum_in || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${((matchingChild.stock_qty_out || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${(((matchingChild.stock_total_sum_out || 0) / (matchingChild.stock_qty_out || 0)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 5%;'>${((matchingChild.stock_total_sum_out || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${(((matchingChild.stock_qty_in_opening || 0) - (matchingChild.stock_qty_out_opening || 0) + (matchingChild.stock_qty_in || 0)) - (matchingChild.stock_qty_out || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 3%;'>${((matchingChild.sum_current_value || 0) / Math.abs(((matchingChild.stock_qty_in_opening || 0) - (matchingChild.stock_qty_out_opening || 0) + (matchingChild.stock_qty_in || 0)) - (matchingChild.stock_qty_out || 0)) || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                        <td class="td" style='width: 5%;'>${((matchingChild.sum_current_value || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    `;

                }
            fragment.appendChild(row);
            chart_id = v.stock_group_id;
        }

        if ((v.stock_total_in_opening == null) && (v.stock_out_sum_qty_op == null) && (v.stock_in_sum_qty == null) && (v.stock_out_sum_qty == null)) { }
        else {
                let  opening_qty=((v.stock_in_sum_qty_op || 0) - (v.stock_out_sum_qty_op || 0));
                total_opening_qty +=opening_qty;
                total_inwards_qty += (v.stock_in_sum_qty || 0);
                total_inwards_value += (v.stock_total_in || 0);
                total_outwards_qty += (v.stock_out_sum_qty || 0);
                total_outwards_value += (v.stock_total_out || 0);
                total_clasing_qty += (((v.stock_in_sum_qty_op || 0) - (v.stock_out_sum_qty_op || 0) + (v.stock_in_sum_qty || 0)) - (v.stock_out_sum_qty || 0));
                total_clasing_value += ((((v.stock_in_sum_qty_op || 0) - (v.stock_out_sum_qty_op || 0) + (v.stock_in_sum_qty || 0)) - (v.stock_out_sum_qty || 0)) * (v.current_rate || 0));
                let opening_qty_sum= ((v.stock_in_sum_qty_op || 0)+(v.stock_out_sum_qty_op || 0));
                let opening_value= ((v.stock_total_in_opening || 0) +(v.stock_total_out_opening || 0))
                let opening_rate_cal=dividevalue(opening_value,opening_qty_sum);
                total_opening_value +=(opening_qty*opening_rate_cal);
                const row = document.createElement('tr');
                row.id = v.stock_item_id;
                row.className = 'left left-data table-row';
                row.setAttribute('data-target', '#EditLedgerModel');
                row.innerHTML = `
                    <td class="sl" style="width: 1%;  border: 1px solid #ddd;">${i++}</td>
                    <td style="width: 5%;  border: 1px solid #ddd;font-size: 12px;"><p style="margin-left:${(h + a + a + a).length}px" class="text-wrap mb-0 pb-0">${v.product_name}</p></td>
                    <td class="td" style='width: 3%;'>${(opening_qty||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 3%;'>${(opening_rate_cal).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 5%;'>${(opening_qty*opening_rate_cal).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 3%;'>${((v.stock_in_sum_qty ||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" class="td" style='width: 3%;'>${(((v.stock_total_in||0)/(v.stock_in_sum_qty||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 5%;'>${((v.stock_total_in||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 3%;'>${(((v.stock_out_sum_qty||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                    <td class="td" style='width: 3%;'>${(((v.stock_total_out||0)/(v.stock_out_sum_qty||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 5%;'>${(v.stock_total_out||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                    <td class="td" style='width: 3%;'>${((((v.stock_in_sum_qty_op || 0) - (v.stock_out_sum_qty_op || 0) + (v.stock_in_sum_qty || 0)) - (v.stock_out_sum_qty || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                    <td class="td" style='width: 3%;'>${((v.current_rate || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                    <td class="td" style='width: 5%;'>${(((((v.stock_in_sum_qty_op || 0) - (v.stock_out_sum_qty_op || 0) + (v.stock_in_sum_qty || 0)) - (v.stock_out_sum_qty || 0)) * (v.current_rate || 0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>
                `;
            fragment.appendChild(row);
        }
        if ('children' in v) {
            fragment.appendChild(getTreeView(v.children, children_sum, depth + 1, chart_id));
        }
    });

    return fragment;
}

$(document).ready(function(){
    // table header fixed
    let display_height=$(window).height();
    $('.tableFixHead_stock_group_summary').css('height',`${display_height-300}px`);
});

//get  all data show
$(document).ready(function () {
    // stock item month wise summary route
    $('.sd').on('click','.table-row',function(e){
        e.preventDefault();
        let id=$(this).closest('tr').attr('id');
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        let godown_id=$('.godown_id').val();
        url = "{{route('stock-item-monthly-summary-id-wise', ['id' =>':id', 'form_date' =>':form_date','to_date' =>':to_date','godown_id'=>':godown_id'])}}";
        url = url.replace(':id',id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        url = url.replace(':godown_id',godown_id);
        window.location=url;
    });

    $('.sd').on('click','.table-row_tree',function(e){
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
