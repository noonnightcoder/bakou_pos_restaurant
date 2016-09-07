<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rbac-user-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions'=>array('data-validate'=>'parsley'),
)); ?>

        <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php //echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'user_name',array('class'=>'span5','maxlength'=>60)); ?>

	<?php //echo $form->textFieldRow($model,'group_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'employee_id',array('class'=>'span5')); ?>
        
        <?php echo $form->textFieldControlGroup($model,'PasswordOld',array('class'=>'span4','maxlength'=>128,'placeholder'=>Yii::t('app','Current Password'),'autocomplete'=>'off','data-required'=>'true')); ?>

	<?php echo $form->passwordFieldControlGroup($model,'Password',array('class'=>'span4','maxlength'=>128,'placeholder'=>Yii::t('app','New Password'),'autocomplete'=>'off','data-required'=>'true')); ?>
        
        <?php echo $form->passwordFieldControlGroup($model,'PasswordConfirm',array('class'=>'span4','maxlength'=>128, 'placeholder'=>Yii::t('app','Confirm New Password'),'autocomplete'=>'off','data-required'=>'true')); ?>

	<?php //echo $form->textFieldRow($model,'deleted',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_entered',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'modified_date',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'created_by',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
	</div>

<?php $this->endWidget(); ?>
