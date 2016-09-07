<?php
/* @var $this ZoneController */
/* @var $model Zone */
?>

<?php
$this->breadcrumbs=array(
	'Zones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Zone', 'url'=>array('index')),
	array('label'=>'Manage Zone', 'url'=>array('admin')),
);
?>

<h1>Create Zone</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>