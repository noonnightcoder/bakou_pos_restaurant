<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

        <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'created_date',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'modified_date',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
	</div>

<?php $this->endWidget(); ?>
