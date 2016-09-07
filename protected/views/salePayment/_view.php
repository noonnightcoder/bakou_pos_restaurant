<?php
/* @var $this SalePaymentController */
/* @var $data SalePayment */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_id')); ?>:</b>
	<?php echo CHtml::encode($data->sale_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_type')); ?>:</b>
	<?php echo CHtml::encode($data->payment_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_amount')); ?>:</b>
	<?php echo CHtml::encode($data->payment_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('give_away')); ?>:</b>
	<?php echo CHtml::encode($data->give_away); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_paid')); ?>:</b>
	<?php echo CHtml::encode($data->date_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	*/ ?>

</div>