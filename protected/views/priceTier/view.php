<?php
/* @var $this PriceTierController */
/* @var $model PriceTier */
?>

<?php
$this->breadcrumbs=array(
	'Price Tiers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PriceTier', 'url'=>array('index')),
	array('label'=>'Create PriceTier', 'url'=>array('create')),
	array('label'=>'Update PriceTier', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PriceTier', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PriceTier', 'url'=>array('admin')),
);
?>

<h1>View PriceTier #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'tier_name',
		'modified_date',
		'deleted',
	),
)); ?>