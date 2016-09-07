<?php
/*
$this->breadcrumbs=array(
	'Invoice Payments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List InvoicePayment','url'=>array('index')),
	array('label'=>'Create InvoicePayment','url'=>array('create')),
);
 * 
*/

/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('invoice-payment-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
 * 
*/
?>

<h4> Invoice - <?php echo $invoice_number; ?> </h4> 

<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Add Payment',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'heart white',
    'url'=>$this->createUrl('create',array('invoice_id'=>$invoice_id,'invoice_number'=>$invoice_number)),
    'htmlOptions'=>array(
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'Enter Payment' ),
    ), 
)); ?>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Back to Invoice',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'backward',
    'url'=>$this->createUrl('invoice/admin'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'invoice-payment-grid',
	'dataProvider'=>$model->search($invoice_id),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'invoice_id',
                'date_paid',
		'invoice_number',
		'amount_paid',
                'give_away',
		'note',
		/*
		'modified_date',
		*/
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'template'=>'{update}{delete}{payment}',
                      'buttons' => array(
                          'update' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Update Invoice',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Update Invoice' ),
                              ), 
                          ),
                       ),
                 ),
	),
)); ?>
