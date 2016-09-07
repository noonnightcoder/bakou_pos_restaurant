<h5>View Giftcard # <?php echo $model->giftcard_number; ?></h5>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'giftcard_number',
		'discount_amount',
		'discount_type',
		'status',
		'client_id',
	),
)); ?>