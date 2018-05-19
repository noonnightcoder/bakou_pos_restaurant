<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'giftcard_selected_form',
        'action'=>Yii::app()->createUrl('saleItem/RemoveGiftcard/'),
        'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
         <?php //echo TbHtml::labelTb($giftcard_info, array('color' => TbHtml::LABEL_COLOR_INFO)); ?>

        <strong>
            <?php echo TbHtml::link(ucwords($giftcard_info),$this->createUrl('giftCard/View/',array('id'=>$giftcard_id)), array(
                    'class'=>'update-dialog-open-link',
                    'data-update-dialog-title' => Yii::t('app','Gift Card Information'),
                )); ?>
        </strong> 
       
        <?php echo TbHtml::linkButton(Yii::t( 'app', '' ),array(
            'color'=>TbHtml::BUTTON_COLOR_WARNING,
            'size'=>TbHtml::BUTTON_SIZE_MINI,
            'icon'=>'glyphicon-remove white',
            'class'=>'detach-giftcard',
        )); ?>
            
<?php $this->endWidget(); ?>


