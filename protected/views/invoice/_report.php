<div style="width:1000px; margin:0 auto;">
<?php /*
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Manage',
);
 * 
*/

$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Create Invoice','url'=>array('create')),
);


/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('invoice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
 * 
*/
?>

<h4>Reporting..</h4>

<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<!-- <div class="search-form" style="display:none"> -->
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<!-- </div> --><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Back to Invoice',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'backward',
    'url'=>$this->createUrl('invoice/admin'),
)); ?>

<div id="data">

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->dailyInvoice(),
	'columns'=>array(
                'date_issued',
                'invoice_number',
		array('name'=>'client_search',
                      'value'=>'$data->client->fullname',
                    ),
                array('name'=>'debter',
                      'value'=>array($this,"gridDebterColumn"),
                    ),    
                array('name'=>'amount',
                      'header'=>'Amount',
                      'value' =>'Yii::app()->numberFormatter->formatDecimal($data->amount)',
                      //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($model->dailyInvoiceTotalAmount(),'KHR'),  
                      'footer'=>Yii::app()->getNumberFormatter()->formatDecimal($model->dailyInvoiceTotalAmount()), 
                     ),   
                array('name'=>'give_away',
                      //'value'=>array($this,"gridGiveAwayColumn
                      'value' =>'Yii::app()->numberFormatter->formatDecimal($data->give_away)',
                      //'footer'=>Yii::app()->numberFormatter->formatCurrency($model->getTotalGiveAway($model->searchReport()->getKeys())),
                     //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($model->dailyInvoiceTotalGiveAway(),'KHR'),
                    'footer'=>Yii::app()->getNumberFormatter()->formatDecimal($model->dailyInvoiceTotalGiveAway()),
                ),      
                array('name'=>'amount_paid',
                     //'value'=>array($this,"gridPaymentColumn"),
                     'value' =>'Yii::app()->numberFormatter->formatDecimal($data->amount_paid)',
                     //'footer'=>Yii::app()->numberFormatter->formatCurrency($model->getTotalAmountPaid($model->searchReport()->getKeys())),
                    //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($model->dailyInvoiceTotalAmountPaid(),'KHR'),  
                    'footer'=>Yii::app()->getNumberFormatter()->formatDecimal($model->dailyInvoiceTotalAmountPaid()),
                ),           
                array('name'=>'outstanding',
                      //'value'=>array($this,"gridOutstandingColumn"),
                      'value' =>'Yii::app()->numberFormatter->formatDecimal($data->outstanding)',
                      'footer'=>Yii::app()->getNumberFormatter()->formatDecimal($model->dailyInvoiceTotalOutstanding()),
                     //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($model->dailyInvoiceTotalOutstanding(),'KHR'),  
                      //'footer'=>Yii::app()->numberFormatter->formatCurrency($model->getTotalOutstanding($model->searchReport()->getKeys())),
                ),
	),
)); ?>

</div>

</div>
