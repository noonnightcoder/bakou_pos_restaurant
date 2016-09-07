<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_number')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_issued')); ?>:</b>
	<?php echo CHtml::encode($data->date_issued); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_term')); ?>:</b>
	<?php echo CHtml::encode($data->payment_term); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taxt1_rate')); ?>:</b>
	<?php echo CHtml::encode($data->taxt1_rate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax1_desc')); ?>:</b>
	<?php echo CHtml::encode($data->tax1_desc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tax2_rate')); ?>:</b>
	<?php echo CHtml::encode($data->tax2_rate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax2_desc')); ?>:</b>
	<?php echo CHtml::encode($data->tax2_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('day_payment_due')); ?>:</b>
	<?php echo CHtml::encode($data->day_payment_due); ?>
	<br />

	*/ ?>

</div>