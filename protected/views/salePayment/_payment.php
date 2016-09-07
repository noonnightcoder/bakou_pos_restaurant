<?php
/* @var $this SalePaymentController */
/* @var $model SalePayment */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'sale-payment-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>

            <?php //echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR,''); ?>
    
            <?php //echo $form->hiddenField($model,'sale_id',array('span'=>3)); ?>

            <?php echo $form->textFieldControlGroup($model,'payment_amount',array('class'=>'input-large')); ?>

            <?php //echo $form->textFieldControlGroup($model,'give_away',array('span'=>3)); ?>
    
            <?php //echo $form->dropDownListControlGroup($model,'payment_type', InvoiceItem::itemAlias('payment_type'),array('span'=>2,'id'=>'payment_type_id')); ?> 
            
            <div class="control-group">
                <label class="control-label required" for="SalePayment_payment_amount">Date Paid</label>
                <div class="controls">
                <div class="input-append">
                    <?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
                            'model' => $model, 
                            'name'  => 'date_paid',
                            'value' => date('d-m-Y H:i:s'),
                            'pluginOptions' => array(
                                'format' => 'dd-MM-yyyy hh:mm:ss'
                            )
                        ));
                    ?>
                    <!-- <span class="add-on"><icon class="icon-calendar"></icon></span> -->
                </div> 
                </div>    
            </div>
    
            <?php //echo $form->textFieldControlGroup($model,'date_paid',array('span'=>3)); ?>

            <?php echo $form->textAreaControlGroup($model,'note',array('rows'=>2,'class'=>'input-large')); ?>

            <?php //echo $form->textFieldControlGroup($model,'modified_date',array('span'=>3)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->