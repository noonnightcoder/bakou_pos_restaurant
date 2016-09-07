<?php
/* @var $this DeskController */
/* @var $model Desk */
?>

<?php
$this->breadcrumbs=array(
	'Desks'=>array('admin'),
	'Create',
);

?>

<h1>Create Table</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>