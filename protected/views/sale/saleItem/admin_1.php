<?php
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	'Manage',
);


/*
$this->menu=array(
	array('label'=>'List Sale','url'=>array('index')),
	array('label'=>'Create Sale','url'=>array('create')),
);
 * 
*/


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sale-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php /*
$this->widget('bootstrap.widgets.TbBox', array(
                    'title' => 'Customer',
                    'headerIcon' => 'icon-user',
                    'content' =>$this->renderPartial('_customer',array('model'=>$model),true),
     )); 
 */
?>

<div>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sale-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sale_time',
		'customer_id',
		'employee_id',
		'sub_total',
		'payment_type',
		/*
		'remark',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
