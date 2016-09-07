<?php
/* @var $this PriceTierZoneController */
/* @var $data PriceTierZone */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('zone_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->zone_id),array('view','id'=>$data->zone_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_tier_id')); ?>:</b>
	<?php echo CHtml::encode($data->price_tier_id); ?>
	<br />


</div>