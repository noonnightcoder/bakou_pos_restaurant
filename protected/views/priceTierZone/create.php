<?php
/* @var $this PriceTierZoneController */
/* @var $model PriceTierZone */
?>

<?php
$this->breadcrumbs=array(
	'Price Tier Zones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PriceTierZone', 'url'=>array('index')),
	array('label'=>'Manage PriceTierZone', 'url'=>array('admin')),
);
?>

<h1>Create PriceTierZone</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>