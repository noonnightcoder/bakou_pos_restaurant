<?php
/*
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Manage Invoice','url'=>array('admin')),
);
 * 
*/
?>
<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Create Invoice','icon'=>'icon-user', 'url'=>'#', 'active'=>true),
    ),
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>