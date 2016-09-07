<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'invoice_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'invoice_number',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'date_paid',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'amount_paid',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'modified_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
