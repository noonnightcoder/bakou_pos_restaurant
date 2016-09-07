<?php
/*
$this->breadcrumbs=array(
	'Invoice Payments'=>array('index'),
	'Create',
);
 * 
*/
?>

<?php 
    $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Create/Update Payment','icon'=>'heart', 'url'=>'#', 'active'=>true),
    ),
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>