<?php
/* @var $this SalePaymentController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Sale Payments',
);

$this->menu=array(
	array('label'=>'Create SalePayment','url'=>array('create')),
	array('label'=>'Manage SalePayment','url'=>array('admin')),
);
?>

<h1>Sale Payments</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>