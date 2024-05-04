
@extends('layouts.backend.app')
@section('title','Stock Group Analysis')
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
    .table-scroll thead tr:nth-child(2) th {
        top: 30px;
    }
    .th{
        border: 1px solid #ddd;font-weight: bold !important;
    }
    .td{
        border: 1px solid #ddd; font-size: 16px  !important;
    }
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Stock Group Analysis ',
    'print_layout'=>'landscape',
    'print_header'=>'Stock Group Analysis',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="stock_group_analysis"  method="POST">
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
                <div class="col-md-2">
                    <label></label><br>
                    <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style=" width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
                </div>
            </div>
            <div class="col-md-6">
                <label></label>
                <div class="form-group mb-0" style="position: relative">
                    <label class="fs-6">Eff. Rate :</label>
                    <input class="form-check-input op_qty" type="checkbox"  name="rate_in"  value="1" checked="checked" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Inward Column
                    </label>
                    <input class="form-check-input op_rate " type="checkbox"    name="rate_out"   value="1"  >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Outward Column
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <label class="fs-6">Inward Column :</label>
                    <input class="form-check-input purchase_in in_qty" type="checkbox"  name="in_qty[]"  {{ isset($purchase_in)?($purchase_in==10 ? ' checked' : ''):''  }}  value="10" {{$purchase_in?? "checked"}} >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Purchase
                    </label>
                    <input class="form-check-input grn_in in_qty" type="checkbox" {{ isset($grn_in)?($grn_in==24 ? 'checked' : ''):''  }}    name="in_qty[]"   value="24" {{$grn_in??"checked"}} >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        GRN
                    </label>
                    <input class="form-check-input purchase_return_in in_qty" type="checkbox"    name="in_qty[]"  {{ isset($purchase_return_in)?($purchase_return_in==29 ? ' checked' : ''):''  }}  value="29" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Purchase Return
                    </label>
                    <input class="form-check-input journal_in in_qty" type="checkbox"    name="in_qty[]"  {{ isset($journal_in)?($journal_in==6 ? ' checked' : ''):''  }} value="6" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Journal
                    </label>
                    <input class="form-check-input stock_journal_in in_qty" type="checkbox"    name="in_qty[]" {{ isset($stock_journal_in)?($stock_journal_in==21 ? ' checked' : ''):''  }}  value="21" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Stock Journal
                    </label>
               </div>
               <div class="form-group m-0 p-0" style="position: relative">
                    <label class="fs-6">Outward Column :</label>
                    <input class="form-check-input sales_return_out out_qty" type="checkbox" {{ isset($sales_return_out)?($sales_return_out==25 ? ' checked' : ''):''  }} name="out_qty[]"  value="25" {{$sales_return_out?? "checked"}} >
                    <label class="form-check-label fs-6" for="flexRadioDefault1" >
                        Sales Return
                    </label>
                    <input class="form-check-input gtn_out out_qty" type="checkbox"    name="out_qty[]"   {{ isset($gtn_out)?($gtn_out==23 ? ' checked' : ''):''  }}  value="23"  {{$gtn_out?? "checked"}}>
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        GTN
                    </label>
                    <input class="form-check-input sales_out out_qty" type="checkbox"    name="out_qty[]" {{ isset($sales_out)?($sales_out==19 ? ' checked' : ''):''  }}  value="19" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Sales
                    </label>
                    <input class="form-check-input journal_out out_qty" type="checkbox"    name="out_qty[]" {{ isset($journal_out)?($journal_out==6 ? ' checked' : ''):''  }}   value="6" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Journal
                    </label>
                    <input class="form-check-input stock_journal_out out_qty" type="checkbox"    name="out_qty[]" {{ isset($stock_journal_out)?($stock_journal_out==12 ? ' checked' : ''):''  }}  value="21" >
                    <label class="form-check-label fs-6" for="flexRadioDefault1">
                        Stock Journal
                    </label>
               </div>
           </div>
        </div>
    </form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_stock_group_analysis">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers table-scroll">
        <thead>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 1%; text-align:center;" class="th">SL.</th>
                    <th rowspan="2" style="width: 5%; text-align:center;table-layout: fixed;"class="th" >Particulars</th>
                    <th colspan="3" style=" width: 5%; text-align:center;" class="th">Inward : Purchase, GRN, Sales Return, Journal & Stock Journal	</th>
                    <th colspan="3" style=" width: 5%; text-align:center;" class="th">Outward : Purchase Return, GTN, Sales, Journal & Stock Journal</th>
                </tr>
                <tr>
                    <th style="width: 2%; overflow: hidden;" class="th">Quantity</th>
                    <th style="width: 2%; overflow: hidden;" class="th">Rate</th>
                    <th style="width: 2%; overflow: hidden;" class="th">Value</th>
                    <th style="width: 5%; overflow: hidden;" class="th" >Quantity</th>
                    <th style="width: 2%; overflow: hidden;" class="th">Rate</th>
                    <th style="width: 3%; overflow: hidden;" class="th">Value</th>
                </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;" class="th"></th>
                <th style="width: 3%;" class="th">Total :</th>
                <th style="width: 2%; font-size: 18px;"  class="th total_inwards_qty"></th>
                <th style="width: 3%; font-size: 18px;"  class="th total_inwards_rate"></th>
                <th style="width: 2%; font-size: 18px;"  class="th total_outwards_value"></th>
                <th style="width: 3%; font-size: 18px;"  class="th total_outwards_qty"></th>
                <th style="width: 2%; font-size: 18px;"  class="th total_outwards_rate"></th>
                <th style="width: 3%; font-size: 18px;"  class="th total_outwards_value"></th>
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
$(document).ready(function(){
    // table header fixed
    let display_height=$(window).height();
    $('.tableFixHead_stock_group_analysis').css('height',`${display_height-300}px`);
});

