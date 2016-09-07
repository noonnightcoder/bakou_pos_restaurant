<?php
/* @var $this ItemUnitController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Item Units',
);

$this->menu=array(
	array('label'=>'Create ItemUnit','url'=>array('create')),
	array('label'=>'Manage ItemUnit','url'=>array('admin')),
);
?>

<h1>Item Units</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>