<?php //$this->widget( 'ext.modaldlg.EModalDlg' ); ?> 
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
        'title'         =>  Yii::t('app',$trans_header),
        'headerIcon'    => 'ace-icon fa fa-tasks',
        'headerButtons' => array(
            TbHtml::buttonGroup(
                array(
                    array('label' => Yii::t('app','form.item._form.header_create'),'url' =>Yii::app()->createUrl('Item/Create',array('grid_cart'=>'R')),'icon'=>'glyphicon-plus white','class'=>'update-dialog-open-link','data-update-dialog-title' => Yii::t( 'app', 'form.item._form.header_create' )),
                    //array('label'=>' '),
                ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
            ),/*
            TbHtml::buttonGroup(
                array(
                    array('label' => Yii::t('app','Receive'), 'size'=>TbHtml::BUTTON_SIZE_SMALL, 'class'=>'btn-group-mode btn-receive', 'data-id'=>'receive'),
                    array('label' => Yii::t('app','Return'), 'size'=>TbHtml::BUTTON_SIZE_SMALL, 'class'=>'btn-group-mode btn-return', 'data-id'=>'return'),
                ),array('color'=>TbHtml::BUTTON_COLOR_INFO,'toggle'=>'radio')
            ),
             * 
            */
        )
));
?>
<div id="itemlookup">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
       
    <?php 
    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
        'asDropDownList' => false,
        'model'=> $model, 
        'attribute'=>'item_id',
        //'events'=>array('change'=>''),
        'pluginOptions' => array(     
                'placeholder' => Yii::t('app','form.sale.saleregister_hint'),
                'multiple'=>false,
                'width' => '50%',
                'allowClear'=>true,
                'minimumInputLength'=>1,
                'data-url'=>Yii::app()->createUrl($this->route),
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
                            $.ajax({url: remote.data("url"),
                                    dataType : "json",
                                    data : {item_id : item_id},
                                    type : "post",
                                    beforeSend: function() { $(".waiting").show(); },
                                    complete: function() { $(".waiting").hide(); },
                                    success : function(data) {
                                            if (data.status==="success")
                                            {
                                                gridCart.html(data.div_gridcart);
                                                taskCart.show();
                                                taskCart.html(data.div_paymentcart); 
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
        )));
    ?>
    
    <?php echo TbHtml::linkButton('',array(
        'color'=>TbHtml::BUTTON_COLOR_INFO,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'glyphicon-hand-up white',
        'url'=>$this->createUrl('Item/SelectItemRecv/'),
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t('app','Select Items'),
    )); ?>
        
<?php $this->endWidget(); ?>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('setFocus', '$("#ReceivingItem_item_id").select2("open");'); ?>

<?php /*
    if (Yii::app()->receivingCart->getMode()=='receive')
    {
        Yii::app()->clientScript->registerScript('setToggle', '$(".btn-receive").button("toggle");');
    }
    else
        Yii::app()->clientScript->registerScript('setToggleReturn', '$(".btn-return").button("toggle");');
    * 
    */
?>

<script>
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return (charCode<=31 ||  charCode==46 || (charCode>=48 && charCode<=57));
}
</script>

<?php //http://ains.co/blog/yii-javascript-createurl.html
    Yii::app()->clientScript->registerScript( 'searchItem', "
        jQuery( function($){
            $('#ReceivingItem_item_id').on('change', function(e) {
                e.preventDefault();
                var remote = $('#ReceivingItem_item_id');
                var item_id=remote.val();
                var gridCart=$('#grid_cart');
                $.ajax({url : remote.data('url'),
                        dataType : 'json',
                        data : {item_id : item_id},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    $('#task_cart').html(data.div_taskcart);
                                    remote.select2('data',null);
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
    Yii::app()->clientScript->registerScript( 'deleteItem', "
        jQuery( function($){
            $('div#grid_cart').on('click','a.delete-item',function(e) {
                e.preventDefault();
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
                                    $('#task_cart').html(data.div_taskcart);
                                    $('#ReceivingItem_item_id').select2('open');
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
                var expireDate=$('#expiredate_'+ item_id).val();
                var gridCart=$('#grid_cart');
                var message=$('.message');
                var supplierCart=$('#supplier_cart');
                if (typeof expireDate == 'undefined') {
                    expireDate=('#expiredate_'+ item_id + 'option:selected').text();
                }
                $.ajax({
                        url: 'EditItem',
                        dataType : 'json',
                        data : {item_id : item_id, quantity : quantity, discount : discount, price : price, expireDate : expireDate},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                     message.hide();
                                     gridCart.html(data.div_gridcart);
                                     $('#task_cart').html(data.div_taskcart);
                                     $('#ReceivingItem_item_id').select2('open');
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
    Yii::app()->clientScript->registerScript( 'expireDateOption', "
        jQuery( function($){
            $('div#grid_cart').on('change','.expiredate',function(e) {
                e.preventDefault();
                var item_id=$(this).data('id');
                var quantity=$('#quantity_'+ item_id).val();
                var price=$('#price_'+ item_id).val();
                var discount=$('#discount_'+ item_id).val();
                var expireDate=$(this).val();
                var gridCart=$('#grid_cart');
                $.ajax({url: 'EditItem',
                        dataType : 'json',
                        data : {item_id : item_id, quantity : quantity, discount : discount, price : price, expireDate : expireDate},
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
    Yii::app()->clientScript->registerScript( 'removeSupplier', "
        jQuery( function($){
            $('#supplier_cart').on('click','a.detach-customer', function(e) {
                e.preventDefault();
                var supplierCart=$('#supplier_cart');
                $.ajax({url: 'RemoveSupplier',
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    //supplierCart.html(data.div_suppliercart);
                                    location.reload(true); 
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
    Yii::app()->clientScript->registerScript( 'cancelRecv', "
        jQuery( function($){
            $('#task_cart').on('click','a.cancel-recv',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to clear this transaction? All items will cleared.'))
                {
                  return false;
                }
                var url=$(this).attr('href');
                var gridCart=$('#grid_cart');
                var message=$('.message');
                var supplierCart=$('#supplier_cart');
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
                                    $('#task_cart').html(data.div_taskcart);
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
    Yii::app()->clientScript->registerScript( 'setComment', "
        jQuery( function($){
            $('#comment_content').on('change','#comment_id',function(e) {
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
    Yii::app()->clientScript->registerScript( 'completeRecv', "
        jQuery( function($){
            $('#task_cart').on('click','a.complete-recv',function(e) {
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
                            }
                            else if (data.status ==='failed')
                            {
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


<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END); ?>