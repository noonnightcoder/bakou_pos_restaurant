<?php
/* @var $this SalePaymentController */
/* @var $model SalePayment */
?>

<?php
$this->breadcrumbs=array(
	'Sale Payments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SalePayment', 'url'=>array('index')),
	array('label'=>'Create SalePayment', 'url'=>array('create')),
	array('label'=>'Update SalePayment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SalePayment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SalePayment', 'url'=>array('admin')),
);
?>

<h1>View SalePayment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'sale_id',
		'payment_type',
		'payment_amount',
		'give_away',
		'date_paid',
		'note',
		'modified_date',
	),
)); ?>