<?php
$this->breadcrumbs=array(
	'Sale Suspendeds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SaleSuspended','url'=>array('index')),
	array('label'=>'Manage SaleSuspended','url'=>array('admin')),
);
?>

<h1>Create SaleSuspended</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>