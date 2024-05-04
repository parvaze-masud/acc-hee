@extends('layouts.backend.app')
@section('title','DayBook')
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

    .td {
        border: 1px solid #ddd;
    }

    .font {
        font-size: 16px;
    }
</style>

@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
'title' => 'Day Book',
'print_layout'=>'landscape',
'print_header'=>'Day Book',
]);

<!-- Page-header component -->
@slot('header_body')
<form id="add_day_book_form" method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row m-0 p-0">
        <div class="col-md-2">
            <label>Voucher Type : </label>
            <select name="voucher_id" class="form-control js-example-basic-single voucher_id">
                <option value="0">--ALL--</option>
                @php $voucher_type_id= 0; @endphp
                @foreach ($vouchers as $voucher)
                @if($voucher_type_id!=$voucher->voucher_type_id)
                @php $voucher_type_id=$voucher->voucher_type_id; @endphp
                <option style="color:red;" value="v{{$voucher->voucher_type_id??''}}">{{$voucher->voucher_type??''}}</option>
                @endif
                <option value="{{$voucher->voucher_id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$voucher->voucher_name}}</option>

                @endforeach
            </select>
        </div>
        <div class="col-md-3  m-0 p-0">
            <div class="row  m-0 p-0 ">
                <div class="col-md-6 m-0 p-0 start_date">
                    <label>Date From: </label>
                    <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{ date('Y-m-d') }}" name="narratiaon">
                </div>
                <div class="col-md-6 m-0 p-0 end_date">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{ date('Y-m-d') }}" name="narratiaon">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <br>
            <button type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:200px; margin-bottom:5px;"><span class="m-1 m-t-1"></span><span>Search</span></button>
        </div>
        <div class="col-md-5">
            <label></label>
            <div>
                <input class="form-check-input debit_check" type="checkbox" name="narratiaon" value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Debit Amount/Inwords Qty
                </label>
                <input class="form-check-input credit_check" type="checkbox" name="last_update" value="1" checked>
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Credit Amount/Outwards Qty
                </label><br>
                <input class="form-check-input narratiaon" type="checkbox" id="narratiaon" name="narratiaon" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Narration
                </label>
                <input class="form-check-input user_info" type="checkbox" name="last_update" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    User Info
                </label>
                <input class="form-check-input last_update" type="checkbox" name="last_update" value="1">
                <label class="form-check-label fs-6" for="flexRadioDefault1">
                    Last Update
                </label>
            </div>
        </div>
    </div>
</form>
@endslot

