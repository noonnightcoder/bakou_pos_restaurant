<?php
/* @var $this PriceTierController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Price Tiers',
);

$this->menu=array(
	array('label'=>'Create PriceTier','url'=>array('create')),
	array('label'=>'Manage PriceTier','url'=>array('admin')),
);
?>

<h1>Price Tiers</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>