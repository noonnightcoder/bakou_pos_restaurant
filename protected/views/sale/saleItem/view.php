<?php
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Sale','url'=>array('index')),
	array('label'=>'Create Sale','url'=>array('create')),
	array('label'=>'Update Sale','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Sale','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sale','url'=>array('admin')),
);
?>

<h1>View Sale #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sale_time',
		'customer_id',
		'employee_id',
		'sub_total',
		'payment_type',
		'remark',
	),
)); ?>
