<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('supplier-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','form.supplier.admin.header_title'),
              'headerIcon' => 'menu-icon fa fa-users',
));?> 

<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php echo TbHtml::linkButton(Yii::t( 'app', 'form.button.addnew' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'plus white',
        'url'=>$this->createUrl('create'),
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'form.supplier._form.header_create' ),
        'data-refresh-grid-id'=>'supplier-grid',
)); ?>


<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'supplier-grid',
        'fixedHeader' => true,
        'headerOffset' => 40,
        //'responsiveTable' => true,
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'company_name',
		'first_name',
		'last_name',
                array('name'=>'mobile_no',
                      'headerHtmlOptions'=>array('class'=>'hidden-480 hidden-xs'),
                      'htmlOptions'=>array('class' => 'hidden-480 hidden-xs'),
                ),
                array('name'=>'address1',
                      'headerHtmlOptions'=>array('class'=>'hidden-480 hidden-xs'),
                      'htmlOptions'=>array('class' => 'hidden-480 hidden-xs'),
                ), 
                //'address2',
		/*
		'city_id',
		'country_code',
		'email',
		'notes',
		*/
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'template'=>'{update}{delete}{payment}',
                      'buttons' => array(
                          'update' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Update Supplier',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app','form.supplier._form.header_update'),
                                'data-refresh-grid-id'=>'supplier-grid',
                              ), 
                          ),
                       ),
                ),
	),
)); ?>

<?php $this->endWidget(); ?>
