<?php
$this->breadcrumbs=array(
	'Invoice Payments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InvoicePayment','url'=>array('index')),
	array('label'=>'Create InvoicePayment','url'=>array('create')),
	array('label'=>'Update InvoicePayment','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete InvoicePayment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InvoicePayment','url'=>array('admin')),
);
?>

<h1>View InvoicePayment #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'invoice_id',
		'invoice_number',
		'date_paid',
		'amount_paid',
		'note',
		'modified_date',
	),
)); ?>
