<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php //echo $form->errorSummary($model); ?>
         
        <?php echo $form->textFieldControlGroup($model,'item_number',array('maxlength'=>255,'class'=>'col-xs-10 col-sm-8')); ?>
        
	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'col-xs-10 col-sm-8','maxlength'=>50)); ?>
        
        <?php //echo $form->dropDownListControlGroup($model,'unit_id', ItemUnit::model()->getItemUnit(),array('class'=>'col-xs-10 col-sm-8 unit-type','prompt'=>'-- Select --')); ?> 
        
        <div class="unittype-wrapper" style="display:none">    
            <?php echo $form->textFieldControlGroup($model,'sub_quantity',array('class'=>'col-xs-10 col-sm-8','prepend'=>'$')); ?>
        </div>
        
        <?php //echo $form->textFieldControlGroup($model,'cost_price',array('class'=>'col-xs-10 col-sm-8')); ?>

	<?php echo $form->textFieldControlGroup($model,'unit_price',array('class'=>'col-xs-10 col-sm-8',)); ?>
        
        <?php foreach($price_tiers as $i=>$price_tier): ?>
            <div class="form-group">
                <?php echo CHtml::label($price_tier["tier_name"] . '' , $i, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
                <div class="col-sm-9">
                    <div class="col-xs-10 col-sm-8">
                    <?php echo CHtml::TextField(get_class($model) . 'Price[' . $price_tier["tier_id"] . ']',$price_tier["price"]!==null ? round($price_tier["price"],Yii::app()->shoppingCart->getDecimalPlace()) : $price_tier["price"],array('class'=>'span3 form-control')); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php //echo $form->textFieldControlGroup($model,'quantity',array('class'=>'col-xs-10 col-sm-8')); ?>

        <?php echo $form->dropDownListControlGroup($model,'category_id', Category::model()->getCategory(),array('class'=>'col-xs-10 col-sm-8','prompt'=>'-- Select --')); ?>

        <?php //echo $form->dropDownListControlGroup($model,'supplier_id', Supplier::model()->getSupplier(),array('class'=>'col-xs-10 col-sm-8','prompt'=>'-- Select --')); ?>
        
	<?php echo $form->textFieldControlGroup($model,'reorder_level',array('class'=>'col-xs-10 col-sm-8')); ?>

	<?php echo $form->textFieldControlGroup($model,'location',array('class'=>'col-xs-10 col-sm-8','maxlength'=>20)); ?>

	<?php //echo $form->textFieldControlGroup($model,'allow_alt_description',array('class'=>'col-xs-10 col-sm-8')); ?>

	<?php //echo $form->textFieldControlGroup($model,'is_serialized',array('class'=>'span4')); ?>

	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>2, 'cols'=>10, 'class'=>'col-xs-10 col-sm-8')); ?>

	<?php //echo $form->textFieldControlGroup($model,'deleted',array('class'=>'span4')); ?>

	<div class="form-actions">
                 <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php //Yii::app()->clientScript->registerScript('setFocus',  '$("#Item_item_number").focus();'); ?>
        
 <script>
 $("form").submit(function () {
      alert('form submttied ..');
      if($(this).data("allreadyInput")){
            return false;
      }else{
            $("input[type=submit]", this).hide();
            $(this).data("allreadyInput", true);
            // regular checks and submit the form here
      }
});
 
    
 $('#myModal').on('shown.bs.modal', function () {
        $('#Item_item_number').focus();
 });
 
</script>

<?php /*
    Yii::app()->clientScript->registerScript( 'unitType', "
        jQuery( function($){
            $('.unit-type').on('change', function(e) {
                e.preventDefault();
                div_unitType=$('div.unittype-wrapper');
                div_unitType.hide();
                unitType=$(this).val();
                unitTypeText=$('#Item_unit_id option:selected').text();
                
                if (unitType)
                {
                    //$('#Item_sub_quantity').before('<span class=\'add-on\'>.00</span>');
                    $('.add-on').text(unitTypeText);
                    div_unitType.show();
                }
                return false;
             });
        });
      ");
    */      
 ?>
