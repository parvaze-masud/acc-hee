@extends('layouts.backend.app')
@section('title','Ledger Voucher List / Register')
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
    'title' => 'Ledger Voucher List / Register',
    'print_layout'=>'landscape',
    'print_header'=>'Ledger Voucher List / Register',
]);

<!-- Page-header component -->
@slot('header_body')
 <form  id="add_ledger_voucher_form"  method="POST">
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
                <th class="th"  style=" width: 5%;text-align:center;">Particulars</th>
                <th class="th" style=" width: 5%;text-align:center; ">Voucher Type</th>
                <th class="th"  style=" width: 5%;text-align:center;">Voucher No</th>
                <th class="th"  style=" width: 5%;text-align:center;">Debit</th>
                <th class="th" style=" width: 5%;text-align:center; ">Credit</th>

            </tr>
        </thead>
        <tbody id="myTable" class="item_body">
        </tbody>
        <tfoot>
            <tr>
                <th  style="width: 1%;" class="th"></th>
                <th  style="width: 5%;" class="th">Total :</th>
                <th  style="width: 2%;font-size: 18px;" class="th"></th>
                <th  style="width: 2%;font-size: 18px;" class="th"></th>
                <th  style="width: 2%;font-size: 18px;" class="th"></th>
                <th  style="width: 2%;font-size: 18px;" class="th total_debit"></th>
                <th  style="width: 2%;font-size: 18px;" class="th total_credit"></th>
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
        function  get_ledger_voucher_initial_show(){
            $.ajax({
                    url: "{{ route('account-ledger-voucher-data')}}",
                    type: 'GET',
                    dataType: 'json',
                    data:{
                        to_date:$('.to_date').val(),
                        from_date:$('.from_date').val(),
                        ledger_id:$('.ledger_id').val()
                    },
                    success: function(response) {
                        get_ledger_voucher_val(response.data)
                    }
            });
        }
        if({{$ledger_id??0}}!=0){
            get_ledger_voucher_initial_show();
        }
    });
    // add ledger voucher form
    $("#add_ledger_voucher_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("account-ledger-voucher-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  get_ledger_voucher_val(response.data)
                },
                error : function(data,status,xhr){
                }
        });
    });

    let   totalDebit=0;totalCredit=0;

    // ledger voucher
    function  get_ledger_voucher_val(response) {
        totalDebit = 0;
        totalCredit = 0;
        let htmlFragments = [];
        response.forEach((v, key) => {
            totalDebit += (v.debit_sum || 0);
            totalCredit += (v.credit_sum || 0);
            htmlFragments.push(`<tr id="${v.tran_id+","+v.voucher_type_id}" class="left left-data editIcon table-row">
                                    <td style="width: 1%;  border: 1px solid #ddd;">${(key + 1)}</td>
                                    <td class="td" style="width: 3%;" class="text-wrap">${new Date(v.transaction_date).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</td>
                                    <td class="td" style="width: 3%;">${(v.ledger_name||'')}</td>
                                    <td class="td" style="width: 3%;">${(v.voucher_name ||'')}</td>
                                    <td class="td" style="width: 3%;">${(v.invoice_no ||'')}</td>
                                    <td class="td" style="width: 3%;">${(v.debit_sum || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                                    <td class="td" style="width: 3%;">${(v.credit_sum || 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                            </tr>`);
        });

        // Append the fragment to the DOM once
        $(".item_body").html(htmlFragments.join(''));
        // Update total values
        $('.total_debit').text((totalDebit||0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.total_credit').text((totalCredit|| 0).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        get_hover();
    }

// stock item  wise  voucher  route
 //get  all data show
 $(document).ready(function () {
     $('.sd').on('click','.customers tbody tr ',function(e){
            localStorage.setItem("end_date",$('.to_date').val());
            localStorage.setItem("start_date",$('.from_date').val());
            localStorage.setItem("ledger_id",$('.ledger_id').val());
            e.preventDefault();
            let day_book_arr=$(this).closest('tr').attr('id').split(",");
            window.location = "{{url('voucher-receipt/edit')}}" + '/' + day_book_arr[0] ;
            if(day_book_arr[1]==14){
                window.location = "{{url('voucher-receipt/edit')}}" + '/' + day_book_arr[0] ;
            }else if(day_book_arr[1]==8){
                window.location = "{{url('voucher-payment')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==1){
                window.location = "{{url('voucher-contra')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==10){
                window.location = "{{url('voucher-purchase')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==24){
                window.location = "{{url('voucher-grn')}}" + '/' + day_book_arr[0]+'/edit' ;
            }else if(day_book_arr[1]==19){
                window.location = "{{url('voucher-sales')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==23){
                window.location = "{{url('voucher-gtn')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==29){
                window.location = "{{url('voucher-purchase-return')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==22){
                window.location = "{{url('voucher-transfer')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==25){
                window.location = "{{url('voucher-sales-return')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==21){
                window.location = "{{url('voucher-stock-journal')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==6){
                window.location = "{{url('voucher-journal')}}" + '/' + day_book_arr[0]+'/edit' ;
            }
            else if(day_book_arr[1]==28){
                window.location = "{{url('voucher-commission')}}" + '/' + day_book_arr[0]+'/edit' ;

            }

    })
});

</script>
@endpush
@endsection
