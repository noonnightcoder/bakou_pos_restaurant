<?php
$this->breadcrumbs = array(
    'Employee' => array('admin'),
    'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'form.employee._form.header_create'),
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'headerIcon' => 'ace-icon fa fa-user',
    'content' => $this->renderPartial('_form', array('model' => $model, 'user' => $user), true),
)); ?>

<?php $this->endWidget(); ?>




