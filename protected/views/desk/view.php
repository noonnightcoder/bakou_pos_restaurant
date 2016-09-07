<?php
/* @var $this DeskController */
/* @var $model Desk */
?>

<?php
$this->breadcrumbs=array(
	'Desks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Desk', 'url'=>array('index')),
	array('label'=>'Create Desk', 'url'=>array('create')),
	array('label'=>'Update Desk', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Desk', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Desk', 'url'=>array('admin')),
);
?>

<h1>View Desk #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'name',
		'zone_id',
		'sort_order',
		'modified_date',
	),
)); ?>