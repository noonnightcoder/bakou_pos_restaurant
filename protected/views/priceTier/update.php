<?php
/* @var $this PriceTierController */
/* @var $model PriceTier */
?>

<?php
$this->breadcrumbs=array(
	'Price Tiers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PriceTier', 'url'=>array('index')),
	array('label'=>'Create PriceTier', 'url'=>array('create')),
	array('label'=>'View PriceTier', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PriceTier', 'url'=>array('admin')),
);
?>

    <h1>Update PriceTier <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>