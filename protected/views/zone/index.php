<?php
/* @var $this ZoneController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Zones',
);

$this->menu=array(
	array('label'=>'Create Zone','url'=>array('create')),
	array('label'=>'Manage Zone','url'=>array('admin')),
);
?>

<h1>Zones</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>