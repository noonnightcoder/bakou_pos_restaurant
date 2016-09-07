<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions'=>array('data-validate'=>'parsley'),
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php //echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldControlGroup($model,'company_name',array('class'=>'span3','maxlength'=>60)); ?>

	<?php echo $form->textFieldControlGroup($model,'first_name',array('class'=>'span3','maxlength'=>30)); ?>

	<?php echo $form->textFieldControlGroup($model,'last_name',array('class'=>'span3','maxlength'=>30)); ?>

	<?php echo $form->textFieldControlGroup($model,'mobile_no',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textFieldControlGroup($model,'address1',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldControlGroup($model,'address2',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldControlGroup($model,'city_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'country_code',array('class'=>'span3','maxlength'=>3)); ?>

	<?php //echo $form->textFieldControlGroup($model,'email',array('class'=>'span3','maxlength'=>30)); ?>

	<?php echo $form->textAreaControlGroup($model,'notes',array('rows'=>2, 'cols'=>5, 'class'=>'span3')); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
                    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
                )); ?>
	</div>

<?php $this->endWidget(); ?>
