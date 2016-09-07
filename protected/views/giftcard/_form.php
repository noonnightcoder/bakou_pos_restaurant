<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'id'=>'giftcard-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'giftcard_number',array('span'=>5,'maxlength'=>60)); ?>

            <?php echo $form->textFieldControlGroup($model,'discount_amount',array('span'=>5,'maxlength'=>15)); ?>

            <?php //echo $form->textFieldControlGroup($model,'discount_type',array('span'=>5,'maxlength'=>2)); ?>

            <?php //echo $form->textFieldControlGroup($model,'status',array('span'=>5,'maxlength'=>1)); ?>

            <?php //echo $form->textFieldControlGroup($model,'client_id',array('span'=>5)); ?>
    
            <?php echo $form->dropDownListControlGroup($model,'client_id', Client::model()->getCustomer(),array('prompt'=>'No Customer')); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->