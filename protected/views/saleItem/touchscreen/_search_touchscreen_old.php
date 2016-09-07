<?php /*
    Yii::app()->clientScript->registerScript( 'searchItem', "
        jQuery( function($){
            $('div#grid_cart').on('change','#SaleItem_item_id',function(e) {
                e.preventDefault();
                var remote = $('#SaleItem_item_id');
                var item_id=remote.val();
                var gridCart=$('#grid_cart');
                $.ajax({url: 'Index',
                        dataType : 'json',
                        data : {item_id : item_id},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    //$('#SaleItem_item_id').select2('open');
                                    //$('.slim-scroll').slimScroll({ scrollTo: '300px' });
                                    $('#quantity_' + item_id).select();
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
                });
        });
      ");
    * 
    */
 ?>

<?php 
    Yii::app()->clientScript->registerScript( 'deleteItem', "
        jQuery( function($){
            $('div#grid_cart').on('click','a.delete-item',function(e) {
                e.preventDefault();
                var url=$(this).attr('href')
                var gridCart=$('#grid_cart');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    $('#SaleItem_item_id').select2('open');
                                    
                                }
                                else 
                                {
                                  alert('something worng');
                                  return false;
                                }
                          }
                    });
                });
        });
      ");
 ?>  

<?php 
    Yii::app()->clientScript->registerScript( 'cancelSale', "
        jQuery( function($){
            $('div#grid_cart').on('click','a.cancel-sale',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to clear this sale? All items will cleared.'))
                {
                  return false;
                }
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var message=$('.message');
                var gridZone=$('#grid_zone');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    message.hide();
                                    gridCart.html(data.div_gridcart);
                                    gridZone.html(data.div_gridzone);
                                }
                                else 
                                {
                                   console.log(data.div);
                                }
                          }
                    });
                });
        });
      ");
 ?>  

<?php 
    Yii::app()->clientScript->registerScript( 'SuspendedSale', "
        jQuery( function($){
            $('#grid_cart').on('click','a.suspend-sale',function(e) {
                e.preventDefault();
                /*
                if (!confirm('Are you sure you want to print receipt to kitchen?'))
                {
                  return false;
                }
                */
                var url=$(this).attr('href');
                var message=$('.message');
                var remote = $('#SaleItem_item_id');
                var gridCart=$('#grid_cart');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    
                                    //message.hide();
                                    //gridCart.html(data.div_gridcart);
                                    //remote.select2('data', null);
                                    //remote.select2('open');
                                    window.location.href=data.div_receipt;
                                }
                                else if (data.status==='receiptprinting')
                                {
                                    window.location.href=data.div_receipt;
                                }
                                else if (data.status ==='failed')
                                {
                                    message.hide();
                                    message.slideToggle();
                                    message.html(data.message);
                                    message.show();
                                    return false;
                                }
                          }
                    });
                });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'touchItem', "
        jQuery( function($){
            $('div#product_show').on('click','a.list-product',function(e) {
                e.preventDefault();
                $('#myModal').modal('hide');
                var remote = $('#SaleItem_item_id');
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    //remote.select2('open');
                                }
                                else 
                                {
                                  alert('something worng');
                                  return false;
                                }
                          }
                }); 
             });
         });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'editItem', "
        jQuery( function($){
            $('div#grid_cart').on('keydown','input.editable-box',function(e) {
                var KEYCODE_ENTER = 13;
                var KEYCODE_ESC = 27;
                if (e.keyCode==KEYCODE_ENTER || e.keyCode==KEYCODE_ESC) {
                    e.preventDefault();
                    var frmCtlVal=$(this).val();
                    var item_id=$(this).data('id');
                    var item_parent_id=$(this).data('parentid');
                    var quantity=$('#quantity_'+ item_id).val();
                    var price=$('#price_'+ item_id).val();
                    var discount=$('#discount_'+ item_id).val();
                    var gridCart=$('#grid_cart');
                    var message=$('.message');
                    $.ajax({
                        url: 'EditItem',
                        dataType : 'json',
                        data : {item_id : item_id, quantity : quantity, discount : discount, price : price, item_parent_id: item_parent_id},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            if (data.status==='success')
                            {
                                 message.hide();
                                 gridCart.html(data.div_gridcart);
                                 $('#SaleItem_item_id').select2('open');
                            }    
                            else
                            {
                                alert('someting wrong');
                                 return false;
                            }
                       }
                    });
                }
            });
        });
      "); 
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'addPayment', "
        jQuery( function($){
            $('#grid_cart').on('click','a.add-payment',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var message=$('.message');
                var payment_id=$('#payment_type_id').val();
                var payment_amount=$('#payment_amount_id').val();
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        data : {payment_id : payment_id, payment_amount : payment_amount},
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    message.hide();
                                    gridCart.html(data.div_gridcart);
                                }
                                else 
                                {
                                   console.log(data.div);
                                }
                          }
                    });
                });
        });
      ");
 ?>  

