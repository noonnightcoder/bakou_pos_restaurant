<?php
/* @var $this SalePaymentController */
/* @var $model SalePayment */
?>

<?php
$this->breadcrumbs=array(
	'Sale Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SalePayment', 'url'=>array('index')),
	array('label'=>'Manage SalePayment', 'url'=>array('admin')),
);
?>

<h1>Create SalePayment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>