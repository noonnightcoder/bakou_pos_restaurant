<?php
$this->breadcrumbs=array(
	'Sale Suspendeds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SaleSuspended','url'=>array('index')),
	array('label'=>'Create SaleSuspended','url'=>array('create')),
	array('label'=>'View SaleSuspended','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SaleSuspended','url'=>array('admin')),
);
?>

<h1>Update SaleSuspended <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>