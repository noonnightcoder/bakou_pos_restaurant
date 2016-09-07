<?php
/* @var $this SalePaymentController */
/* @var $model SalePayment */
?>

<?php
$this->breadcrumbs=array(
	'Sale Payments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SalePayment', 'url'=>array('index')),
	array('label'=>'Create SalePayment', 'url'=>array('create')),
	array('label'=>'View SalePayment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SalePayment', 'url'=>array('admin')),
);
?>

    <h1>Update SalePayment <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>