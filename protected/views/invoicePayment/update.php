<?php
$this->breadcrumbs=array(
	'Invoice Payments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InvoicePayment','url'=>array('index')),
	array('label'=>'Create InvoicePayment','url'=>array('create')),
	array('label'=>'View InvoicePayment','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage InvoicePayment','url'=>array('admin')),
);
?>

<h1>Update InvoicePayment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>