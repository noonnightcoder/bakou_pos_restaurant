<?php
$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	$model->trans_id,
);

$this->menu=array(
	array('label'=>'List Inventory','url'=>array('index')),
	array('label'=>'Create Inventory','url'=>array('create')),
	array('label'=>'Update Inventory','url'=>array('update','id'=>$model->trans_id)),
	array('label'=>'Delete Inventory','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->trans_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Inventory','url'=>array('admin')),
);
?>

<h1>View Inventory #<?php echo $model->trans_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'trans_id',
		'trans_items',
		'trans_user',
		'trans_date',
		'trans_comment',
		'trans_inventory',
	),
)); ?>
