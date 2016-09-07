<?php /*
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Manage',
);
 * 
*/


/*
$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Create Invoice','url'=>array('create')),
);

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

<h4>Invoicing..</h4>

<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php /* $this->renderPartial('_form',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'New Invoice',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'glyphicon-plus white',
    'url'=>$this->createUrl('create'),
    'htmlOptions'=>array(
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'Create Invoice' ),
    ), 
)); ?>

<?php /* $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Payment',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'heart white',
    'url'=>$this->createUrl('create'),
    'htmlOptions'=>array(
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'Create Invoice' ),
    ), 
)); */ ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Create New Client',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'user white',
    'url'=>$this->createUrl('client/create'),
    'htmlOptions'=>array(
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'Create New Client' ),
    ), 
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
                    'id'=>'autoId',
                    'class'=>'CCheckBoxColumn',
                    'selectableRows' => '30',   
                ),
                'date_issued',
                'invoice_number',
		array('name'=>'client_search',
                      'value'=>'$data->client->fullname',
                    ),
                array('name'=>'amount',
                      'header'=>'Amount',
                      'value' =>'$data->amount'  //array($this,"gridAmountColumn"),
                     ),
                array('name'=>'give_away',
                      'value'=>array($this,"gridGiveAwayColumn"),
                ),      
                array('name'=>'amount_paid',
                     'value'=>array($this,"gridPaymentColumn"),
                   ),           
                array('name'=>'outstanding',
                      'value'=>array($this,"gridOutstandingColumn"),
                    ),
                array(
                    'class'=>'bootstrap.widgets.TbToggleColumn',
                    'toggleAction'=>'invoice/toggle',
                    'name' => 'flag',
                    'header' => 'Cancel Y/N'
                ),    
		//'payment_term',
		//'taxt1_rate',
		/*
		'tax1_desc',
		'tax2_rate',
		'tax2_desc',
		'note',
		'day_payment_due',
		*/
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      'template'=>'{update}{delete}{payment}',
                      'buttons' => array(
                          'update' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Update Invoice',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Update Invoice' ),
                              ), 
                          ),
                          'payment' => array(
                            'icon' => 'heart',
                            'label' => 'Enter/Update Payment',
                            'url'=>'Yii::app()->createUrl("invoicePayment/create/",array("invoice_id"=>$data->id,"invoice_number"=>$data->invoice_number,"amount"=>$data->amount))',  
                            'options' => array(
                                //'class'=>'update-dialog-open-link',
                                'data-update-dialog-title' => Yii::t( 'app', 'Payment' ),
                                //'data-refresh-grid-id'=>Yii::t('app','invoice-grid'), 
                              ), 
                          ),
                       ),
                 ),
	),
)); ?>

