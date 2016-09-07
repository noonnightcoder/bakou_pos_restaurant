<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'payment-form',
	'enableAjaxValidation'=>false,
        'type'=>'inline',
)); ?>

        <?php echo $form->dropDownListRow($model,'payment_type', InvoiceItem::itemAlias('payment_type')); ?> 
        <br><br>
        
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Add Payment',
            'type'=>'success',
            'size'=>'small',
            'buttonType'=>'link',
            'icon'=>'plus white',
            'url'=>Yii::app()->createUrl('Client/Create/'),
            'htmlOptions'=>array(
                'class'=>'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t( 'app', 'Create New Client' ),
            ), 
        )); ?>

<?php $this->endWidget(); ?>
