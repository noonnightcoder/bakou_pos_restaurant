<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'payment-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

        <?php echo $form->dropDownList($model,'payment_type', InvoiceItem::itemAlias('payment_type')); ?> 
        <br><br>
        
        <?php echo TbHtml::linkButton(Yii::t( 'app', 'Add Payment' ),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'plus white',
                'url'=>$this->createUrl('Client/Create/'),
                'class'=>'update-dialog-open-link',
                 'data-update-dialog-title' => Yii::t( 'app', 'form.supplier._form.header_create' ),
         )); ?>
        
<?php $this->endWidget(); ?>
