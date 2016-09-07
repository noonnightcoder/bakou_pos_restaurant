<?php
$this->breadcrumbs=array(
	'Clients',
);

$this->menu=array(
	array('label'=>'Create Client','url'=>array('create')),
	array('label'=>'Manage Client','url'=>array('admin')),
);
?>

<h1>Clients</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
