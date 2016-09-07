<?php
$this->breadcrumbs=array(
	'Debt Collectors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DebtCollector','url'=>array('index')),
	array('label'=>'Create DebtCollector','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('debt-collector-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h4>Manage Debt Collectors</h4>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Add New',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'plus white',
    'url'=>$this->createUrl('create'),
    'htmlOptions'=>array(
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'Create New Debter' ),
    ), 
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'debt-collector-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'fullname',
		'mobile_no',
		'adddress1',
		'address2',
		//'city_id',
		/*
		'country_code',
		'email',
		'notes',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
