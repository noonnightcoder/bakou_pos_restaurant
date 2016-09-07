<div class="span9" style="float: none;margin-left: auto; margin-right: auto;">
<?php
/* @var $this ItemUnitController */
/* @var $model ItemUnit */

/*
$this->breadcrumbs=array(
	'Item Units'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ItemUnit', 'url'=>array('index')),
	array('label'=>'Create ItemUnit', 'url'=>array('create')),
);
 * 
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#item-unit-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','List of Item Unit'),
              'headerIcon' => 'icon-asterisk',
)); ?>
    
<!--
<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
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
        'data-update-dialog-title' => Yii::t('app','form.itemunit._form.header_create'),
        'data-refresh-grid-id'=>'item-unit-grid',
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'item-unit-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'unit_name',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php echo TbHtml::linkButton(Yii::t( 'app', 'form.button.addnew' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'plus white',
        'url'=>$this->createUrl('create'),
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t('app','form.itemunit._form.header_create'),
        'data-refresh-grid-id'=>'item-unit-grid',
)); ?>

<?php $this->endWidget(); ?>
</div>