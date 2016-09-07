<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fullname',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'mobile_no',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'adddress1',array('class'=>'span5','maxlength'=>60)); ?>

	<?php echo $form->textFieldRow($model,'address2',array('class'=>'span5','maxlength'=>60)); ?>

	<?php //echo $form->textFieldRow($model,'city_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'country_code',array('class'=>'span5','maxlength'=>2)); ?>

	<?php //echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textAreaRow($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
