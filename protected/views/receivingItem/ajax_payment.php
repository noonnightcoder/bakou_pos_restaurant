<?php if ( $count_item<>0 ) { ?>    
        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                 'title' => Yii::t('app','form.sale.payment_title'),
                 'headerIcon' => 'glyphicon-heart',
         ));?>   
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                       'id'=>'payment-form',
                       'enableAjaxValidation'=>false,
                       'layout'=>TbHtml::FORM_LAYOUT_INLINE,
               )); ?>

                 <div class="dl-horizontal" align="right">
                       <dt><?php echo Yii::t('app','Quantity'); ?> :</dt><dd><?php echo $count_item;  ?></dd>
                       <dt><?php echo Yii::t('app','Total'); ?> :</dt><dd><span class="label label-info"><?php echo '$'. $total;  ?></span></dd>
                 </div>

                 <!--
                 <div align="right">
                     <?php //echo $form->dropDownList($model,'payment_type', InvoiceItem::itemAlias('payment_type'),array('class'=>'span2','id'=>'payment_type_id')); ?> 
                 </div>
                 <div align="right">
                     <?php //echo $form->textField($model,'payment_amount',array('class'=>'span2','value'=>$amount_due,'style'=>'text-align: right','maxlength'=>10,'id'=>'payment_amount_id')); ?>
                 </div><br>
                 -->
               
                <?php
                // Only show this part if there is at least one payment entered.
                if($count_payment > 0)
                {
                ?>
                 <table class="table">
                   <thead>
                       <tr> <th>Type</th><th>Amount</th></tr>
                   </thead>
                   <tbody id="payment_content">
                       <?php foreach($payments as $id=>$payment):  ?>
                       <tr>
                           <td><?php echo $payment['payment_type']; ?></td>
                           <td><?php echo $payment['payment_amount']; ?></td>
                           <!--
                           <td><a class='delete' title='Cancel Payment' rel='tooltip' href='#'><i class='icon-remove'></i></a></td>
                           -->
                           <td>
                           <?php $this->widget('bootstrap.widgets.TbButton', array(
                                   'type'=>'link',
                                   'url'=>array('DeletePayment','payment_id'=>$payment['payment_type']), //Yii::app()->createUrl('SaleItem/DeleteItem',array('item_id'=>$id))
                                   'size'=>'mini', 
                                   'icon'=>'glyphicon-remove',
                                   'htmlOptions'=>array('rel'=>'tooltip','title'=>'remove payment','class'=>'delete-payment',)
                           )); ?>
                           </td>
                       </tr>
                       <?php endforeach; ?>
                   </tbody>
                 </table>
                <?php } ?>

                 <div id="comment_content" align="right">
                  <?php echo $form->textArea($model,'comment',array('rows'=>2, 'cols'=>20,'class'=>'col-sm-5','maxlength'=>250,'id'=>'comment_id')); ?>
                 </div> <br>
                 <?php //if ($count_payment>0) { ?>
                 <div align="right">
                 <?php echo TbHtml::linkButton(Yii::t('app','Finish'),array(
                        'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                        'icon'=>'glyphicon-off white',
                        'url'=>Yii::app()->createUrl('ReceivingItem/CompleteRecv/'),
                        'class'=>'complete-recv',
                        'title' => Yii::t( 'app', 'Complete' ),
                 )); ?>        
                 </div>    
                 <?php //} ?>
              <?php $this->endWidget(); ?>
         <?php $this->endWidget(); ?> <!--/endpaymentwidget-->
 <?php } ?>  