<?php 
    Yii::app()->clientScript->registerScript( 'enterPayment', "
        jQuery( function($){
            $('#grid_cart').on('keypress','#payment_amount_id',function(e) {
                if (e.keyCode == 13 || e.which == 13)
                {    
                    e.preventDefault();
                    var url=$(this).data('url');
                    var gridCart=$('#grid_cart');
                    var totalCart=$('#total_cart');
                    var paymentCart=$('#payment_cart');
                    var message=$('.message');
                    var payment_id=$('#payment_type_id').val();
                    var payment_amount=$(this).val();
                    //alert('Hit enter key');
                    $.ajax({url:url,
                            dataType : 'json',
                            type : 'post',
                            beforeSend: function() { $('.waiting').show(); },
                            complete: function() { $('.waiting').hide(); },
                            data : {payment_id : payment_id, payment_amount : payment_amount},
                            success : function(data) {
                                    message.hide();
                                    gridCart.html(data.div_gridcart);
                                    totalCart.html(data.div_totalcart);
                                    paymentCart.html(data.div_paymentcart);
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
            $('#grid_cart').on('click','a.delete-payment',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var message=$('.message');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    message.hide();
                                    gridCart.html(data.div_gridcart);
                                }
                                else 
                                {
                                   console.log(data.div);
                                }
                          }
                    });
                });
        });
      ");
 ?>  

<?php 
    Yii::app()->clientScript->registerScript( 'completeSale', "
        jQuery( function($){
            $('#grid_cart').on('click','a.complete-sale',function(e) {
                e.preventDefault();
                /*
                if (!confirm('Are you sure you want to submit this sale? This cannot be undone.'))
                {
                  return false;
                }
                */
                var url=$(this).attr('href');
                var message=$('.message');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    window.location.href=data.div_receipt;
                                }
                                else if (data.status ==='failed')
                                {
                                    message.hide();
                                    message.slideToggle();
                                    message.html(data.message);
                                    message.show();
                                    return false;
                                }
                          }
                    });
                });
        });
      ");
 ?>  

<?php 
    Yii::app()->clientScript->registerScript( 'removeCustomer', "
        jQuery( function($){
            $('#grid_cart').on('click','a.detach-customer', function(e) {
                e.preventDefault();
                var gridCart=$('#grid_cart');
                $.ajax({url: 'RemoveCustomer',
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
                });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'detachGiftcard', "
        jQuery( function($){
            $('#grid_cart').on('click','a.detach-giftcard', function(e) {
                e.preventDefault();
                var gridCart=$('#grid_cart');
                $.ajax({url: 'RemoveGiftcard',
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
                });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'acceptedEditItem', "
        jQuery( function($){
            $('div#grid_cart').on('accepted.keyboard','.numpad',function(e) {
                e.preventDefault();
                var frmCtlVal=$(this).val();
                var item_id=$(this).data('id');
                var quantity=$('#quantity_'+ item_id).val();
                var price=$('#price_'+ item_id).val();
                var discount=$('#discount_'+ item_id).val();
                var gridCart=$('#grid_cart');
                var message=$('.message');
                $.ajax({
                        url: 'EditItem',
                        dataType : 'json',
                        data : {item_id : item_id, quantity : quantity, discount : discount, price : price},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                     message.hide();
                                     gridCart.html(data.div_gridcart);
                                     $('#SaleItem_item_id').select2('open');
                                }    
                                else
                                {
                                    alert('someting wrong');
                                     return false;
                                }
                       }
                 });
            });
        });
      "); 
 ?> 


<?php 
    Yii::app()->clientScript->registerScript( 'zoneOption', "
        jQuery( function($){
            $('#grid_zone').on('click','a.zone-btn', function(e) {
                e.preventDefault();
                var gridZone=$('#grid_zone');
                var gridCart=$('#grid_cart');
                var url=$(this).attr('href');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                   gridCart.html(data.div_gridcart); 
                                   gridZone.html(data.div_gridzone); 
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
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
                var gridZone=$('#grid_zone');
                var gridCart=$('#grid_cart');
                var url=$(this).attr('href');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridZone.html(data.div_gridzone);
                                    gridCart.html(data.div_gridcart);
                                    $('#SaleItem_item_id').select2('open');
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
                });
        });
      ");
 ?> 

<?php 
    Yii::app()->clientScript->registerScript( 'groupOption', "
        jQuery( function($){
            $('#grid_zone').on('change','#group_id',function(e) {
                e.preventDefault();
                var groupId=$(this).val();
                var gridZone=$('#grid_zone');
                var gridCart=$('#grid_cart');
                $.ajax({url: 'SetGroup',
                        dataType : 'json',
                        data : {group_id : groupId},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            if (data.status==='success')
                            {
                                gridZone.html(data.div_gridzone);
                                gridCart.html(data.div_gridcart);   
                            }
                            else 
                            {
                               console.log(data.message);

                            }
                        }
                });
            });
        });
      "); 
 ?> 



<script>
function isNumber(n) {
  //return !isNaN(parseFloat(n)) && isFinite(n);
  console.log(n);
}   
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return (charCode<=31 ||  charCode==46 || (charCode>=48 && charCode<=57) || (charCode==45));
}   

$( ".editable-box" ).keypress(function(e) {
    console.log( "Handler for .keypress() called." + e.keyCode );
});
</script>