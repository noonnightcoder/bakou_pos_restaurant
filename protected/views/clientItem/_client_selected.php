<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'client-selected-form',
        'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
 
         <?php //echo TbHtml::labelTb(ucwords($customer) . ' - ' . $customer_mobile_no, array('color' => TbHtml::LABEL_COLOR_INFO)); ?>

          <?php echo TbHtml::lead(ucwords($customer) . ' - ' . $customer_mobile_no); ?>

         <?php echo TbHtml::linkButton(Yii::t( 'app', 'Detach' ),array(
            'color'=>TbHtml::BUTTON_COLOR_WARNING,
            'size'=>TbHtml::BUTTON_SIZE_MINI,
            'icon'=>'remove white',
            'class'=>'detach-customer',
        )); ?>
            
<?php $this->endWidget(); ?>
