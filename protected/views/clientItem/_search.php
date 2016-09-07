<!-- Style for responsive table -->
<style type="text/css">
/*<![CDATA[*/
@media
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

        /* Force table to not be like tables anymore */
        #grid_cart table,#grid_cart thead,#grid_cart tbody,#grid_cart th,#grid_cart td,#grid_cart tr {
                display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        #grid_cart thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
        }

        #grid_cart tr { border: 1px solid #ccc; }

        #grid_cart td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
        }

        #grid_cart td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
        }
        .grid-view .button-column {
                text-align: left;
                width:auto;
        }
        /*
        Label the data
        */
        #grid_cart td:nth-of-type(1):before { content: 'ឈ្មោះទំនិញ'; }
        #grid_cart td:nth-of-type(2):before { content: 'តំលៃ'; }
        #grid_cart td:nth-of-type(3):before { content: 'បរិមាណ'; }
        #grid_cart td:nth-of-type(4):before { content: 'បញ្ចុះតំលៃ'; }
        #grid_cart td:nth-of-type(5):before { content: 'សរុប'; }
        #grid_cart td:nth-of-type(6):before { content: '&nbsp;'; }

	}
/*]]>*/
</style>
<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
        'title'         =>  Yii::t('app','Set Customer & Item'),
        'headerIcon'    => 'icon-shopping-cart',
));
?> 
<div id="itemlookup">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>    
    <?php //echo $form->hiddenField($model,'item',array()); ?>
    
    <?php 
    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
        'asDropDownList' => false,
        'model'=> $model, 
        'attribute'=>'item_id',
        'pluginOptions' => array(
                'placeholder' => Yii::t('app','form.sale.saleregister_hint'),
                'multiple'=>false,
                'width' => '50%',
                //'tokenSeparators' => array(',', ' '),
                'allowClear'=>true,
                'minimumInputLength'=>1,
                'ajax' => array(
                    'url' => Yii::app()->createUrl('Item/getItem/'), 
                    'dataType' => 'json',
                    'cache'=>true,
                    'data' => 'js:function(term,page) {
                                return {
                                    term: term, 
                                    page_limit: 10,
                                    quietMillis: 100, //How long the user has to pause their typing before sending the next request
                                    apikey: "e5mnmyr86jzb9dhae3ksgd73" // Please create your own key!
                                };
                            }',
                    'results' => 'js:function(data,page){
                        var remote = $(this);
                        arr=data.results;
                        var more = arr.filter(function(value) { return value !== undefined }).length;
                        if (more==1)
                        {
                            var item_id=0;
                            $.each(data.results, function(key,value){
                                item_id=value.id;
                            });
                            var gridCart=$("#grid_cart");
                            var taskCart=$("#task_cart");
                            $.ajax({url: "Index",
                                    dataType : "json",
                                    data : {item_id : item_id},
                                    type : "post",
                                    beforeSend: function() { $(".waiting").show(); },
                                    complete: function() { $(".waiting").hide(); },
                                    success : function(data) {
                                            if (data.status==="success")
                                            {
                                                gridCart.html(data.div_gridcart);
                                                taskCart.html(data.div_totalcart);
                                                remote.select2("open");
                                                remote.select2("data", null);
                                                location.reload();
                                            }
                                            else 
                                            {
                                               console.log(data.message);
                                            }
                                      }
                                });
                            }
                        return { results: data.results };
                     }',
                ),
                'initSelection' => 'js:function (element, callback) {
                       var id=$(element).val();
                       console.log(id);
                }',
                //'htmlOptions'=>array('id'=>'search_item_id'),
        )));
    ?>
    
    <?php echo TbHtml::linkButton('',array(
        'color'=>TbHtml::BUTTON_COLOR_INFO,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'hand-up white',
        'url'=>$this->createUrl('Item/SelectItemClient/'),
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t('app','select items'),
    )); ?>
       
<?php $this->endWidget(); ?>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('setFocus', '$("#SaleItem_item_id").select2("open");'); ?>

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
</script>

<?php 
    Yii::app()->clientScript->registerScript( 'searchItem', "
        jQuery( function($){
            $('#SaleItem_item_id').on('change', function(e) {
                e.preventDefault();
                var remote = $('#SaleItem_item_id');
                var item_id=remote.val();
                var gridCart=$('#grid_cart');
                var taskCart=$('#task_cart');
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
                                    taskCart.html(data.div_taskcart);
                                    remote.select2('data', null);
                                    remote.select2('open');
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
    Yii::app()->clientScript->registerScript( 'removeCustomer', "
        jQuery( function($){
            $('#client_cart').on('click','a.detach-customer', function(e) {
                e.preventDefault();
                var clientCart=$('#client_cart');
                $.ajax({url: 'RemoveCustomer',
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    clientCart.html(data.div_clientcart);
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
    Yii::app()->clientScript->registerScript( 'deleteItem', "
        jQuery( function($){
            $('div#grid_cart').on('click','a.delete-item',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var totalCart=$('#total_cart');
                var paymentCart=$('#payment_cart');
                $.ajax({url:url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    totalCart.html(data.div_totalcart);
                                    paymentCart.html(data.div_paymentcart);
                                    if (data.items==0)
                                    {
                                         $('div#payment_cart').hide();
                                    }
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
    Yii::app()->clientScript->registerScript( 'editItem', "
        jQuery( function($){
            $('div#grid_cart').on('change','input',function(e) {
                e.preventDefault();
                var frmCtlVal=$(this).val();
                var item_id=$(this).data('id');
                var quantity=$('#quantity_'+ item_id).val();
                var price=$('#price_'+ item_id).val();
                var discount=$('#discount_'+ item_id).val();
                var gridCart=$('#grid_cart');
                var taskCart=$('#task_cart');
                var message=$('.message');
                var alert=$('.alert');
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
                                     taskCart.html(data.div_taskcart);
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
    Yii::app()->clientScript->registerScript( 'setComment', "
        jQuery( function($){
            $('div#comment_content').on('change','#comment_id',function(e) {
                e.preventDefault();
                var comment=$(this).val();
                $.ajax({
                        url: 'SetComment',
                        dataType : 'json',
                        data : {comment : comment},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    console.log('comment saved');
                                    
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
    Yii::app()->clientScript->registerScript( 'completeTransaction', "
        jQuery( function($){
            $('#task_cart').on('click','a.complete-tran',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to submit this transaction? This cannot be undone.'))
                {
                  return false;
                }
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
                                    //window.open(data.div_receipt, 'Receipt', 'height=300,width=300');
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
    Yii::app()->clientScript->registerScript( 'cancelSale', "
        jQuery( function($){
            $('#task_cart').on('click','a.cancel-sale',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to clear this sale? All items will cleared.'))
                {
                  return false;
                }
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var taskCart=$('#task_cart');
                var clientCart=$('#client_cart');
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
                                    taskCart.html(data.div_taskcart);
                                    clientCart.html(data.div_clientcart);
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




<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END); ?>