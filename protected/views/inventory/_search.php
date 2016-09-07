<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'trans_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'trans_items',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'trans_user',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'trans_date',array('class'=>'span3')); ?>

	<?php //echo $form->textAreaRow($model,'trans_comment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'trans_inventory',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
