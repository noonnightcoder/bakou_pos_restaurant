<?php
/* @var $this ZoneController */
/* @var $model Zone */
?>

<?php
$this->breadcrumbs=array(
	'Zones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Zone', 'url'=>array('index')),
	array('label'=>'Create Zone', 'url'=>array('create')),
	array('label'=>'View Zone', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Zone', 'url'=>array('admin')),
);
?>

    <h1>Update Zone <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>