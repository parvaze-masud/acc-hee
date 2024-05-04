
@extends('layouts.backend.app')
@section('title','Party Ledger')
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
</style>
@endpush
@section('admin_content')<br>
<!-- add component-->
@component('components.report', [
    'title' => 'Party Ledger',
    'print_layout'=>'landscape',
    'print_header'=>'Party Ledger',
]);

<!-- Page-header component -->
@slot('header_body')
    <form id="group_wise_party_form"  method="POST">
        @csrf
        {{ method_field('POST') }}
        <div class="row ">
            <div class="col-md-3">
                <label>Party Name :</label>
                <select name="ledger_id" class="form-control  js-example-basic-single ledger_id" required>
                    <option value="0">--All--</option>
                    {!!html_entity_decode($ledgers)!!}
                </select>
            </div>
            <div class="col-md-3">
                <div class="row  m-0 p-0">
                    <div class="col-md-6 m-0 p-0">
                        <label>Date From: </label>
                        <input type="text" name="from_date" class="form-control setup_date fs-5 from_date" value="{{$form_date??date('Y-m-d')}}">
                    </div>
                    <div class="col-md-6 m-0 p-0">
                        <label>Date To : </label>
                        <input type="text" name="to_date" class="form-control setup_date fs-5 to_date" value="{{$to_date??date('Y-m-d')}}">
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
    <table id="tableId" style=" border-collapse: collapse;" class="table table-striped customers ">
        <thead>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;">SL.</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Opening Balance</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Debit</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Credit</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="closing_checkbox">Current Balance</th>
            </tr>
        </thead>
        <tbody id="myTable" class="ledger_body">
        </tbody>
        <tfoot>
            <tr>
                <th style="width: 1%;  border: 1px solid #ddd;font-weight: bold;">SL.</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Particulars</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Opening Balance</th>
                <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;">Debit</th>
                <th style="width: 2%;  border: 1px solid #ddd;font-weight: bold;">Credit</th>
              <th style="width: 3%;  border: 1px solid #ddd;font-weight: bold;" class="closing_checkbox">Current Balance</th>
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
// ledger id check
if({{$ledger_id??0}}!=0){
     $('.ledger_id').val({{$ledger_id??0}});
}
// party ledger
$(document).ready(function () {
    // get party ledger
    function get_party_ledger_initial_show(){
        $.ajax({
            url: '{{ route("party-ledger-get-data") }}',
                method: 'GET',
                data: {
                    to_date:$('.to_date').val(),
                    from_date:$('.from_date').val(),
                    ledger_id:$(".ledger_id").val(),
                },
                dataType: 'json',
                success: function(response) {
                    get_current_party_ledger_val(response)
                },
                error : function(data,status,xhr){
                }
        });
    }
    // ledger get id check
    if({{$ledger_id??0}}!=0){
        get_party_ledger_initial_show();
    }
    $("#group_wise_party_form").submit(function(e) {
            e.preventDefault();
            let ledger_id=$(".ledger_id").val();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route("party-ledger-get-data") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                      if(ledger_id==0){
                        get_party_ledger_val(response)
                      }else{
                        get_current_party_ledger_val(response)
                      }
                    },
                    error : function(data,status,xhr){

                    }
            });
    });

    function get_party_ledger_val(response) {
        const fragment = document.createDocumentFragment();

        response.data.forEach((v, key) => {
                let balance;
                let sign;
                let closingBalance;
                let closingsign;
                 if(v.nature_group == 1 || v.nature_group == 3){
                     balance= parseFloat(v.opening_balance) + (parseFloat(v.op_group_debit || 0) - parseFloat(v.op_group_credit || 0))
                     sign = balance >= 0 ? 'Dr' : 'Cr';
                 }else{
                    balance= parseFloat(v.opening_balance) + (parseFloat(v.op_group_credit || 0) - parseFloat(v.op_group_debit || 0));
                    sign = balance >= 0 ? 'Cr' : 'Dr';
                 }

            const openingBalance = Math.abs(balance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' + sign;
            const totalDebit = (v.total_debit || 0).toFixed(amount_decimals);
            const totalCredit = (v.total_credit || 0).toFixed(amount_decimals);

            if(v.nature_group == 1 || v.nature_group == 3){
                closingBalance= ((((parseFloat(v.op_group_debit || 0) - parseFloat(v.op_group_credit || 0)) +
                    (parseFloat(v.total_debit || 0)) - parseFloat(v.total_credit || 0)) + (v.opening_balance))) ;
                   closingsign = closingBalance >= 0 ? 'Dr' : 'Cr';
            }else{
                closingBalance= ((((parseFloat(v.op_group_credit || 0) - parseFloat(v.op_group_debit || 0)) +
                    (parseFloat(v.total_credit || 0)) - parseFloat(v.total_debit || 0)) + (v.opening_balance)));
                  closingsign = closingBalance >= 0 ? 'Cr' : 'Dr';
            }

            const currentBalance = Math.abs(balance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ' +closingsign;
            const row = document.createElement('tr');
            row.className = 'left left-data editIcon table-row';
            row.innerHTML = `
                <td style="width: 1%; border: 1px solid #ddd;">${key + 1}</td>
                <td style="width: 3%; border: 1px solid #ddd; font-size: 16px;">${v.ledger_name || ''}</td>
                <td style="width: 3%; border: 1px solid #ddd; font-size: 20px;">${openingBalance}</td>
                <td style="width: 2%; border: 1px solid #ddd; font-size: 20px;">${totalDebit.replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                <td style="width: 2%; border: 1px solid #ddd; font-size: 20px;">${totalCredit.replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                <td style="width: 3%; border: 1px solid #ddd; font-size: 20px;">${currentBalance}</td>
            `;

            fragment.appendChild(row);
        });
       $(".ledger_body").html(fragment);
        get_hover();
    }

    function get_current_party_ledger_val(response){
                   var html='';
                    html +='<table   id="tableId"  style=" border-collapse: collapse;"   class="table  customers wrap" >';
                    html +='<thead >';
                        html+='<tr>';
                            html+= '<th style="width: 1%;  border: 1px solid #ddd;">SL.</th>';
                            html+= '<th style="width: 1%;  border: 1px solid #ddd;">Date</th>';
                            html+= '<th style="width: 6%;  border: 1px solid #ddd;">Particulars</th>';
                            html+= '<th style="width: 1%;  border: 1px solid #ddd;">Voucher Type</th>';
                            html+='<th style="width: 1%;  border: 1px solid #ddd;" >Voucher No</th>';
                            html+='<th style="width: 2%;  border: 1px solid #ddd;" >Debit</th>';
                            html+='<th style="width: 2%;  border: 1px solid #ddd;" >Credit</th>';
                        html+='</tr>';
                    html+='</thead>';
                    html+='<tbody id="myTable" class="qw">';
                        let total_debit=0,total_credit=0,opening_balance=0;
                        $.each(response.data.party_ledger, function(key, v) {
                            total_debit+=(v.debit_sum||0);total_credit+=(v.credit_sum||0);
                            html+='<tr id='+v.tran_id+","+v.voucher_type_id+' class="left left-data editIcon table-row"> ';
                                html += '<td  style="width: 1%;  border: 1px solid #ddd;">'+(key+1)+'</td>' ;
                                html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px;">'+join( new Date(v.transaction_date), options, ' ')+'</td>' ;
                                html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px; "><i style="font-weight: bold">'+(v.ledger_name ? v.ledger_name:'')+'</i></td>';
                                html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px;"><a class="party_ledger_voucher" style=" text-decoration: none; font-size: 16px;color:#0B55C4;" href="#">'+v.voucher_name+'</a></td>' ;
                                html += '<td  style="width: 1%;  border: 1px solid #ddd; font-size: 16px;">'+v.invoice_no+'</td>' ;
                                html += '<td  style="width: 2%;  border: 1px solid #ddd; text-align: right; font-size: 20px;">'+((v.debit_sum||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+'</td>' ;
                                html += '<td  style="width: 2%;  border: 1px solid #ddd;text-align: right; font-size: 20px;">'+((v.credit_sum||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')+'</td>' ;
                            html+="</tr> ";
                        });
                        html+=`<tr class="left left-data editIcon table-row">
                              <td style="width: 1%;  border: 1px solid #ddd;"></td>
                              <td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;">
                              </td><td colspan="2" style=" border: 1px solid #ddd;font-size: 18px; text-align: right;">Current Balance  :</td>
                              <td style="width: 1%;  border: 1px solid #ddd; font-size: 20px;text-align: right; ">${(total_debit).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                              <td style="width: 1%;  border: 1px solid #ddd; font-size: 20px;text-align: right;">${(total_credit).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td></tr>`;
                        if((response.data.group_chart_nature.nature_group==1)||(response.data.group_chart_nature.nature_group==3)){
                           opening_balance=(response.data.op_party_ledger[0]?((response.data.op_party_ledger[0].op_total_debit)-(response.data.op_party_ledger[0].op_total_credit)):0)+(response.data.group_chart_nature.opening_balance);
                           html+=`<tr class="left left-data editIcon table-row">
                            <td style="width: 1%;  border: 1px solid #ddd;"></td>
                            <td style="width: 1%;  border: 1px solid #ddd;"></td>
                            <td style="width: 1%;  border: 1px solid #ddd;"></td>
                            <td colspan="2"  style="width: 1%;   border: 1px solid #ddd;font-size: 18px;  text-align: right;">Opening Balance :</td>
                            <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px;text-align: right;">${(opening_balance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                            <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;"></td> </tr>`;
                        }else if((response.data.group_chart_nature.nature_group==2)||(response.data.group_chart_nature.nature_group==4)){
                            opening_balance=(response.data.op_party_ledger[0]?((response.data.op_party_ledger[0].op_total_credit)-(response.data.op_party_ledger[0].op_total_debit)):0)+(response.data.group_chart_nature.opening_balance);
                           html+=`<tr class="left left-data editIcon table-row">
                            <td style="width: 1%;  border: 1px solid #ddd;"></td>
                            <td style="width: 1%;  border: 1px solid #ddd;"></td>
                            <td style="width: 1%;  border: 1px solid #ddd;"></td>
                            <td colspan="2"  style="width: 1%;   border: 1px solid #ddd;font-size: 18px;  text-align: right;">Opening Balance :</td>
                            <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px;text-align: right;" >${(opening_balance).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td><td style="width: 1%;  border: 1px solid #ddd;font-size: 20px; text-align: right;"></td> </tr>`;
                        }
                        if((response.data.group_chart_nature.nature_group==1)||(response.data.group_chart_nature.nature_group==3)){
                            html+=`<tr class="left left-data editIcon table-row">
                                <td style="width: 1%;  border: 1px solid #ddd;"></td>
                                <td style="width: 1%;  border: 1px solid #ddd;"></td><td style="width: 1%;  border: 1px solid #ddd;"></td>
                                <td colspan="2" style="width: 1%; font-weight: bold; border: 1px solid #ddd;font-size: 18px;  text-align: right;">Closing Balance  :</td>
                                <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px;text-align: right;">${(((opening_balance||0)+(total_debit||0))-(total_credit||0)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')} Dr</td>
                                <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px;text-align: right;"></td> </tr>`;
                        }else if((response.data.group_chart_nature.nature_group==2)||(response.data.group_chart_nature.nature_group==4)){
                            html+=`<tr class="left left-data editIcon table-row">
                                <td style="width: 1%;  border: 1px solid #ddd;"></td>
                                <td style="width: 1%;  border: 1px solid #ddd;"></td>
                                <td style="width: 1%;  border: 1px solid #ddd;"></td>
                                <td colspan="2" style="width: 1%; font-weight: bold; border: 1px solid #ddd;font-size: 18px;  text-align: right;">Closing Balance  :</td>
                                <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px;text-align: right;">${(((opening_balance||0)+(total_credit))-(total_debit)).toFixed(amount_decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,')} Cr</td>
                                <td style="width: 1%;  border: 1px solid #ddd;font-size: 20px;text-align: right;"></td> </tr>`;
                        }

                    html+='</tbody>';
                    html+='</table>';
            $(".sd").html(html);
            get_hover();
    }
});
//get  all data show
$(document).ready(function () {
    $('.sd').on('click','.customers tbody tr ',function(e){
        localStorage.setItem("end_date",$('.to_date').val());
        localStorage.setItem("start_date",$('.from_date').val());
        localStorage.setItem("voucher_id",$('.voucher_id').val());
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
