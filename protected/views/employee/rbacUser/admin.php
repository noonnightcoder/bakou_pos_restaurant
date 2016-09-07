<?php
$this->breadcrumbs=array(
	'Rbac Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RbacUser','url'=>array('index')),
	array('label'=>'Create RbacUser','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rbac-user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Rbac Users</h1>

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

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'rbac-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_name',
		'group_id',
		'employee_id',
		'user_password',
		'deleted',
		/*
		'status',
		'date_entered',
		'modified_date',
		'created_by',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
