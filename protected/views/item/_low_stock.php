<?php
$this->breadcrumbs=array(
	'Item'=>array('admin'),
        'List',
);?>
<div class="row">
<!-- <div class="span10 offset2"> -->
<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('low-stock-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Low Inventory'),
              'headerIcon' => 'icon-beaker',
)); ?>


<?php echo CHtml::link('Search','#',array('class'=>'search-button btn btn-medium')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'low-stock-grid',
        'fixedHeader' => true,
        //'headerOffset' => 40,
        'responsiveTable' => true,
	'dataProvider'=>$model->lowStock(),
        'summaryText' =>'', 
	//'filter'=>$model,
	'columns'=>array(
                array(
                    'header'=>'ID',
                    'value'=>'$row+1',
                ),
		//'id',
		'item_number',  
                'name',
                'description',
                //'location',
                /*
		array('name' => 'category_id',
                      'value' => '$data->category_id==null? " " : $data->category->name',
                ),
                 * 
                */ 
		array('name'=>'supplier_id',
                      'value'=>'($data->supplier_id==null || $data->supplier_id==0)? "N/A" : $data->supplier->company_name . " - " . $data->supplier->mobile_no'
                ),
		'cost_price',
                //'unit_price',
                'quantity',
                'reorder_level',
	),
)); ?>

<?php $this->endWidget(); ?>

</div>
</div>