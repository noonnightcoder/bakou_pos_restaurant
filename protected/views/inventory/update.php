<?php
$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	$model->trans_id=>array('view','id'=>$model->trans_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Inventory','url'=>array('index')),
	array('label'=>'Create Inventory','url'=>array('create')),
	array('label'=>'View Inventory','url'=>array('view','id'=>$model->trans_id)),
	array('label'=>'Manage Inventory','url'=>array('admin')),
);
?>

<h1>Update Inventory <?php echo $model->trans_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>