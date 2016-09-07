<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */
?>

<?php
$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Giftcard', 'url'=>array('index')),
	array('label'=>'Manage Giftcard', 'url'=>array('admin')),
);
?>

<h1>Create Giftcard</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>