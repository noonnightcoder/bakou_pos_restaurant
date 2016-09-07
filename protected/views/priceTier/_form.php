<?php
/* @var $this PriceTierController */
/* @var $model PriceTier */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'id'=>'price-tier-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'tier_name',array('span'=>5,'maxlength'=>30)); ?>

            <?php //echo $form->textFieldControlGroup($model,'modified_date',array('span'=>5)); ?>

            <?php //echo $form->textFieldControlGroup($model,'deleted',array('span'=>5)); ?>

        <div class="form-actions">
                 <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
	</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->