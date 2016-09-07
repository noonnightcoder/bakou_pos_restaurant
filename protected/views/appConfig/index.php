<?php
$this->breadcrumbs=array(
	'App Configs',
);

$this->menu=array(
	array('label'=>'Create AppConfig','url'=>array('create')),
	array('label'=>'Manage AppConfig','url'=>array('admin')),
);
?>

<h1>App Configs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
