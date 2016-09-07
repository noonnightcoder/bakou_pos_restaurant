<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Item','url'=>array('index')),
	array('label'=>'Create Item','url'=>array('create')),
	array('label'=>'Update Item','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Item','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Item','url'=>array('admin')),
);
?>

<h1>View Item #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'item_number',
		'category_id',
		'supplier_id',
		'cost_price',
		'unit_price',
		'quantity',
		'reorder_level',
		'location',
		'allow_alt_description',
		'is_serialized',
		'description',
		'deleted',
	),
)); ?>
