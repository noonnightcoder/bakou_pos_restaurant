<?php
/* @var $this ItemExpireController */
/* @var $model ItemExpire */
?>

<?php
$this->breadcrumbs=array(
	'Item Expires'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ItemExpire', 'url'=>array('index')),
	array('label'=>'Create ItemExpire', 'url'=>array('create')),
	array('label'=>'Update ItemExpire', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ItemExpire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItemExpire', 'url'=>array('admin')),
);
?>

<h1>View ItemExpire #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'item_id',
		'mfd_date',
		'exp_date',
		'received_date',
		'created_date',
		'modified_date',
		'employee_id',
	),
)); ?>