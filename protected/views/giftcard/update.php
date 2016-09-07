<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */
?>

<?php
$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Giftcard', 'url'=>array('index')),
	array('label'=>'Create Giftcard', 'url'=>array('create')),
	array('label'=>'View Giftcard', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Giftcard', 'url'=>array('admin')),
);
?>

    <h1>Update Giftcard <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>