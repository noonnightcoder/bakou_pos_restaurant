<?php
/* @var $this PriceTierController */
/* @var $model PriceTier */
?>

<?php
$this->breadcrumbs=array(
	'Price Tiers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PriceTier', 'url'=>array('index')),
	array('label'=>'Manage PriceTier', 'url'=>array('admin')),
);
?>

<h1>Create PriceTier</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>