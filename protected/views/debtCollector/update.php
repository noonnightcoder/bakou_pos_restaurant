<?php
$this->breadcrumbs=array(
	'Debt Collectors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DebtCollector','url'=>array('index')),
	array('label'=>'Create DebtCollector','url'=>array('create')),
	array('label'=>'View DebtCollector','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage DebtCollector','url'=>array('admin')),
);
?>

<h1>Update DebtCollector <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>