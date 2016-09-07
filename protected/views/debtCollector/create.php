<?php
$this->breadcrumbs=array(
	'Debt Collectors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DebtCollector','url'=>array('index')),
	array('label'=>'Manage DebtCollector','url'=>array('admin')),
);
?>

<h1>Create DebtCollector</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>