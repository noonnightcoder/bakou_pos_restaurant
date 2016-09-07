<?php
/* @var $this ItemExpireController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Item Expires',
);

$this->menu=array(
	array('label'=>'Create ItemExpire','url'=>array('create')),
	array('label'=>'Manage ItemExpire','url'=>array('admin')),
);
?>

<h1>Item Expires</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>