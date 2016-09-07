<div class="row">
   <div class="col-xs-12 widget-container-col ui-sortable">
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','form.employee.admin.header_title'),
              'headerIcon' => 'ace-icon fa fa-users',
));?> 

<?php 
$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo TbHtml::linkButton(Yii::t( 'app', 'form.button.addnew' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'glyphicon-plus white',
        'url'=>$this->createUrl('create'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'employee-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
                array('name'=>'login_id',
                      'header'=> 'Login ID',
                      'value' =>array($this,"gridLoginIDColumn"),
                ),
		'first_name',
		'last_name',
		'mobile_no',
                array('name'=>'adddress1',
                      'headerHtmlOptions'=>array('class'=>'hidden-480 hidden-xs'),
                      'htmlOptions'=>array('class' => 'hidden-480 hidden-xs'),
                ), 
                array('name'=>'address2',
                      'headerHtmlOptions'=>array('class'=>'hidden-480 hidden-xs'),
                      'htmlOptions'=>array('class' => 'hidden-480 hidden-xs'),
                ),
		/*
		'city_id',
		'country_code',
		'email',
		'notes',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        /*
                        'buttons' => array(
                          'update' => array(
                            'label'=>'Update Invoice',
                            'url'=>'Yii::app()->createUrl("employee/update/",array("id"=>$data->id,"user_id"=>$data->user_id))', 
                          ),
                        ),
                         * 
                        */
		),
	),
)); ?>

<?php $this->endWidget(); ?>
   </div>
</div>
