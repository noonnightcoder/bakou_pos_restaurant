<?php
/* @var $this LocationController */
/* @var $model Location */
?>

<?php
$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	'Create',
);

?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Create Branch'),
              'headerIcon' => 'ace-icon fa fa-home',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array('model'=>$model), true),
 )); ?>  

<?php $this->endWidget(); ?>
