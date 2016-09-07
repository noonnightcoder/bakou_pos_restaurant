<?php
$this->breadcrumbs=array(
	'Receivings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Receiving','url'=>array('index')),
	array('label'=>'Create Receiving','url'=>array('create')),
	array('label'=>'View Receiving','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Receiving','url'=>array('admin')),
);
?>

<h1>Update Receiving <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>