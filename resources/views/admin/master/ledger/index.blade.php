@extends('layouts.backend.app')
@section('title','Ledger')
@push('css')
<!-- model style -->
<link rel="stylesheet" type="text/css" href="{{asset('libraries/assets/modal-style.css')}}">
<style>
    .td{
        width: 3%;  border: 1px solid #ddd;
    }
</style>
@endpush
@section('admin_content')
<br>
<!-- setting component-->
@component('components.setting_modal', [
    'id' =>'exampleModal',
    'class' =>'modal fade',
    'page_title'=>'ledger_head',
    'page_unique_id'=>2,
    'title'=>'Accounts Ledger',
    'alias_true'=>'alias_true',
    'last_inset_true'=>'last_inset_true',
    'bangla_true'=>'bangla_true',
    'redirect_page_true'=>'redirect_page_true'
])
@endcomponent
<!-- add component-->
@component('components.index', [
    'title' => 'Accounts Ledger',
    'print' => 'Print',
    'add_route'=>route('ledger.create'),
    'plan_view'=>'Tree View',
    'tree_view'=>'Plain View',
    'print' => 'Print',
    'excel'=>'excel',
    'pdf'=>'pdf',
    'print_layout'=>'landscape',
    'print_header'=>'Accounts Ledger',
    'setting_model'=>'setting_model',
    'close_route'=>route('master-dashboard'),
    'user_privilege_status_type'=>'master',
    'user_privilege_title'=>'Ledger',
    'user_privilege_type'=>'create_role'
])
@slot('body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead">
    <table id="tableId" style=" border-collapse: collapse; " class="table table-striped customers ">
        <thead>
            <tr>
                <th class="td">SL</th>
                <th class="td">Ledger Name</th>
                <th class="td bangla_name d-none d-print-none">Bangla Ledger Name</th>
                <th class="td">Group Name</th>
                <th class="td">Nature of Group</th>
                <th class="td">Starting Balance</th>
                <th class="td alias d-none d-print-none">Alias</th>
                <th class="td created_user d-none d-print-none">Created By</th>
                <th class="td last_update d-none d-print-none">History</th>
            </tr>
        </thead>
        <tbody id="myTable" class="ledger_body">
        </tbody>
        <tfoot>
            <tr>
                <th class="td">SL</th>
                <th class="td">Ledger Name</th>
                <th class="td bangla_name d-none d-print-none">Bangla Ledger Name</th>
                <th class="td">Group Name</th>
                <th class="td">Nature of Group</th>
                <th class="td">Starting Balance</th>
                <th class="alias d-none d-print-none td">Alias</th>
                <th class="created_user d-none d-print-none td">Created By</th>
                <th class="last_update d-none d-print-none td ">History</th>
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
<script type="text/javascript" src="{{asset('libraries/assets/table-hover.js')}}"></script>

<script>
    let i=1;
$(function() {
    //all data tree show
    $('.plain_id').click(function() {
        i=1;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ url('ledger_view/tree_view')}}",
            success: function(response) {
                $('.ledger_body').html(getTreeView(response, depth = 0, 0));
                page_wise_setting_checkbox();
                set_scroll_table();
                get_hover();
            }
        })
        $(this).addClass('d-none');
        $('.tree_id').removeClass('d-none');

    });
    $('.tree_id').click(function() {
        $(this).addClass('d-none');
        $('.plain_id').removeClass('d-none');
        allDataShow();
    });
});
//plain all data show
function allDataShow() {
    $.ajax({
        url: "{{ url('ledger_view/plain_view')}}",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let html = [];
            let data_targer = " ";
            $.each(response.data, function(key, v) {
                if (v.under != 0) {
                    html.push( `<tr id=${v.ledger_head_id} class="left left-data  table-row"  data-toggle="modal" >
                                    <td class="sl td">${(key +  1)}</td>
                                    <td  class="td">${v.ledger_name}</td>
                                    <td  class="td bangla_name d-none d-print-none">${(v.bangla_ledger_name||'')}</td>
                                    <td  class="td" >${v.group_chart_name}</td>
                                    <td class="nature_val td">${v.o}</td>
                                    <td class="nature_val td">${(Math.abs(v.opening_balance)||'')}</td>
                                    <td class="alias d-none d-print-none td">${(v.alias|| '')}</td>
                                    <td class="created_user d-none d-print-none td">${(v.user_name||'')}</td>
                                    <td class="last_update d-none d-print-none td"><div><i class="history_font_size">${(v.other_details ? JSON.parse(v.other_details) : '')}</i></div></td>
                           </tr>`);
                }
            });
            $('.ledger_body').html(html.join(""));
            set_scroll_table();
            page_wise_setting_checkbox();
            get_hover();
        }
    })

}
// get Tree view table row
function getTreeView(arr, depth = 0, chart_id = 0) {
    let html = [];
    let data_targer = " ";
    arr.forEach(function(v) {
        a = '&nbsp;&nbsp;&nbsp;&nbsp;';
        h = a.repeat(depth);
        if (v.under != 0) {
            if (chart_id != v.group_chart_id) {
                html.push(`<tr style='pointer-events: none' class='left left-data editIcon table-row'>
                                <td class="td"></td>
                                <td class="td" style='color:#BBB;'>${h + a + v.group_chart_name}</td>
                                <td class='bangla_name d-none d-print-none td'></td>
                                <td class="td"></td>
                                <td class="td"'></td>
                                <td class="td"></td>

                                <td class='alias d-none d-print-none td'></td>
                                <td  class='created_user d-none d-print-none td'></td>
                                <td class='last_update d-none d-print-none td'></td></tr>`);
                chart_id = v.group_chart_id;
            }
            if (v.ledger_name != null) {
                html.push(`<tr id="${v.ledger_head_id }" class="left left-data editIcon table-row"  data-toggle="modal" data-target="#EditLedgerModel">
                                <td class="td">${i++}</td>
                                <td class="td">${h+h+a+v.ledger_name}</td>
                                <td class="bangla_name d-none d-print-none td">${(v.bangla_ledger_name||'')}</td>
                                <td class="td">
                                    <input type="hidden" class="form-control get_group_id" name="get_group_id" value="${v.group_chart_id}">${h+a+v.group_chart_name}
                                </td>
                                <td class="nature_val td" >${v.o||''}</td>
                                <td class="nature_val td"  >${Math.abs(v.opening_balance)||''}</td>
                                <td  class="alias d-none d-print-none td">${(v.alias||'')}</td>
                                <td  class="created_user d-none d-print-none td">${(v.user_name||'')}</td>
                                <td class=" last_update d-none d-print-none td"><div><i  class="history_font_size">${(v.other_details ? JSON.parse(v.other_details) : '')}</i></div></td>
                            </tr>`);
            }
        }
        if ('children' in v) {
            html.push(getTreeView(v.children, depth + 1, chart_id));
        }
    });
    return html.join("");
}


$(document).ready(function() {
    allDataShow();
});

function swal_message(data, message) {
    swal({
        title: 'Successfully',
        text: data,
        type: message,
        timer: '1500'
    });
}
$(document).ready(function() {
    $('.sd').on('click', '.customers tbody tr', function() {
        @if(user_privileges_check('master', 'Ledger', 'alter_role'))
        window.location = "{{ url('ledger') }}" + '/' + $(this).attr('id');
        @endif
    });
});
</script>
@endpush
@endsection
