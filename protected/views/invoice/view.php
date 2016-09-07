<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Create Invoice','url'=>array('create')),
	array('label'=>'Update Invoice','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Invoice','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Invoice','url'=>array('admin')),
);
?>

<h1>View Invoice #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'client_id',
		'invoice_number',
		'date_issued',
		'payment_term',
		'taxt1_rate',
		'tax1_desc',
		'tax2_rate',
		'tax2_desc',
		'note',
		'day_payment_due',
	),
)); ?>
