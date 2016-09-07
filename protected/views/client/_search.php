<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

	<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldControlGroup($model,'first_name',array('class'=>'col-sm-5','maxlength'=>100)); ?>

        <?php echo $form->textFieldControlGroup($model,'last_name',array('class'=>'col-sm-5','maxlength'=>100)); ?>

	<?php echo $form->textFieldControlGroup($model,'mobile_no',array('class'=>'col-sm-5','maxlength'=>15)); ?>

	<?php //echo $form->textFieldControlGroup($model,'adddress1',array('class'=>'span5','maxlength'=>60)); ?>

	<?php //echo $form->textFieldControlGroup($model,'address2',array('class'=>'span5','maxlength'=>60)); ?>

	<?php //echo $form->textFieldControlGroup($model,'city_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldControlGroup($model,'country_code',array('class'=>'span5','maxlength'=>2)); ?>

	<?php //echo $form->textFieldControlGroup($model,'email',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textAreaRow($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
	</div>

<?php $this->endWidget(); ?>
