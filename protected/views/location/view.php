<?php
/* @var $this LocationController */
/* @var $model Location */
?>

<?php
$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	$model->name,
);

?>

<h4>View Location #<?php echo $model->name; ?></h4>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'name',
		'address',
		'phone',
		'phone1',
		'fax',
		'email',
	),
)); ?>