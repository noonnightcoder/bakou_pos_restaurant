<?php
$this->breadcrumbs=array(
	'Receivings',
);

$this->menu=array(
	array('label'=>'Create Receiving','url'=>array('create')),
	array('label'=>'Manage Receiving','url'=>array('admin')),
);
?>

<h1>Receivings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
