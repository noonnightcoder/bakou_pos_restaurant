<?php
$this->breadcrumbs=array(
	'App Configs'=>array('index'),
	$model->key,
);

$this->menu=array(
	array('label'=>'List AppConfig','url'=>array('index')),
	array('label'=>'Create AppConfig','url'=>array('create')),
	array('label'=>'Update AppConfig','url'=>array('update','id'=>$model->key)),
	array('label'=>'Delete AppConfig','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AppConfig','url'=>array('admin')),
);
?>

<h1>View AppConfig #<?php echo $model->key; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'key',
		'value',
	),
)); ?>
