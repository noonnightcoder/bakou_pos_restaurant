<?php
/* @var $this ItemUnitController */
/* @var $model ItemUnit */
?>

<?php
$this->breadcrumbs=array(
	'Item Units'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemUnit', 'url'=>array('index')),
	array('label'=>'Create ItemUnit', 'url'=>array('create')),
	array('label'=>'View ItemUnit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ItemUnit', 'url'=>array('admin')),
);
?>

    <h1>Update ItemUnit <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>