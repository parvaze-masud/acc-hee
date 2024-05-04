// select option change
$('.godown').on('change',function(){
    let godown=$('.godown option:selected').text();
    let godown_val=$('.godown').val();
    $('#orders tr').find('.godown_name').each(function(){
        $('.godown_name').val(godown);
        $('.godown_id').val(godown_val);
    })
})
// alert message
function swal_message(data,message,m_title){
  swal({
      title:m_title,
      text: data,
      type: message,
      timer: '1500'
  });

}


function  selected_auto_value_change(check_current_stock,currentEle,response,amount_decimals){
    let qty=0;
    if(check_current_stock==0){
        if((currentEle.closest('tr').find('.stock').val())>=(currentEle.closest('tr').find('.qty').val())){
            qty=currentEle.closest('tr').find('.qty').val();
        }else{
            currentEle.closest('tr').find('.qty').val(currentEle.closest('tr').find('.stock').val());
            qty=currentEle.closest('tr').find('.stock').val();
        }
    }else{
            qty=currentEle.closest('tr').find('.qty').val();
    }
    currentEle.closest('tr').find('.amount').val(parseFloat(qty*response).toFixed(amount_decimals));
   
}
 function check_item_null(total_qty_is,product_id){
          if((total_qty_is==0) && ($('.total_qty').val())>0){
                $(":submit").attr("disabled", false);
            }else if(total_qty_is!=0){
                let product='';
                $(document).find('.product_name').each(function(){
                    if($(this).val())product=$(this).val();
                });
                if(product=='' ||product==null)$(":submit").attr("disabled", true);
                else $(":submit").attr("disabled", false);
            }else{
                $(":submit").attr("disabled", true);
            }
}

function input_checking(class_name){
    $('#orders,#orders_in,#orders_out').on('keyup  selected blur',`.${class_name}_name`,function(){
        let id=$(this).closest('tr').find(`.${class_name}_id`).val();
        let name=$(this).closest('tr').find(`.${class_name}_name`).val();
        if((id.length!=0)||(name.length==0)){
             $(this).closest('tr').find(`.${class_name}_name`).css({backgroundColor: 'white'}); 
             $('#orders').on('click','input',function(){
                $(this).focus();
             })
        }else{
            $(this).css('backgroundColor','red');
            $(".cansale_btn").attr("disabled", true);
            $(this).focus(); 
        }    
   });
}

function  selected_auto_value_change_in_out(check_current_stock,stock_class,qty_class,amount_class,currentEle,response,amount_decimals){
    let qty=0;
    if(check_current_stock==0){
        if((currentEle.closest('tr').find(`.${stock_class}`).val())>=(currentEle.closest('tr').find(`.${qty_class}`).val())){
            qty=currentEle.closest('tr').find(`.${qty_class}`).val();
        }else{
            currentEle.closest('tr').find(`.${qty_class}`).val(currentEle.closest('tr').find(`.${stock_class}`).val());
            qty=currentEle.closest('tr').find(`.${stock_class}`).val();
        }
    }else{
            qty=currentEle.closest('tr').find(`.${qty_class}`).val();
    }
    currentEle.closest('tr').find(`.${amount_class}`).val(parseFloat(qty*response).toFixed(amount_decimals));
}

// item checking in or out
function check_item_in_out(total_qty_is,product_id,total_qty,product_name){
    if((total_qty_is==0) && ($(`.${total_qty}`).val())>0){
        $(":submit").attr("disabled", false);
    }else if(total_qty_is!=0){
        let product='';
        $(document).find(`.${product_name}`).each(function(){
            if($(this).val())product=$(this).val();
        });
        if(product=='' || product==null||(product_id==0))$(":submit").attr("disabled", true);
        else $(":submit").attr("disabled", false);
    }else{
        $(":submit").attr("disabled", true);
    }
}