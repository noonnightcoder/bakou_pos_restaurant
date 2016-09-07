<?php
/* @var $this SalePaymentController */
/* @var $model SalePayment */
/*
$this->breadcrumbs=array(
	'Sale Payments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SalePayment', 'url'=>array('index')),
	array('label'=>'Create SalePayment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sale-payment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 * 
*/
?>

<h1>Manage Sale Payments</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sale-payment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sale_id',
		'payment_type',
		'payment_amount',
		'give_away',
		'date_paid',
		/*
		'note',
		'modified_date',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>