var amount_decimals="{{company()->amount_decimals}}";
let  total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0;total_outwards_value=0;
// group chart  id check
if({{$godown_id??0}}!=0){
     $('.godown_id').val('{{$godown_id??0}}');
}

if({{$stock_group_id??0}}!=0){
     $('.stock_group_id').val('{{$stock_group_id??0}}');
}

// stock group analysis
$(document).ready(function () {

    // stock group analysis function
    function get_stock_group_analysis_initial_show(){
            // stock in array check
        let in_qty=[];
        $('.in_qty').each(function(){
        in_qty.push($(this).is(':checked')?$(this).val():0);
        });
        // stock out array check
        let out_qty=[];
        $('.out_qty').each(function(){
        out_qty.push($(this).is(':checked')?$(this).val():0);
        })

        $.ajax({
            url: '{{ route("stock-group-analysis-data") }}',
                method: 'GET',
                data: {
                    to_date:$('.to_date').val(),
                    from_date:$('.from_date').val(),
                    stock_group_id:$(".stock_group_id").val(),
                    godown_id:$(".godown_id").val(),
                    in_qty:in_qty,
                    out_qty:out_qty
                },
                dataType: 'json',
                success: function(response) {
                    get_stock_group_analysis(response)
                },
                error : function(data,status,xhr){
                }
        });
   }

    // stock  group get id check
    if({{$stock_group_id??0}}!=0){
         get_stock_group_analysis_initial_show();
    }
    $("#stock_group_analysis").submit(function(e) {
        total_inwards_qty=0;total_inwards_value=0; total_outwards_qty=0;total_outwards_value=0;
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route("stock-group-analysis-data") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                    result=[];
                    get_stock_group_analysis(response)
                    },
                    error : function(data,status,xhr){

                    }
            });
    });

