<?php
$this->breadcrumbs=array(
	'App Configs'=>array('index'),
	$model->key=>array('view','id'=>$model->key),
	'Update',
);

$this->menu=array(
	array('label'=>'List AppConfig','url'=>array('index')),
	array('label'=>'Create AppConfig','url'=>array('create')),
	array('label'=>'View AppConfig','url'=>array('view','id'=>$model->key)),
	array('label'=>'Manage AppConfig','url'=>array('admin')),
);
?>

<h1>Update AppConfig <?php echo $model->key; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>