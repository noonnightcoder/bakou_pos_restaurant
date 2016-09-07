<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'client-account-create-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
	
    <div class="row">
        <?php echo $form->labelEx($model,'id'); ?>
        <?php echo $form->textField($model,'id'); ?>
        <?php echo $form->error($model,'id'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'sale_id'); ?>
        <?php echo $form->textField($model,'sale_id'); ?>
        <?php echo $form->error($model,'sale_id'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'item_id'); ?>
        <?php echo $form->textField($model,'item_id'); ?>
        <?php echo $form->error($model,'item_id'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'line'); ?>
        <?php echo $form->textField($model,'line'); ?>
        <?php echo $form->error($model,'line'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'quantity'); ?>
        <?php echo $form->textField($model,'quantity'); ?>
        <?php echo $form->error($model,'quantity'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'cost_price'); ?>
        <?php echo $form->textField($model,'cost_price'); ?>
        <?php echo $form->error($model,'cost_price'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'unit_price'); ?>
        <?php echo $form->textField($model,'unit_price'); ?>
        <?php echo $form->error($model,'unit_price'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'price'); ?>
        <?php echo $form->textField($model,'price'); ?>
        <?php echo $form->error($model,'price'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'discount_amount'); ?>
        <?php echo $form->textField($model,'discount_amount'); ?>
        <?php echo $form->error($model,'discount_amount'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'discount_percent'); ?>
        <?php echo $form->textField($model,'discount_percent'); ?>
        <?php echo $form->error($model,'discount_percent'); ?>
    </div>
	
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form --> 
