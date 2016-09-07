<?php
/* @var $this ItemExpireController */
/* @var $data ItemExpire */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfd_date')); ?>:</b>
	<?php echo CHtml::encode($data->mfd_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exp_date')); ?>:</b>
	<?php echo CHtml::encode($data->exp_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_date')); ?>:</b>
	<?php echo CHtml::encode($data->received_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	*/ ?>

</div>