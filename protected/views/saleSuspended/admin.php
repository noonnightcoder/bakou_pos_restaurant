<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' =>'Suspended Sales',
              'headerIcon' => 'icon-pause',
));?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sale-suspended-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<!-- <div class="search-form" style="display:none"> -->
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<!-- </div><!-- search-form -->

<?php echo TbHtml::linkButton(Yii::t( 'app', 'Return Sale' ),array(
    'color'=>TbHtml::BUTTON_COLOR_INFO,
    'size'=>TbHtml::BUTTON_SIZE_SMALL,
    'icon'=>'white undo',
    'url'=>$this->createUrl('SaleItem/index'), 
)); ?> 

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sale-suspended-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'sale_time',
		array('name'=>'client_id',
                      'value'=>'($data->client_id == null) ? "" : $data->client->first_name . " " . $data->client->last_name',
                ),
                array('name'=>'employee_id',
                      'value'=>'($data->employee_id == null) ? "" : $data->employee->first_name . " " . $data->employee->last_name',
                ),
		//'employee_id',
		'sub_total',
                array('name'=>'unsuspend',
                      'value'=>'CHtml::link("Unsuspend", Yii::app()->createUrl("SaleItem/UnsuspendSale",array("sale_id"=>$data->primaryKey)), 
                                array("class"=>"btn btn-info btn-small"))',
                      'type'=>'raw',
                ),
		//'payment_type',
		/*
		'remark',
		*/
		array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{delete}',
		),
                
	),
)); ?>

<?php $this->endWidget(); ?>

</div>