<?php
/* @var $this DeskController */
/* @var $model Desk */
?>

<?php
$this->breadcrumbs=array(
	'Desks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Desk', 'url'=>array('index')),
	array('label'=>'Create Desk', 'url'=>array('create')),
	array('label'=>'View Desk', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Desk', 'url'=>array('admin')),
);
?>

    <h1>Update Desk <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>