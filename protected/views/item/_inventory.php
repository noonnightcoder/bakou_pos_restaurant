<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-inventory-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

        <?php echo $form->uneditableFieldControlGroup($model,'item_number',array('class'=>'span3','maxlength'=>255)); ?>
        
	<?php echo $form->uneditableFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>50)); ?>
        
        <?php //echo $form->textFieldRow($model,'cost_price',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'unit_price',array('class'=>'span3')); ?>
        
        <?php echo $form->uneditableFieldControlGroup($model,'quantity',array('class'=>'span3','label'=>'Current Quantity')); ?>
         
        <?php //echo $form->dropDownListRow($model,'category_id', Category::model()->getCategory(),array('class'=>'span3','disabled'=>true,'prompt'=>'-- Select --')); ?>

        <?php echo $form->textFieldControlGroup($model,'items_add_minus',array('class'=>'span3')); ?>

	<?php echo $form->textAreaControlGroup($model,'inv_comment',array('rows'=>2, 'cols'=>10, 'class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'deleted',array('class'=>'span3')); ?>

	<div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
               'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
               //'size'=>TbHtml::BUTTON_SIZE_SMALL,
           )); ?>
	</div>

<?php $this->endWidget(); ?>
