<?php
/* @var $this ItemUnitController */
/* @var $model ItemUnit */
?>

<?php
$this->breadcrumbs=array(
	'Item Units'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ItemUnit', 'url'=>array('index')),
	array('label'=>'Manage ItemUnit', 'url'=>array('admin')),
);
?>

<h1>Create ItemUnit</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>