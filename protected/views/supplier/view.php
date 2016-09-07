<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
	$model->id,
);
?>

<h1>View Supplier #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_name',
		'first_name',
		'last_name',
		'mobile_no',
		'address1',
		'address2',
		'city_id',
		'country_code',
		'email',
		'notes',
	),
)); ?>
