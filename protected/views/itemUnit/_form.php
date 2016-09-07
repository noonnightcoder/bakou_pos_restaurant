<?php
/* @var $this ItemUnitController */
/* @var $model ItemUnit */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'item-unit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'unit_name',array('span'=>3,'maxlength'=>50)); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->