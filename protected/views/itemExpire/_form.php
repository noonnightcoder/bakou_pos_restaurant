<?php
/* @var $this ItemExpireController */
/* @var $model ItemExpire */
/* @var $form TbActiveForm */
?>

<div class="form container">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'item-expire-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'item_id',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'mfd_date',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'exp_date',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'received_date',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'created_date',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'modified_date',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'employee_id',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->