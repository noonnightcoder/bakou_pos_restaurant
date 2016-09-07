<?php
$this->breadcrumbs=array(
	'Receivings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Receiving','url'=>array('index')),
	array('label'=>'Manage Receiving','url'=>array('admin')),
);
?>

<h1>Create Receiving</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>