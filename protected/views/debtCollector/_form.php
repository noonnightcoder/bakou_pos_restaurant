<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'debt-collector-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'fullname',array('class'=>'span4','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'mobile_no',array('class'=>'span4','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'adddress1',array('class'=>'span4','maxlength'=>60)); ?>

	<?php echo $form->textFieldRow($model,'address2',array('class'=>'span4','maxlength'=>60)); ?>

	<?php //echo $form->textFieldRow($model,'city_id',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($model,'country_code',array('class'=>'span4','maxlength'=>2)); ?>

	<?php //echo $form->textFieldRow($model,'email',array('class'=>'span4','maxlength'=>30)); ?>

	<?php //echo $form->textAreaRow($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
