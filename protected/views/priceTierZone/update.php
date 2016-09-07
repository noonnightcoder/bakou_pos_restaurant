<?php
/* @var $this PriceTierZoneController */
/* @var $model PriceTierZone */
?>

<?php
$this->breadcrumbs=array(
	'Price Tier Zones'=>array('index'),
	$model->zone_id=>array('view','id'=>$model->zone_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PriceTierZone', 'url'=>array('index')),
	array('label'=>'Create PriceTierZone', 'url'=>array('create')),
	array('label'=>'View PriceTierZone', 'url'=>array('view', 'id'=>$model->zone_id)),
	array('label'=>'Manage PriceTierZone', 'url'=>array('admin')),
);
?>

    <h1>Update PriceTierZone <?php echo $model->zone_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>