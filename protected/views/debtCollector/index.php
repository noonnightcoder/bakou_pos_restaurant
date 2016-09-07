<?php
$this->breadcrumbs=array(
	'Debt Collectors',
);

$this->menu=array(
	array('label'=>'Create DebtCollector','url'=>array('create')),
	array('label'=>'Manage DebtCollector','url'=>array('admin')),
);
?>

<h1>Debt Collectors</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
