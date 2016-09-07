<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

	<?php //echo $form->textFieldControlGroup($model,'id',array('class'=>'span4')); ?>

	<?php echo $form->textFieldControlGroup($model,'company_name',array('class'=>'span4','maxlength'=>60)); ?>

	<?php echo $form->textFieldControlGroup($model,'first_name',array('class'=>'span4','maxlength'=>30)); ?>

	<?php echo $form->textFieldControlGroup($model,'last_name',array('class'=>'span4','maxlength'=>30)); ?>

	<?php echo $form->textFieldControlGroup($model,'mobile_no',array('class'=>'span4','maxlength'=>20)); ?>

	<?php //echo $form->textFieldControlGroup($model,'address1',array('class'=>'span4','maxlength'=>50)); ?>

	<?php //echo $form->textFieldControlGroup($model,'address2',array('class'=>'span4','maxlength'=>50)); ?>

	<?php //echo $form->textFieldControlGroup($model,'city_id',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldControlGroup($model,'country_code',array('class'=>'span4','maxlength'=>3)); ?>

	<?php //echo $form->textFieldControlGroup($model,'email',array('class'=>'span4','maxlength'=>30)); ?>

	<?php //echo $form->textAreaControlGroup($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
	</div>

<?php $this->endWidget(); ?>
