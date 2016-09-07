<?php
/* @var $this DeskController */
/* @var $model Desk */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'id'=>'desk-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,    
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'name',array('span'=>5,'maxlength'=>15)); ?>

            <?php echo $form->dropDownListControlGroup($model,'zone_id', Zone::model()->getZone(),array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'sort_order',array('span'=>5)); ?>

            <?php //echo $form->textFieldControlGroup($model,'modified_date',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScript('setFocus',  '$("#Desk_name").focus();'); ?>