<?php
$this->breadcrumbs=array(
	'Giftcard'=>array('Admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Giftcard', 'url'=>array('index')),
	array('label'=>'Manage Giftcard', 'url'=>array('admin')),
);
?>


<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'Create '),
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'headerIcon' => 'ace-icon fa fa-user',
    'content' => $this->renderPartial('_form', array('model' => $model), true),
)); ?>

<?php $this->endWidget(); ?>

