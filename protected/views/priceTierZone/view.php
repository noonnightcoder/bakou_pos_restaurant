<?php
/* @var $this PriceTierZoneController */
/* @var $model PriceTierZone */
?>

<?php
$this->breadcrumbs=array(
	'Price Tier Zones'=>array('index'),
	$model->zone_id,
);

$this->menu=array(
	array('label'=>'List PriceTierZone', 'url'=>array('index')),
	array('label'=>'Create PriceTierZone', 'url'=>array('create')),
	array('label'=>'Update PriceTierZone', 'url'=>array('update', 'id'=>$model->zone_id)),
	array('label'=>'Delete PriceTierZone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->zone_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PriceTierZone', 'url'=>array('admin')),
);
?>

<h1>View PriceTierZone #<?php echo $model->zone_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'zone_id',
		'price_tier_id',
	),
)); ?>