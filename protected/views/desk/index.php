<?php
/* @var $this DeskController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Desks',
);

$this->menu=array(
	array('label'=>'Create Desk','url'=>array('create')),
	array('label'=>'Manage Desk','url'=>array('admin')),
);
?>

<h1>Desks</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>