<?php
/* @var $this ItemExpireController */
/* @var $model ItemExpire */
?>

<?php
$this->breadcrumbs=array(
	'Item Expires'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemExpire', 'url'=>array('index')),
	array('label'=>'Create ItemExpire', 'url'=>array('create')),
	array('label'=>'View ItemExpire', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ItemExpire', 'url'=>array('admin')),
);
?>

    <h1>Update ItemExpire <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>