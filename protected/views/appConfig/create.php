<?php
$this->breadcrumbs=array(
	'App Configs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AppConfig','url'=>array('index')),
	array('label'=>'Manage AppConfig','url'=>array('admin')),
);
?>

<h1>Create AppConfig</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>