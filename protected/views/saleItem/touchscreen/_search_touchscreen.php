<?php 
    Yii::app()->clientScript->registerScript( 'zoneOption', "
        jQuery( function($){
            $('#grid_zone').on('click','a.zone-btn', function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                             $('#register_container').html(data);
                          }
                    });
                });
        });
    ");
 ?>

<?php 
    Yii::app()->clientScript->registerScript( 'tableOption', "
        jQuery( function($){
            $('#grid_zone').on('click','a.table-btn', function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#register_container').html(data);
                          }
                    });
                });
        });
      ");
 ?>

<?php
Yii::app()->clientScript->registerScript( 'tableNewOrder', "
        jQuery( function($){
            $('#new_order_menu').on('click','a.new-order-header', function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#register_container').html(data);
                          }
                    });
                });
        });
      ");
?>

<?php 
    Yii::app()->clientScript->registerScript( 'deleteItem', "
        jQuery( function($){
            $('div#grid_cart').on('click','a.delete-item',function(e) {
                e.preventDefault();
                var url=$(this).attr('href')
                var gridCart=$('#grid_cart');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#register_container').html(data);
                        }
                    });
                });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'addPayment', "
        jQuery( function($){
            $('#payment_footer_cart').on('click','a.add-payment',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                var message=$('.message');
                var payment_id=$('#payment_type_id').val();
                var payment_amount=$('#payment_amount_id').val();
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        data : {payment_id : payment_id, payment_amount : payment_amount},
                        success : function(data) {
                              $('#register_container').html(data);
                              $('#finish_sale_button').focus();
                          }
                    });
                });
        });
      ");
 ?>

<?php 
    Yii::app()->clientScript->registerScript( 'enterPayment', "
        jQuery( function($){
            $('#payment_footer_cart').on('keypress','#payment_amount_id',function(e) {
                if (e.keyCode === 13 || e.which === 13)
                {    
                    e.preventDefault();
                    var url=$(this).data('url');
                    var message=$('.message');
                    var payment_id=$('#payment_type_id').val();
                    var payment_amount=$(this).val();
                    $.ajax({url:url,
                            type : 'post',
                            beforeSend: function() { $('.waiting').show(); },
                            complete: function() { $('.waiting').hide(); },
                            data : {payment_id : payment_id, payment_amount : payment_amount},
                            success : function(data) {
                                  $('#register_container').html(data);
                                  $('#finish_sale_button').focus();
                             }
                      }); // end ajax
                      //return false;
                  } // end if
             });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'deletePayment', "
        jQuery( function($){
            $('#payment_content').on('click','a.delete-payment',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#register_container').html(data);
                          }
                    });
                });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'groupOption', "
        jQuery( function($){
            $('#group_cart').on('change','#group_id',function(e) {
                e.preventDefault();
                var groupId=$(this).val();
                $.ajax({url: 'SetGroup',
                        //dataType : 'json',
                        data : {group_id : groupId},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                           $('#register_container').html(data);
                        }
                });
            });
        });
      "); 
 ?>

<?php
Yii::app()->clientScript->registerScript( 'confirmOrder', "
        jQuery( function($){
            $('div#btn_footer').on('click','a.btn-confirm-order',function(e) {
                e.preventDefault();
                var url=$(this).attr('href')
                $.ajax({url:url,
                        //dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                             $('#register_container').html(data);
                        }
                    });
                });
        });
      ");
?>


<script>
    
var submitting = false;  

$(document).ready(function()
{   
    //Here just in case the loader doesn't go away for some reason
    $('.waiting').hide();
    
    // ajaxForm to ensure is submitting as Ajax even user press enter key
    $('#add_item_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess});
    
    $('.line_item_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit});  
    
    $('#giftcard_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success : giftcardScannedSuccess}); 
    
    $('#giftcard_selected_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success : giftcardScannedSuccess});  
    
     $('#cart_contents').on('change','input.input-grid',function(e) {
        e.preventDefault();
        $(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit });
    });
    
    $('#payment_footer_cart').on('click','a.detach-giftcard', function(e) {
        e.preventDefault();
        $('#giftcard_selected_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success : giftcardScannedSuccess});
        //$('#SaleItem_giftcard_id').focus();
    });
        
});

function salesBeforeSubmit(formData, jqForm, options)
{
    if (submitting)
    {
        return false;
    }
    submitting = true;
    $('.waiting').show();
}   

/*
function itemScannedSuccess(responseText, statusText, xhr, $form)
{
    //setTimeout(function(){$('#SaleItem_item_id').focus();}, 10);
    console.log(statusText);
} 
*/


// really thanks to this http://www.stefanolocati.it/blog/?p=1413
function itemScannedSuccess(itemId)
{
  return function (responseText, statusText, xhr, $form ) {
     setTimeout(function(){$('#quantity_' + itemId).select();}, 10);
  }
} 

function giftcardScannedSuccess(responseText, statusText, xhr, $form)
{
    //$('.waiting').hide();
    setTimeout(function(){$('#SaleItem_giftcard_id').focus();}, 10);
}

</script>

<script type="text/javascript" language="javascript">
$(document).keydown(function(event)
{
    var mycode = event.keyCode;
    //F1
    if ( mycode === 112) {
        $('#payment_amount_id').focus();
        $('#payment_amount_id').select();
    }
    
    //F2
    if ( mycode === 113) {
        $('#SaleItem_giftcard_id').focus();
    }
   
});
</script>


<!--<script type='text/javascript'>
    $('#dropdown_all_order').on('click','a',function(e){
        e.preventDefault();
        var url=$(this).attr('href')
        $.ajax({
            url: url,
            type : 'post',
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                $('#register_container').html(data);
            }
        });
    });
</script>
-->



<?php Yii::app()->clientScript->registerScript('setFocus', '$("#SaleItem_item_id").focus();'); ?>
