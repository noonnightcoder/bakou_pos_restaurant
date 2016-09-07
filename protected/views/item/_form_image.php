<?php //Yii::app()->clientScript->scriptMap=array('jquery.js'=>false,); ?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php endif; ?>  

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php //echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldControlGroup($model,'item_number',array('class'=>'span3','maxlength'=>255)); ?>
        
	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>50)); ?>

    <?php echo $form->dropDownListControlGroup($model,'category_id', Category::model()->getCategory(),array('class'=>'span3','prompt'=>'-- Select --')); ?>
        
        <div class="unittype-wrapper" style="display:none">    
            <?php //echo $form->textFieldControlGroup($model,'sub_quantity',array('class'=>'span2','prepend'=>'$')); ?>
        </div>
        
        <?php //echo $form->textFieldControlGroup($model,'cost_price',array('class'=>'span3')); ?>

	<?php echo $form->textFieldControlGroup($model,'unit_price',array('class'=>'span3')); ?>
        
        <?php foreach($price_tiers as $i=>$price_tier): ?>
            <div class="form-group">
                <?php echo CHtml::label($price_tier["tier_name"] . '' , $i, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
                <div class="col-sm-9">
                    <?php echo CHtml::TextField(get_class($model) . 'Price[' . $price_tier["tier_id"] . ']',$price_tier["price"]!==null ? round($price_tier["price"],Yii::app()->shoppingCart->getDecimalPlace()) : $price_tier["price"],array('class'=>'span3 form-control')); ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php //echo $form->textFieldControlGroup($model,'quantity',array('class'=>'span3')); ?>
        
        <?php echo $form->textFieldControlGroup($item_price_promo,'unit_price',array('class'=>'span3')); ?>
        
        <?php //echo $form->textFieldControlGroup($model,'promo_start_date',array('class'=>'span3')); ?>
        
        <?php //echo $form->textFieldControlGroup($model,'promo_end_date',array('class'=>'span3')); ?>
        
        <div class="form-group <?php echo $has_error; ?>">
            <label class="col-sm-3 control-label" for="Item_item_number">Promotion Start</label>
            <div class="col-sm-9">
            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('model' => $item_price_promo,'attribute' =>'start_date','pluginOptions' => array('format' => 'dd/mm/yyyy'),'htmlOptions'=>array('class'=>'span3 form-control','readonly'=>true))); ?>
                <span class="help-block"> <?php echo $form->error($item_price_promo,'start_date'); ?> </span>
            </div>
        </div>
        
        <div class="form-group <?php echo $has_error; ?>">
            <label class="col-sm-3 control-label" for="Item_item_number">Promotion End</label>
            <div class="col-sm-9">
                <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('model' => $item_price_promo,'attribute' =>'end_date','pluginOptions' => array('format' => 'dd/mm/yyyy'),'htmlOptions'=>array('class'=>'span3 form-control','readonly'=>true))); ?>
                <span class="help-block"> <?php echo $form->error($item_price_promo,'end_date'); ?> </span>
            </div>
        </div>

        <?php //echo $form->dropDownListControlGroup($model,'supplier_id', Supplier::model()->getSupplier(),array('class'=>'span3','prompt'=>'-- Select --')); ?>
        
	<?php //echo $form->textFieldControlGroup($model,'reorder_level',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'location',array('class'=>'span3','maxlength'=>20)); ?>

	<?php //echo $form->textFieldControlGroup($model,'allow_alt_description',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'is_serialized',array('class'=>'span4')); ?>
        
        <?php //echo $form->fileFieldControlGroup($model, 'image'); ?>
      
	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>2, 'cols'=>10, 'class'=>'span3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'topping',array('class'=>'span3')); ?>
       
        <?php echo $form->checkBoxControlGroup($model, 'topping', array()); ?>

	<div class="form-actions">
                 <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('setFocus',  '$("#Item_item_number").focus();'); ?>

 <script>
 $("form").submit(function () {
      if($(this).data("allreadyInput")){
            return false;
      }else{
        $("input[type=submit]", this).hide();
        $(this).data("allreadyInput", true);
        // regular checks and submit the form here
      }
});

window.setTimeout(function() {
    $(".alert").fadeTo(1500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
 </script>

