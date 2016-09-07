<?php
$this->breadcrumbs=array(
	'Sales',
);

$this->menu=array(
	array('label'=>'Create Sale','url'=>array('create')),
	array('label'=>'Manage Sale','url'=>array('admin')),
);
?>

<h1>Sales</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
