<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_id')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_number')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_paid')); ?>:</b>
	<?php echo CHtml::encode($data->date_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_paid')); ?>:</b>
	<?php echo CHtml::encode($data->amount_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />


</div>