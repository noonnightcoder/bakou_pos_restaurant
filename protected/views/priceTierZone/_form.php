<?php
/* @var $this PriceTierZoneController */
/* @var $model PriceTierZone */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'id'=>'price-tier-zone-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php //echo $form->textFieldControlGroup($model,'zone_id',array('span'=>5)); ?>

            <?php //echo $form->textFieldControlGroup($model,'price_tier_id',array('span'=>5)); ?>
    
            <?php echo $form->dropDownListControlGroup($model,'zone_id', Zone::model()->getZone(),array('disabled'=>true)); ?>
            
            <?php echo $form->dropDownListControlGroup($model,'price_tier_id', PriceTier::model()->getPriceTier()); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->