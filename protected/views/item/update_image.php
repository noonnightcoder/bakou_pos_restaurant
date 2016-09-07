<?php 
$this->breadcrumbs=array(
	'Item'=>array('admin'),
	'Update',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'Update Item'),
    'headerIcon' => 'ace-icon fa fa-coffee',
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form_image', array('model' => $model, 'price_tiers' => $price_tiers, 'item_price_promo' => $item_price_promo, 'has_error' => $has_error), true),
)); ?>

<?php $this->endWidget(); ?>