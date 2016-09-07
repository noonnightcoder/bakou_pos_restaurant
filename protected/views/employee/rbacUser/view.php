<?php
$this->breadcrumbs=array(
	'Rbac Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RbacUser','url'=>array('index')),
	array('label'=>'Create RbacUser','url'=>array('create')),
	array('label'=>'Update RbacUser','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete RbacUser','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RbacUser','url'=>array('admin')),
);
?>

<h1>View RbacUser #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_name',
		'group_id',
		'employee_id',
		'user_password',
		'deleted',
		'status',
		'date_entered',
		'modified_date',
		'created_by',
	),
)); ?>