<!-- Main body component -->
@slot('main_body')
<div class="dt-responsive table-responsive cell-border sd tableFixHead_report ">
</div>
@endslot
@endcomponent
<br>
@push('js')
<!-- table hover js -->
<script type="text/javascript" src="{{asset('libraries/assets/table-hover.js')}}"></script>
<script>
    if (localStorage.getItem("voucher_id")) {
        $('.voucher_id').val(localStorage.getItem("voucher_id"));
        localStorage.setItem("voucher_id", '');
    }
    $(document).ready(function() {
        if (localStorage.getItem("end_date")) {
            $('.to_date').val(localStorage.getItem("end_date"));
            localStorage.setItem("end_date", '');
        }
        if (localStorage.getItem("start_date")) {
            $('.from_date').val(localStorage.getItem("start_date"));
            localStorage.setItem("start_date", '');
        }

    });

    $(document).ready(function() {
        var amount_decimals = "{{company()->amount_decimals}}";

        // day book initial show
        function get_daybook_initial_show() {
            $.ajax({
                url: "{{ url('get-daybook')}}",
                type: 'GET',
                dataType: 'json',
                data: {
                    to_date: $('.to_date').val(),
                    from_date: $('.from_date').val(),
                    voucher_id: $('.voucher_id').val()
                },
                success: function(response) {
                    get_daybook_val(response)
                }
            })
        }

        // day book  show
        $("#add_day_book_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route("daybook-report.store") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    get_daybook_val(response)
                },
                error: function(data, status, xhr) {}
            });
        });

        get_daybook_initial_show();

        function get_daybook_val(response) {
            let htmlFragments = [];
            htmlFragments.push(`<table  id="tableId" style=" border-collapse: collapse; " class="table table-striped customers  " >
                    <thead>
                     <tr>
                        <th style="width: 1%;" class="td">SL.</th>
                        <th style="width: 3%;"class="td">Date</th>
                        <th style="width: 3%;"class="td">Particulars</th>
                        <th style="width: 2%;"class="td">Voucher Type</th>
                        <th style="width: 3%;"class="td">Voucher No</th>`);
            if ($("#narratiaon").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >Narration</th>`);
            }
            if ($(".user_info").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >User Name</th>`);
            }
            if ($(".last_update").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >Last Update</th>`);
            }
            if ($(".debit_check").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >Debit Amount/<br>Inwords Qty</th>`);
            }
            if ($(".credit_check").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >Credit Amount/<br>Outwards Qty</th>`);
            }
            htmlFragments.push(`</tr>`);
            htmlFragments.push(`</thead>`);
            htmlFragments.push(`<tbody  id="myTable"  class="qw">`);
            $.each(response.data, function(key, v) {
                htmlFragments.push(`<tr id='${v.tran_id+","+v.voucher_type_id}' class="left left-data editIcon table-row">
                                        <td  style="width: 1%;"class="td">${(key+1)}</td>
                                        <td  style="width: 3%;"class="td">${join( new Date(v.transaction_date), options, ' ')}</td>
                                        <td  style="width: 3%;"class="td font">${(v.ledger_name||'')}</td>
                                        <td  style="width: 2%;"class="td font"><a class="daybook_voucher" style=" text-decoration: none; font-size: 15px;color:#0B55C4;" href="#">${v.voucher_name||''}</a></td>
                                        <td  style="width: 3%;"class="td font">${v.invoice_no}</td>`);
                if ($("#narratiaon").is(':checked')) {
                    htmlFragments.push(`<td  style="width: 3%;"class="td font">${(v.narration||"")}</td>`);
                }
                if ($(".user_info").is(':checked')) {
                    htmlFragments.push(`<td  style="width: 3%;"class="td font">${(v.narration||"")}'</td>`);
                }
                if ($(".last_update").is(':checked')) {
                    htmlFragments.push(`<td  style="width: 3%;   font-size: 10px;"class="td"><div><i>${JSON.parse(v.other_details||'')}</i></div></td>`);
                }
                if (v.voucher_type_id == 1 || v.voucher_type_id == 6 || v.voucher_type_id == 8 || v.voucher_type_id == 14) {
                    if ($(".debit_check").is(':checked')) {
                        htmlFragments.push(`<td  style="width: %;text-align: right;"class="td font">${(v.debit?(v.debit_sum?v.debit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+ 'TK':''):'')}</td>`);
                    }
                    if ($(".credit_check").is(':checked')) {
                        htmlFragments.push(`<td  style="width: 3%;  text-align: right;"class="td font">${(v.credit?(v.credit_sum?v.credit_sum.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+ 'TK':''):'')}</td>`);
                    }
                } else {
                    if ($(".debit_check").is(':checked')) {
                        htmlFragments.push(`<td  style="width: 3%;   text-align: right;"class="td font">${(v.stock_in_sum?Math.abs(parseFloat(v.stock_in_sum)).toFixed(amount_decimals):'')}</td>`);
                    }
                    if ($(".credit_check").is(':checked')) {
                        htmlFragments.push(`<td  style="width: 3%;  text-align: right;"class="td font">${(v.stock_out_sum?Math.abs(parseFloat(v.stock_out_sum)).toFixed(amount_decimals):'')}</td>`);
                    }
                }
                htmlFragments.push(`</tr>`);
            });
            htmlFragments.push(`</tbody>
                            <tfoot>
                             <tr>
                                <th style="width: 1%;"class="td">SL.</th>
                                <th style="width: 3%;"class="td">Date</th>
                                <th style="width: 3%;"class="td">Particulars</th>
                                <th style="width: 2%;"class="td">Voucher Type</th>
                                <th style="width: 3%;"class="td">Voucher No</th>`);
            if ($("#narratiaon").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >Narration</th>`);
            }
            if ($(".user_info").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td">User Name</th>`);
            }
            if ($(".last_update").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td" >Last Update</th>`);
            }
            if ($(".debit_check").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%;"class="td">Debit Amount/<br>Inwords Qty</th>`);
            }
            if ($(".credit_check").is(':checked')) {
                htmlFragments.push(`<th style="width: 3%; "class="td" >Credit Amount/<br> Outwards Qty</th>`);
            }
            htmlFragments.push(`</tr>
                    </tfoot>
                </table>
                <div class="col-sm-12 text-center hide-btn" >
                            <span><b>Copyright &copy; 2014-2022 <a href="http://www.hamko-ict.com/">Hamko-ICT.</a> All rights reserved.</b></span>
                        </div>`);
            $(".sd").html(htmlFragments.join(''));
            set_scroll_table();
            get_hover();
        }
    });
    //redirect route
    $(document).ready(function() {
        $('.sd').on('click', '.customers tbody tr ', function(e) {
            localStorage.setItem("end_date", $('.to_date').val());
            localStorage.setItem("start_date", $('.from_date').val());
            localStorage.setItem("voucher_id", $('.voucher_id').val());
            e.preventDefault();
            let day_book_arr = $(this).closest('tr').attr('id').split(",");
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
