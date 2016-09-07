<?php
$this->breadcrumbs=array(
	'Sale Suspendeds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SaleSuspended','url'=>array('index')),
	array('label'=>'Create SaleSuspended','url'=>array('create')),
	array('label'=>'Update SaleSuspended','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SaleSuspended','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SaleSuspended','url'=>array('admin')),
);
?>

<h1>View SaleSuspended #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sale_time',
		'client_id',
		'employee_id',
		'sub_total',
		'payment_type',
		'remark',
	),
)); ?>
