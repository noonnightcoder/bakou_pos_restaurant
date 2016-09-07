<?php
$this->breadcrumbs=array(
	'Suppliers',
);

$this->menu=array(
	array('label'=>'Create Supplier','url'=>array('create')),
	array('label'=>'Manage Supplier','url'=>array('admin')),
);
?>

<h1>Suppliers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
