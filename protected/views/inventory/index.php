<?php
$this->breadcrumbs=array(
	'Inventories',
);

$this->menu=array(
	array('label'=>'Create Inventory','url'=>array('create')),
	array('label'=>'Manage Inventory','url'=>array('admin')),
);
?>

<h1>Inventories</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
