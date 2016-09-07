<?php
$this->breadcrumbs=array(
	'Rbac Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RbacUser','url'=>array('index')),
	array('label'=>'Create RbacUser','url'=>array('create')),
	array('label'=>'View RbacUser','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage RbacUser','url'=>array('admin')),
);
?>

<h1>Update RbacUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>