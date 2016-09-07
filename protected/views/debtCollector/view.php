<?php
$this->breadcrumbs=array(
	'Debt Collectors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DebtCollector','url'=>array('index')),
	array('label'=>'Create DebtCollector','url'=>array('create')),
	array('label'=>'Update DebtCollector','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DebtCollector','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DebtCollector','url'=>array('admin')),
);
?>

<h1>View DebtCollector #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fullname',
		'mobile_no',
		'adddress1',
		'address2',
		'city_id',
		'country_code',
		'email',
		'notes',
	),
)); ?>
