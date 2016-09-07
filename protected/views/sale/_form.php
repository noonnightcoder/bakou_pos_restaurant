<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sale-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldControlGroup($model,'sale_time',array('span'=>3,'readonly'=>'true')); ?>

	<?php //echo $form->textFieldControlGroup($model,'client_id',array('span'=>3)); ?>
        
        <?php echo $form->dropDownListControlGroup($model,'client_id', Client::model()->getCustomer(),array('span'=>'3','prompt'=>'-- Select --')); ?>

	<?php //echo $form->textFieldControlGroup($model,'employee_id',array('span'=>3,'readonly'=>'true')); ?>

	<?php echo $form->textFieldControlGroup($model,'sub_total',array('span'=>3,'readonly'=>'true')); ?>

	<?php //echo $form->textFieldRow($model,'payment_type',array('class'=>'span5','maxlength'=>255)); ?>

	<?php //echo $form->textAreaRow($model,'remark',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
	</div>

<?php $this->endWidget(); ?>
