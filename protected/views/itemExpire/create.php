<?php
/* @var $this ItemExpireController */
/* @var $model ItemExpire */
?>

<?php
$this->breadcrumbs=array(
	'Item Expires'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ItemExpire', 'url'=>array('index')),
	array('label'=>'Manage ItemExpire', 'url'=>array('admin')),
);
?>

<h1>Create ItemExpire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>