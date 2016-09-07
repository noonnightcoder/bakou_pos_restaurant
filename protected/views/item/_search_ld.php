<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'item_number',array('class'=>'span4','maxlength'=>255)); ?>

	<?php //echo $form->textFieldRow($model,'category_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'cost_price',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'unit_price',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'quantity',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'reorder_level',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'location',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'allow_alt_description',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'is_serialized',array('class'=>'span5')); ?>

	<?php //echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'deleted',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
