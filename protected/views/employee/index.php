<?php
$this->breadcrumbs=array(
	'Employees',
);

$this->menu=array(
	array('label'=>'Create Employee','url'=>array('create')),
	array('label'=>'Manage Employee','url'=>array('admin')),
);
?>

<h1>Employees</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
