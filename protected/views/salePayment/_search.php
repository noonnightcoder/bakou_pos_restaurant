<?php
/* @var $this SalePaymentController */
/* @var $model SalePayment */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'sale_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'payment_type',array('span'=>5,'maxlength'=>40)); ?>

                    <?php echo $form->textFieldControlGroup($model,'payment_amount',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'give_away',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'date_paid',array('span'=>5)); ?>

                    <?php echo $form->textAreaControlGroup($model,'note',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'modified_date',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->