<?php
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sale','url'=>array('index')),
	array('label'=>'Create Sale','url'=>array('create')),
	array('label'=>'View Sale','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Sale','url'=>array('admin')),
);
?>

<h1>Update Sale <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>