// stock group analysis function
function get_stock_group_analysis(response){
    const children_sum= calculateSumOfChildren(response.data);
    var tree=getTreeView(response.data,children_sum);
       $('.item_body').html(tree);
        get_hover();
        $('.total_inwards_qty').text(total_inwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_inwards_rate').text((((total_inwards_value||0)/(total_inwards_qty||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_value').text(total_inwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_qty').text(total_outwards_qty.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_rate').text((((total_outwards_value||0)/(total_outwards_qty||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_outwards_value').text(total_outwards_value.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
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
        if (!result[node.stock_group_id]) {
            result[node.stock_group_id] = {
                stock_group_id: node.stock_group_id,
                stock_qty_in: 0,
                stock_qty_out: 0,
                stock_total_in: 0,
                stock_total_out: 0
            };
        }

        const currentNode = result[node.stock_group_id];
        currentNode.stock_qty_in += node.stock_qty_in || 0;
        currentNode.stock_qty_out += node.stock_qty_out || 0;
        currentNode.stock_total_in += node.stock_total_in || 0;
        currentNode.stock_total_out+= node.stock_total_out || 0;
        if (node.children) {
            node.children.forEach(processNode);
        }
    }

    arr.forEach(processNode);

    return Object.values(result);
}
let i=1;
function getTreeView(arr, children_sum, depth = 0, chart_id = 0) {
    let html = [];
    arr.forEach(function (v) {
        a = '&nbsp;&nbsp;';
        h = a.repeat(depth);

        if (chart_id != v.stock_group_id) {
            html.push(`<tr id="${v.stock_group_id+'-'+v.under}" class="left left-data table-row_tree">`);
            html.push(`<td style='width: 1%;'class="td"></td>`);
            html.push(`<td style='width: 3%; color: #0B55C4' class="td"><p style="margin-left:${(h+a+a).length}px;" class="text-wrap mb-0 pb-0 ">${v.stock_group_name}</p></td>`);

            let matchingChild = children_sum.find(c => v.stock_group_id == c.stock_group_id);
            if (matchingChild) {
                html.push(`<td style='width: 3%; color: #0B55C4' class="td">${(matchingChild.stock_qty_in || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>`);
                html.push(`<td style='width: 3%; color: #0B55C4' class="td">${((((matchingChild.stock_total_in||0)/(matchingChild.stock_qty_in||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
                html.push(`<td style='width: 3%; color: #0B55C4' class="td">${(((matchingChild.stock_total_in||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
                html.push(`<td style='width: 3%; color: #0B55C4' class="td">${(((matchingChild.stock_qty_out||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
                html.push(`<td style='width: 3%; color: #0B55C4' class="td">${((((matchingChild.stock_total_out||0)/(matchingChild.stock_qty_out||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
                html.push(`<td style='width: 3%; color: #0B55C4' class="td">${(((matchingChild.stock_total_out||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
            }

            html.push(`</tr>`);
            chart_id = v.stock_group_id;
        }

        if (v.stock_qty_total_in != null || v.stock_qty_total_out != null) {
            total_inwards_qty += (v.stock_qty_total_in || 0);
            total_inwards_value += (v.stock_total_value_in || 0);
            total_outwards_qty += (v.stock_qty_total_out || 0);
            total_outwards_value += (v.stock_total_value_out || 0);

            html.push(`<tr id="${v.stock_item_id}" class="left left-data editIcon table-row">`);
            html.push(`<td class="sl td" style="width: 1%;">${i++}</td>`);
            html.push(`<td style="width: 5%;" class="td"><p style="margin-left:${(h+a+a+a).length}px" class="text-wrap mb-0 pb-0">${v.product_name}</p></td>`);
            html.push(`<td style='width: 3%;' class='td opening'>${(v.stock_qty_total_in || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>`);
            html.push(`<td style='width: 3%; 'class='td inwards'>${(((v.stock_total_value_in||0)/(v.stock_qty_total_in||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>`);
            html.push(`<td style='width: 3%; 'class='td outwards'>${(((v.stock_total_value_in||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
            html.push(`<td style='width: 3%; 'class='td clasing'>${(((v.stock_qty_total_out||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
            html.push(`<td style='width: 3%; 'class='td outwards'>${(((v.stock_total_value_out||0)/(v.stock_qty_total_out||0))||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>`);
            html.push(`<td style='width: 3%; 'class='td clasing'>${(((v.stock_total_value_out||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'))}</td>`);
            html.push(`</tr>`);
        }

        if ('children' in v) {
            html.push(getTreeView(v.children, children_sum, depth + 1, chart_id));
        }
    });

    return html.join("");
}

$(document).ready(function () {
   // group item analysis route
    $('.sd').on('click','.table-row',function(e){
        e.preventDefault();
        let  stock_item_id=$(this).closest('tr').attr('id');
        let godown_id=$('.godown_id').val();
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        let purchase_in=$('.purchase_in').is(':checked')?$('.purchase_in').val():0;
        let grn_in=$('.grn_in').is(':checked')?$('.grn_in').val():0;
        let purchase_return_in=$('.purchase_return_in').is(':checked')?$('.purchase_return_in').val():0;
        let journal_in=$('.journal_in').is(':checked')?$('.journal_in').val():0;
        let stock_journal_in=$('.stock_journal_in').is(':checked')?$('.stock_journal_in').val():0;
        let sales_return_out=$('.sales_return_out').is(':checked')?$('.sales_return_out').val():0;
        let gtn_out=$('.gtn_out').is(':checked')?$('.gtn_out').val():0;
        let sales_out=$('.sales_out').is(':checked')?$('.sales_out').val():0;
        let journal_out=$('.journal_out').is(':checked')?$('.journal_out').val():0;
        let stock_journal_out=$('.stock_journal_out').is(':checked')?$('.stock_journal_out').val():0;

        url = "{{route('stock-item-analysis-id-wise', ['stock_item_id' =>':stock_item_id','godown_id'=>':godown_id','form_date' =>':form_date','to_date' =>':to_date','purchase_in'=>':purchase_in','grn_in'=>':grn_in','purchase_return_in'=>':purchase_return_in','journal_in'=>':journal_in','stock_journal_in'=>':stock_journal_in','sales_return_out'=>':sales_return_out','gtn_out'=>':gtn_out','sales_out'=>':sales_out','journal_out'=>':journal_out','stock_journal_out'=>':stock_journal_out'])}}";

        url = url.replace(':stock_item_id',stock_item_id);
        url = url.replace(':godown_id',godown_id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        url=url.replace(':purchase_in',purchase_in);
        url = url.replace(':grn_in',grn_in);
        url = url.replace(':purchase_return_in',purchase_return_in);
        url = url.replace(':journal_in',journal_in);
        url = url.replace(':stock_journal_in',stock_journal_in);
        url=url.replace(':sales_return_out',sales_return_out);
        url=url.replace(':gtn_out',gtn_out);
        url = url.replace(':sales_out',sales_out);
        url = url.replace(':journal_out',journal_out);
        url=url.replace(':stock_journal_out',stock_journal_out);
        window.location=url;
    });

    // stock group analysis route
    $('.sd').on('click','.table-row_tree',function(e){
        e.preventDefault();
        let  stock_group_id=$(this).closest('tr').attr('id');
        let godown_id=$('.godown_id').val();
        let form_date=$('.from_date').val();
        let to_date=$('.to_date').val();
        let purchase_in=$('.purchase_in').is(':checked')?$('.purchase_in').val():0;
        let grn_in=$('.grn_in').is(':checked')?$('.grn_in').val():0;
        let purchase_return_in=$('.purchase_return_in').is(':checked')?$('.purchase_return_in').val():0;
        let journal_in=$('.journal_in').is(':checked')?$('.journal_in').val():0;
        let stock_journal_in=$('.stock_journal_in').is(':checked')?$('.stock_journal_in').val():0;
        let sales_return_out=$('.sales_return_out').is(':checked')?$('.sales_return_out').val():0;
        let gtn_out=$('.gtn_out').is(':checked')?$('.gtn_out').val():0;
        let sales_out=$('.sales_out').is(':checked')?$('.sales_out').val():0;
        let journal_out=$('.journal_out').is(':checked')?$('.journal_out').val():0;
        let stock_journal_out=$('.stock_journal_out').is(':checked')?$('.stock_journal_out').val():0;
        url = "{{route('stock-group-analysis-id-wise', ['stock_group_id' =>':stock_group_id','godown_id'=>':godown_id','form_date' =>':form_date','to_date' =>':to_date','purchase_in'=>':purchase_in','grn_in'=>':grn_in','purchase_return_in'=>':purchase_return_in','journal_in'=>':journal_in','stock_journal_in'=>':stock_journal_in','sales_return_out'=>':sales_return_out','gtn_out'=>':gtn_out','sales_out'=>':sales_out','journal_out'=>':journal_out','stock_journal_out'=>':stock_journal_out'])}}";
        url = url.replace(':stock_group_id',stock_group_id);
        url = url.replace(':godown_id',godown_id);
        url = url.replace(':form_date',form_date);
        url = url.replace(':to_date',to_date);
        url=url.replace(':purchase_in',purchase_in);
        url = url.replace(':grn_in',grn_in);
        url = url.replace(':purchase_return_in',purchase_return_in);
        url = url.replace(':journal_in',journal_in);
        url = url.replace(':stock_journal_in',stock_journal_in);
        url=url.replace(':sales_return_out',sales_return_out);
        url=url.replace(':gtn_out',gtn_out);
        url = url.replace(':sales_out',sales_out);
        url = url.replace(':journal_out',journal_out);
        url=url.replace(':stock_journal_out',stock_journal_out);
        window.location=url;
    })
});
</script>
@endpush
@endsection
