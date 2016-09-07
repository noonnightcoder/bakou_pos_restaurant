<?php
$this->breadcrumbs=array(
	'Rbac Users',
);

$this->menu=array(
	array('label'=>'Create RbacUser','url'=>array('create')),
	array('label'=>'Manage RbacUser','url'=>array('admin')),
);
?>

<h1>Rbac Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
