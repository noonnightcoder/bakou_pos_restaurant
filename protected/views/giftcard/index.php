<?php
/* @var $this GiftcardController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Giftcards',
);

$this->menu=array(
	array('label'=>'Create Giftcard','url'=>array('create')),
	array('label'=>'Manage Giftcard','url'=>array('admin')),
);
?>

<h1>Giftcards</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>