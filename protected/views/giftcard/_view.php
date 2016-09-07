<?php
/* @var $this GiftcardController */
/* @var $data Giftcard */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('giftcard_number')); ?>:</b>
	<?php echo CHtml::encode($data->giftcard_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_amount')); ?>:</b>
	<?php echo CHtml::encode($data->discount_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_type')); ?>:</b>
	<?php echo CHtml::encode($data->discount_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />


</div>