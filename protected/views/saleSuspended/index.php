<?php
$this->breadcrumbs=array(
	'Sale Suspendeds',
);

$this->menu=array(
	array('label'=>'Create SaleSuspended','url'=>array('create')),
	array('label'=>'Manage SaleSuspended','url'=>array('admin')),
);
?>

<h1>Sale Suspendeds</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
