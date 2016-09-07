<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->trans_id),array('view','id'=>$data->trans_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_items')); ?>:</b>
	<?php echo CHtml::encode($data->trans_items); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_user')); ?>:</b>
	<?php echo CHtml::encode($data->trans_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_date')); ?>:</b>
	<?php echo CHtml::encode($data->trans_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_comment')); ?>:</b>
	<?php echo CHtml::encode($data->trans_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_inventory')); ?>:</b>
	<?php echo CHtml::encode($data->trans_inventory); ?>
	<br />


</div>