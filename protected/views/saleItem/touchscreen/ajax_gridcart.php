<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<div class="grid-view" id="grid_cart">  
        <div class="widget-header widget-header-flat">
            <i class="ace-icon fa fa-shopping-cart"></i>
            <h5 class="widget-title">Ordering Cart</h5>
            <div class="widget-toolbar">
                <?php //if (isset($table_info)) { echo 'Table : ' . $table_info->name; } ?>
                <div class="badge badge-info">
                    <?php echo Yii::t('app','form.sale.payment_lbl_itemcart') . ' : ' .  $count_item;  ?> 
                </div>
                <?php echo TbHtml::linkButton('Merge Table',array(
                    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                    'size'=>TbHtml::BUTTON_SIZE_MINI,
                    'icon'=>'glyphicon-plus',
                    'url'=>$this->createUrl('Desk/MergeDesk/'),
                    'class'=>'update-dialog-open-link',
                    'data-update-dialog-title' => Yii::t('app','Merging Table'),
                )); ?>

               <?php echo TbHtml::linkButton('Change Table',array(
                    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                    'size'=>TbHtml::BUTTON_SIZE_MINI,
                    'icon'=>'	glyphicon-refresh',
                    'url'=>$this->createUrl('Desk/ChangeDesk/'),
                    'class'=>'update-dialog-open-link',
                    'data-update-dialog-title' => Yii::t('app','Changing Table'),
                )); ?>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
            )); ?>    
                
                <?php if (isset($table_id)) { ?>
                
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
                                    'url' => Yii::app()->createUrl('Item/getItem/',array('price_tier_id'=>$price_tier_id)), 
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
                                        /*
                                        if (more==1)
                                        {
                                            var item_id=0;
                                            $.each(data.results, function(key,value){
                                                item_id=value.id;
                                            });
                                            var gridCart=$("#grid_cart");
                                            $.ajax({url: "Index",
                                                    dataType : "json",
                                                    data : {item_id : item_id},
                                                    type : "post",
                                                    beforeSend: function() { $(".waiting").show(); },
                                                    complete: function() { $(".waiting").hide(); },
                                                    success : function(data) {
                                                            if (data.status==="success")
                                                            {
                                                                console.log($(this).attr("id"));
                                                                gridCart.html(data.div_gridcart);
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
                                        */
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

                    <?php /* echo TbHtml::linkButton('',array(
                        'color'=>TbHtml::BUTTON_COLOR_INFO,
                        'size'=>TbHtml::BUTTON_SIZE_SMALL,
                        'icon'=>'glyphicon-hand-up white',
                        'url'=>$this->createUrl('Item/SelectItem/'),
                        'class'=>'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app','Select Topping'),
                    )); */?>
                
                <?php } ?>
                
                <span class="lable">
                <?php if (isset($table_info)) { echo '<b>Serving Table : ' . $table_info->name  .' - ' . Common::GroupAlias(Yii::app()->orderingCart->getGroupId()) . '</b>';} ?>
                </span>    
                
                 <?php /* echo TbHtml::linkButton(Yii::t('app','form.button.suspendedsale'),array(
                    'color'=>TbHtml::BUTTON_COLOR_INFO,
                    'size'=>TbHtml::BUTTON_SIZE_SMALL,
                    'icon'=>'glyphicon-hand-up white',
                    'url'=>Yii::app()->createUrl('SaleSuspended/Admin/'),
                 )); */?>

                 <?php /*echo TbHtml::linkButton(Yii::t( 'app', 'New Item' ),array(
                    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                    'size'=>TbHtml::BUTTON_SIZE_MINI,
                    'icon'=>'plus white',
                    'url'=>$this->createUrl('Item/AddItem/'),
                    'class'=>'update-dialog-open-link',
                    'data-update-dialog-title' => Yii::t( 'app', 'form.client._form.header_create' ),
                )); */?> 

            <?php $this->endWidget(); ?> <!--/endformWidget--> 
            <br>

            <div class="slim-scroll" data-height="400">

                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'id'=>'sale-item-form',
                        'enableAjaxValidation'=>false,
                        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
                )); ?>
                <?php /*
                if (isset($warning))
                {
                    echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, $warning);
                } */
                ?>
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr><th><?php echo Yii::t('model','Item Code'); ?></th>
                            <th><?php echo Yii::t('model','model.saleitem.name'); ?></th>
                            <th><?php echo Yii::t('model','model.saleitem.price'); ?></th>
                            <th><?php echo Yii::t('model','model.saleitem.quantity'); ?></th>
                            <th class="<?php echo Yii::app()->settings->get('sale','discount'); ?>"><?php echo Yii::t('model','model.saleitem.discount_amount'); ?></th>
                            <th><?php echo Yii::t('model','model.saleitem.total'); ?></th>
                            <th><?php echo Yii::t('app',''); ?></th>
                        </tr>
                    </thead>
                    <tbody id="cart_contents">
                        <?php foreach($items as $id=>$item): ?>
                            <?php /*
                                if (substr($item['discount'],0,1)=='$')
                                {
                                    $total_item=number_format($item['price']*$item['quantity']-substr($item['discount'],1),Yii::app()->shoppingCart->getDecimalPlace());
                                }    
                                else  
                                {  
                                    $total_item=number_format(($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100),Yii::app()->shoppingCart->getDecimalPlace());
                                } 
                                $item_id=$item['item_id'];
                                $cur_item_info= Item::model()->findbyPk($item_id);
                                //$qty_in_stock=$cur_item_info->quantity;
                                $cur_item_unit= ItemUnitQuantity::model()->findbyPk($item_id);
                                */ 
                                $total_item=number_format($item['total'],Yii::app()->orderingCart->getDecimalPlace());
                                $item_id=$item['item_id'];
                                $item_parent_id=$item['item_parent_id'];
                                $unit_name=''; 
                            ?>
                                <tr>
                                    <td>
                                        <?php echo TbHtml::linkButton('',array(
                                               'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                                               'size'=>TbHtml::BUTTON_SIZE_MINI,
                                               'icon'=>'glyphicon-hand-up white',
                                               'url'=>$this->createUrl('Item/SelectItem/',array('item_parent_id'=>$item_id)),
                                               'class'=>'update-dialog-open-link',
                                               'data-update-dialog-title' => Yii::t('app','Select Topping'),
                                           )); ?>
                                        <?php echo $item['item_number']; ?>
                                   </td>
                                    <?php if ($item['topping']==0) { ?>
                                        <td> 
                                           <span class="text-info">
                                            <?php echo $item['name']; ?>
                                           </span>
                                            <!--<br/><span class="text-info"><?php //echo $item["qty_in_stock"] . ' ' . $unit_name .  ' ' . Yii::t('app','in stock') ?> </span> -->
                                        </td>
                                    <?php } else { ?>
                                        <td align="right"><span class="text-info orange"><?php echo $item['name']; ?></span></td>
                                    <?php } ?>
                                    <!-- <td align="right"><span class="text-info"><?php //echo $item['name']; ?></span></td> -->
                                    <td>
                                        <?php echo $form->textField($model,"[$item_id]price",array('value'=>$item['price'],'disabled' => true,'class'=>'input-small alignRight numeric readonly','id'=>"price_$item_id",'placeholder'=>'Price','data-id'=>"$item_id",'maxlength'=>50,'onkeypress'=>'return isNumberKey(event)')); ?></td>
                                    <td> 
                                        <?php echo $form->textField($model,"[$item_id]quantity",array('value'=>$item['quantity'],'class'=>'input-small alignRight numeric editable-box input-qty','id'=>"quantity_$item_id",'placeholder'=>'Quantity','data-id'=>"$item_id",'data-parentid'=>"$item_parent_id",'maxlength'=>10,'onkeypress'=>'return isNumberKey(event)')); ?>
                                    </td>
                                    <td class="<?php echo Yii::app()->settings->get('sale','discount'); ?>">
                                        <?php echo $form->textField($model,"[$item_id]discount",array('value'=>$item['discount'],'class'=>'input-small alignRight editable-box numpad','id'=>"discount_$item_id",'placeholder'=>'Discount','data-id'=>"$item_id",'maxlength'=>50)); ?></td>
                                    <td>
                                        <?php echo $form->textField($model,"[$item_id]total",array('value'=>$total_item,'disabled' => true,'class'=>'input-small alignRight numeric readonly')); ?></td>
                                        <?php //echo $total_item; ?>
                                    </td>
                                    <td>
                                        <?php echo TbHtml::linkButton('',array(
                                            'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                            'size'=>TbHtml::BUTTON_SIZE_MINI,
                                            'icon'=>'glyphicon-trash',
                                            'url'=>array('DeleteItem','item_id'=>$item_id, 'item_parent_id' => $item['item_parent_id']),
                                            'class'=>'delete-item',
                                            'title' => Yii::t( 'app', 'Remove' ),
                                        )); ?>
                                    </td>    
                                </tr>
                            <?php //$this->endWidget(); ?>  <!--/endformWidget-->     
                        <?php endforeach; ?> <!--/endforeach-->
                    </tbody>
                </table>
                <?php $this->endWidget(); ?>  <!--/endformWidget--> 

                 <?php if (empty($items)) {
                       echo Yii::t('app','There are no items in the cart');
                 } ?> 

            </div><!--/endslimscrool-->

            <div class="row">
                    <div class="col-sm-5 pull-right">
                        <h4 class="pull-right">
                            <?php echo Yii::t('app','form.sale.payment_lbl_total'); ?>
                            <span class="green"><?php echo Yii::app()->settings->get('site', 'currencySymbol') .number_format($sub_total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></span>
                        </h4>
                    </div>
                    <div class="col-sm-6 pull-right">
                         <h4 class="pull-right">
                                <?php echo Yii::t('app','Amount to Pay'); ?>
                                <span class="red"><?php echo Yii::app()->settings->get('site', 'currencySymbol') .number_format($amount_due,Yii::app()->shoppingCart->getDecimalPlace(), '.', ',');  ?></span>
                        </h4>
                    </div>    
                    <!-- <div class="col-sm-7 pull-left"> Extra Information </div> -->
            </div>
   
            <!--
            <div class="row">
                <div class="col-xs-12">
                    <div class="dl-horizontal pull-right">
                        <dt><?php //echo Yii::t('app','form.sale.payment_lbl_total'); ?> :</dt><dd><span class="infobox-data-number"><?php //echo Yii::app()->settings->get('site', 'currencySymbol') .number_format($total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></span></dd>
                        <dt><?php //echo Yii::t('app','form.sale.payment_lbl_amountdue'); ?>:</dt><dd><span class="label label-important"><?php //echo Yii::app()->settings->get('site', 'currencySymbol') .number_format($amount_due,Yii::app()->shoppingCart->getDecimalPlace(), '.', ',');  ?></span></dd>                 
                    </div>
                    <div class="span6 pull-left">
                        <?php //echo $form->textField($model,'payment_amount',array('value'=>0,'class'=>'','style'=>'text-align: right','maxlength'=>10,'id'=>'payment_amount_id','data-url'=>Yii::app()->createUrl('SaleItem/AddPayment/'),)); ?>
                        <?php  /*
                            if(isset($giftcard_info)) {
                                $this->renderPartial('touchscreen/_giftcard_selected',array('model'=>$model,'giftcard_info'=>$giftcard_info));
                            } else {
                                $this->renderPartial('touchscreen/_giftcard',array('model'=>$model)); 
                            }  
                         * 
                         */ 
                        ?>
                    </div>
                </div>
            </div>
            --> 
            
            <?php
            // Only show this part if there is at least one payment entered.
            if($count_payment > 0)
            {
            ?>
             <table class="table">
               <!--  
               <thead>
                   <tr> <th>Type</th><th>Amount</th></tr>
               </thead>
               -->
               <tbody id="payment_content">
                   <?php foreach($payments as $id=>$payment):  ?>
                   <tr>
                       <td><?php echo $payment['payment_type']; ?></td>
                       <td><?php echo Yii::app()->numberFormatter->formatCurrency(($payment['payment_amount']),Yii::app()->settings->get('site', 'currencySymbol')); ?></td>
                       <td>
                        <?php echo TbHtml::linkButton('',array(
                                'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                'size'=>TbHtml::BUTTON_SIZE_MINI,
                                'icon'=>'glyphicon-remove',
                                'url'=>Yii::app()->createUrl('SaleItem/DeletePayment',array('payment_id'=>$payment['payment_type'])),
                                'class'=>'delete-payment',
                                'title' => Yii::t( 'app', 'Delete Payment' ),
                        )); ?>     
                       </td>
                   </tr>
                   <?php endforeach; ?>
               </tbody>
             </table>
            <?php } ?>

            <?php if ( $count_item<>0 ) { ?>     
            <div class="widget-toolbox padding-8 clearfix">
                    <div class="pull-right">
                        <?php if ($count_payment>0) { ?>   
                               <?php echo TbHtml::linkButton(Yii::t('app','Print Receipt'),array(
                                   'color'=>TbHtml::BUTTON_COLOR_INFO,
                                   'size'=>TbHtml::BUTTON_SIZE_SMALL,
                                   'icon'=>'glyphicon-off white',
                                   'url'=>Yii::app()->createUrl('SaleItem/CompleteSale/'),
                                   'class'=>'complete-sale pull-right',
                                   'title' => Yii::t( 'app', 'Complete Sale' ),
                            )); ?>
                        <?php } else { ?>
                           <?php echo TbHtml::linkButton(Yii::t('app','form.sale.payment_btn_addpayment'),array(
                                  'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                                  'size'=>TbHtml::BUTTON_SIZE_SMALL,
                                  'icon'=>'glyphicon-heart white',
                                  'url'=>Yii::app()->createUrl('SaleItem/AddPayment/'),
                                  'class'=>'add-payment pull-right',
                                  'title' => Yii::t( 'app', 'Add Payment' ),
                           )); ?> 
                        <?php } ?>
                        <div style="display: none;">
                           <?php echo $form->dropDownList($model,'payment_type',InvoiceItem::itemAlias('payment_type'),array('class'=>'span2 pull-right','id'=>'payment_type_id')); ?> 
                        </div>
                        <div class="pull-right">
                        <?php echo $form->textField($model,'payment_amount',array('value'=>$amount_due,'class'=>'input-small numpad','style'=>'text-align: right','maxlength'=>10,'id'=>'payment_amount_id','data-url'=>Yii::app()->createUrl('SaleItem/AddPayment/'),)); ?>
                        </div> 
                        <div class="pull-right"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
                        <div class="pull-right">
                            <?php  
                                if(isset($giftcard_info)) {
                                    $this->renderPartial('touchscreen/_giftcard_selected',array('model'=>$model,'giftcard_info'=>$giftcard_info));
                                } else {
                                    $this->renderPartial('touchscreen/_giftcard',array('model'=>$model)); 
                                }  
                            ?>
                        </div>    
                    </div>
                    <div class="pull-left">
                     <?php /* echo TbHtml::linkButton(Yii::t('app','form.button.cancelsale'),array(
                            'color'=>TbHtml::BUTTON_COLOR_WARNING,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'glyphicon-remove white',
                            'url'=>Yii::app()->createUrl('SaleItem/CancelSale/'),
                            'class'=>'cancel-sale pull-left',
                            'title' => Yii::t( 'app', 'Void Sale' ),
                    )); */ ?> 
                    <?php  echo TbHtml::linkButton(Yii::t('app','Kitchen'),array(
                            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'glyphicon-print white',
                            'url'=>Yii::app()->createUrl('SaleItem/PrintKitchen/'),
                            'class'=>'suspend-sale pull-left',
                            'title' => Yii::t( 'app', 'Send to Kitchen' ),
                    )); ?>
                    <?php  echo TbHtml::linkButton(Yii::t('app','Customer'),array(
                            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'glyphicon-print white',
                            'url'=>Yii::app()->createUrl('SaleItem/PrintCustomer/'),
                            'class'=>'suspend-sale pull-left',
                            'title' => Yii::t( 'app', 'Print for Custmoer' ),
                    )); ?> 
                    </div>
            </div><!--/endtoolbarfooter-->
            <?php } ?> 
         </div> <!--/endwiget-main-->
      </div><!--/endwiget-body-->
</div> <!--/endgridcartdiv-->


<script type="text/javascript">
$(function() {
    $('.slim-scroll').each(function () {
             var $this = $(this);
             $this.slimScroll({
                     height: $this.data('height') || 100,
                     railVisible:true
             });
     });
     /*
     $('.numpad').keyboard({
        layout: 'num',
        restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste : true,  // prevent ctrl-v and right click
        autoAccept : false
     });
     */

    /*
    $('.numpad').keyboard({
        layout: 'custom',
        customLayout: {
         'default' : [
          '$ {bksp} {clear}',
          '7 8 9',
          '4 5 6',
          '1 2 3',
          '0 . {a} {c}'
         ]
        },
        maxLength : 6,
        restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste : true,  // prevent ctrl-v and right click
        useCombos : false // don't want A+E to become a ligature
    });
    */

});
</script>