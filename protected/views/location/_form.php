<?php
/* @var $this LocationController */
/* @var $model Location */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'id'=>'location-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'name',array('span'=>5,'maxlength'=>100)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'name_kh',array('span'=>5,'maxlength'=>100)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'loc_code',array('span'=>5,'maxlength'=>10)); ?>

            <?php echo $form->textFieldControlGroup($model,'address',array('span'=>5,'maxlength'=>200)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'address1',array('span'=>5,'maxlength'=>200)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'address2',array('span'=>5,'maxlength'=>200)); ?>

            <?php echo $form->textFieldControlGroup($model,'phone',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'phone1',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'wifi_password',array('span'=>5,'maxlength'=>30)); ?>

            <?php echo $form->textFieldControlGroup($model,'email',array('span'=>5,'maxlength'=>30)); ?>

            <?php echo $form->textFieldControlGroup($model,'vat',array('span'=>5,'maxlength'=>5)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'printer_food',array('span'=>5,'maxlength'=>30)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'printer_beverage',array('span'=>5,'maxlength'=>30)); ?>
    
            <?php echo $form->textFieldControlGroup($model,'printer_receipt',array('span'=>5,'maxlength'=>30)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->