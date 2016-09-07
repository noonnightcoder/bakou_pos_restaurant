<?php
$this->breadcrumbs=array(
	'Receivings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Receiving','url'=>array('index')),
	array('label'=>'Create Receiving','url'=>array('create')),
	array('label'=>'Update Receiving','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Receiving','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Receiving','url'=>array('admin')),
);
?>

<h1>View Receiving #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'receive_time',
		'client_id',
		'employee_id',
		'sub_total',
		'payment_type',
		'status',
		'remark',
	),
)); ?>
