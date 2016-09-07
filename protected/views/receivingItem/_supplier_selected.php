<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'supplier-selected-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
        
        <?php echo TbHtml::labelTb($supplier . ' - ' . $supplier_mobile_no, array('color' => TbHtml::LABEL_COLOR_INFO)); ?>

        <?php echo TbHtml::linkButton(Yii::t( 'app', 'Detach' ),array(
            'color'=>TbHtml::BUTTON_COLOR_WARNING,
            'size'=>TbHtml::BUTTON_SIZE_MINI,
            'icon'=>'glyphicon-remove white',
            'class'=>'detach-customer',
        )); ?>
          
<?php $this->endWidget(); ?>
