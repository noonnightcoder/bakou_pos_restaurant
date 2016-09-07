<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

	<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldControlGroup($model,'sale_time',array('class'=>'span4')); ?>

        <?php echo $form->textFieldControlGroup($model,'client_info',array('span'=>'3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'client_firstname',array('span'=>'3')); ?>

        <?php //echo $form->textFieldControlGroup($model,'client_lastname',array('span'=>'3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'employee_id',array('span'=>'3')); ?>

	<?php //echo $form->textFieldRow($model,'sub_total',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'payment_type',array('class'=>'span5','maxlength'=>255)); ?>

	<?php //echo $form->textAreaRow($model,'remark',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
	</div>

<?php $this->endWidget(); ?>
