<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Client','url'=>array('index')),
	array('label'=>'Create Client','url'=>array('create')),
	array('label'=>'Update Client','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Client','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Client','url'=>array('admin')),
);
?>

<h1>View Client #<?php echo $model->id; ?></h1>

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
