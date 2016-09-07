<?php
/* @var $this LocationController */
/* @var $model Location */
?>

<?php
$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Update Branch'),
              'headerIcon' => 'ace-icon fa fa-home',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array('model'=>$model), true),
 )); ?>  

<?php $this->endWidget(); ?>
