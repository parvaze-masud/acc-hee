
@extends('layouts.backend.app')
@section('title','Ledger Cash Flow')
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
    'title' => 'Ledger Cash Flow',
    'print_layout'=>'landscape',
    'print_header'=>'Ledger Cash Flow',
]);

<!-- Page-header component -->
@slot('header_body')
 <form  id="add_ledger_form"  method="POST">
    @csrf
    {{ method_field('POST') }}
    <div class="row m-0 p-0">
        <div class="col-md-4">
            <label>Party Name : </label>
            <select name="ledger_id" id="ledger_id" class="form-control  js-example-basic-single  ledger_id" required>
                <option value="">--Select--</option>
                {!!html_entity_decode($ledger_data)!!}
            </select>
        </div>
        <div class="col-md-4  m-0 p-0">
            <div class="row  m-0 p-0 ">
                <div class="col-md-6 m-0 p-0 start_date">
                    <label>Date From: </label>
                    <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{company()->financial_year_start }}" >
                </div>
                <div class="col-md-6 m-0 p-0 end_date">
                    <label>Date To : </label>
                    <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <br>
            <button  type="submit" class="btn hor-grd btn-grd-primary btn-block submit" style="width:200px; margin-bottom:5px;" ><span class="m-1 m-t-1" ></span><span >Search</span></button>
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
<script>
if({{$ledger_id??0}}!=0){
     $('.ledger_id').val({{$ledger_id??0}});
}
$(document).ready(function () {
    function  get_ledger_cash_flow_initial_show(){
        $.ajax({
                url: "{{ url('ledger-cash-flow-get-data')}}",
                type: 'GET',
                dataType: 'json',
                data:{
                    to_date:$('.to_date').val(),
                    from_date:$('.from_date').val(),
                    ledger_id:$('.ledger_id').val()
                },
                success: function(response) {
                    get_ledger_val(response)
                }
        });
    }

    var amount_decimals="{{company()->amount_decimals}}";
    $("#add_ledger_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            url: '{{ route("ledger-cash-flow-get-data") }}',
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    get_ledger_val(response)
                },
                error : function(data,status,xhr){
                }
        });
    });

    if({{$ledger_id??0}}!=0){
        get_ledger_cash_flow_initial_show();
    }
    function get_ledger_val(response){
        var html='';
                    html +='<table   id="tableId"   style=" border-collapse: collapse;"   class="table  customers wrap" >';
                    html +='<thead >';
                        html+='<tr>';
                            html+= '<th style="width: 1%;  border: 1px solid #ddd;">SL.</th>';
                            html+= '<th style="width: 3%;  border: 1px solid #ddd;">Date</th>';
                            html+= '<th style="width: 3%;  border: 1px solid #ddd;">Particulars</th>';
                            html+= '<th style="width: 2%;  border: 1px solid #ddd;">Voucher Type</th>';
                            html+='<th style="width: 3%;  border: 1px solid #ddd;" >Voucher No</th>';
                            html+= '<th style="width: 2%;  border: 1px solid #ddd;">Inflow</th>';
                            html+='<th style="width: 3%;  border: 1px solid #ddd;" >Outflow</th>';
                        html+='</tr>';
                    html+='</thead>';
                    html+='<tbody id="myTable" class="qw">';
                    let total_debit=0,total_credit=0;
                    $.each(response.data, function(key, v) {
                        total_debit+=v.sum_debit;
                        total_credit+=v.sum_credit;
                        html+='<tr id='+v.tran_id+","+v.voucher_type_id+' class="left left-data editIcon table-row"> ';
                            html += '<td  style="width: 1%;  border: 1px solid #ddd;">'+(key+1)+'</td>' ;
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+join( new Date(v.transaction_date), options, ' ')+'</td>' ;
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+(v.ledger_name ? v.ledger_name:'')+'</td>' ;
                            html += '<td  style="width: 2%;  border: 1px solid #ddd; font-size: 16px;"><a class="daybook_voucher" style=" text-decoration: none; font-size: 16px;color:#0B55C4;" href="#">'+v.voucher_name+'</a></td>' ;
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+v.invoice_no+'</td>' ;
                            html += '<td  style="width: 2%;  border: 1px solid #ddd; font-size: 16px;">'+(v.sum_debit?v.sum_debit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'):0.0)+'</td>' ;
                            html += '<td  style="width: 3%;  border: 1px solid #ddd; font-size: 16px;">'+(v.sum_credit?v.sum_credit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,'):0.0)+'</td>' ;
                        html+="</tr> ";
                    });
                    html+='</tbody>';
                    html +='<tfoot>';
                            html+= '<th style="width: 1%;  border: 1px solid #ddd;"></th>';
                            html+= '<th style="width: 3%;  border: 1px solid #ddd;"></th>';
                            html+= '<th style="width: 3%;  border: 1px solid #ddd;"></th>';
                            html+= '<th style="width: 2%;  border: 1px solid #ddd;"></th>';
                            html+='<th style="width: 3%;  border: 1px solid #ddd;" >Total</th>';
                            html+= '<th style="width: 2%;  border: 1px solid #ddd;">'+total_debit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+'</th>';
                            html+='<th style="width: 3%;  border: 1px solid #ddd;" >'+total_credit.toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+'</th>';
                    html+='</tfoot>';
                    html+='</table>';
                    html += `<div class="col-sm-12 text-center" >
                                        <span><b>Copyright &copy; 2014-2022 <a href="http://www.hamko-ict.com/">Hamko-ICT.</a> All rights reserved.</b></span>
                                        </div>`
            $(".sd").html(html);
            set_scroll_table();
            get_hover();
    }
});
     //get  all data show
     $(document).ready(function () {
     $('.sd').on('click','.customers tbody tr ',function(e){
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
