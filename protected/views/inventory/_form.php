<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'inventory-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'trans_items',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'trans_user',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'trans_date',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'trans_comment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'trans_inventory',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
