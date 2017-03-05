
<?php
$this->breadcrumbs = array(
    'Gift Card' => array('admin'),
    'Update',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'Update Gift Card') . ' : ' . '<span class="text-success bigger-120">' . $model->giftcard_number . '</span>',
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'headerIcon' => 'ace-icon fa fa-user',
    'content' => $this->renderPartial('_form', array('model' => $model), true),
)); ?>

<?php $this->endWidget(); ?>
