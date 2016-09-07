<?php
/* @var $this ItemUnitController */
/* @var $data ItemUnit */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_name')); ?>:</b>
	<?php echo CHtml::encode($data->unit_name); ?>
	<br />


</div>