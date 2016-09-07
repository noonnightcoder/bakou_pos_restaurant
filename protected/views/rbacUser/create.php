<?php
$this->breadcrumbs=array(
	'Rbac Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RbacUser','url'=>array('index')),
	array('label'=>'Manage RbacUser','url'=>array('admin')),
);
?>

<h1>Create RbacUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>