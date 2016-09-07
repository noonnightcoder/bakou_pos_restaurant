<?php
$this->breadcrumbs=array(
	'Invoices',
);

$this->menu=array(
	array('label'=>'Create Invoice','url'=>array('create')),
	array('label'=>'Manage Invoice','url'=>array('admin')),
);
?>

<h1>Invoices</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
