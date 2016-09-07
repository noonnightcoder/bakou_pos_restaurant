<?php
/* @var $this PriceTierZoneController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Price Tier Zones',
);

$this->menu=array(
	array('label'=>'Create PriceTierZone','url'=>array('create')),
	array('label'=>'Manage PriceTierZone','url'=>array('admin')),
);
?>

<h1>Price Tier Zones</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>