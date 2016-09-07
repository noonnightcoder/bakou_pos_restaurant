<?php
/*
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	//'Manage',
);
 * 
*/
?>
<div>
<span style="font-size:20px;"> Sale Register </span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Suspended Sale',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    //'icon'=>'plus white',
    'url'=>$this->createUrl('client/create'),
    'htmlOptions'=>array(
        //'class'=>'update-dialog-open-link',
        //'data-update-dialog-title' => Yii::t( 'app', 'New Customer' ),
    ), 
)); ?>
</div><br>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sale-item-grid',
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
