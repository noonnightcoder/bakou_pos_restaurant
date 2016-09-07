<?php
/* @var $this ZoneController */
/* @var $model Zone */
?>


<!-- <h1>View Zone #<?php //echo $model->id; ?></h1> -->

<h5>View Zone : <?php echo $model->zone_name; ?></h5>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'zone_name',
		'modified_date',
	),
)); ?>