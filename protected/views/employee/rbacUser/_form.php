<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rbac-user-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($user); ?>

	<?php echo $form->textFieldRow($user,'user_name',array('class'=>'span4','maxlength'=>60,'placeholder'=>'User ame', 'autocomplete'=>'off')); ?>
        
        <?php echo $form->passwordFieldRow($user,'user_password',array('class'=>'span4','maxlength'=>128,'placeholder'=>'User Password','autocomplete'=>'off')); ?>
        
        <?php echo $form->passwordFieldRow($user,'PasswordConfirm',array('class'=>'span4','maxlength'=>128, 'placeholder'=>'Password Confirm','autocomplete'=>'off')); ?>

	<?php //echo $form->textFieldRow($user,'group_id',array('class'=>'span4')); ?>
        
	<?php //echo $form->textFieldRow($user,'employee_id',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($user,'deleted',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($user,'status',array('class'=>'span4')); ?>
        
        <?php //echo $form->checkBoxRow($user, 'status'); ?>

	<?php //echo $form->textFieldRow($user,'date_entered',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($user,'modified_date',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($user,'created_by',array('class'=>'span4')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$user->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
