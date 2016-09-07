<?php
/*
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	'Manage',
);
*/


/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sale-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
 * 
*/
?>
<div class="row">
<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
    
<?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','List Of Invoice No Client Info'),
              'headerIcon' => 'icon-book',
)); ?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>

<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
    
<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$model->saleInvoice(),
        'summaryText' =>'', 
	'columns'=>array(
                array('name'=>'status',
                      'header'=>Yii::t('app','Payment Status'),
                      //'value'=>'"<span class=\"label label- arrowed-right arrowed-in\"><s>" . $data["status"] . "</s></span>"',
                      'value'=>array($this,"gridPaymentStatus"),
                      'type'=>'raw'
                ),
		array('name'=>'sale_id',
                      'header'=>Yii::t('app','Sale ID'),
                      'value'=>'$data["sale_id"]',
                ),
                array('name'=>'sale_time',
                      'header'=>Yii::t('app','Sale Time'),
                      'value'=>'$data["sale_time"]',
                ),
                array('name'=>'client_id',
                      'header'=>Yii::t('app','Customer Name'), 
                      'value'=>'$data["client_id"]',
                ),
                array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),   
                      'value' =>'$data["amount"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'paid',
                      'header'=>Yii::t('app','Paid'),   
                      'value' =>'$data["paid"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'balance',
                      'header'=>Yii::t('app','Balance'),   
                      'value' =>'$data["balance"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      //'template'=>'{view}{print}',
                      'template'=>'{view}{edit}',  
                      'buttons' => array(
                          'view' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Detail',
                            'url'=>'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["sale_id"],"employee_id"=>$data["employee_id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Invoice Detail' ),
                                //'class'=>'label label-important',
                                'title'=>Yii::t('app','Invoice Detail'),
                              ), 
                          ),
                          'edit' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>Yii::t('app','Edit'),
                            'url'=>'Yii::app()->createUrl("sale/update", array("id"=>$data["sale_id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Update Client Info' ),
                                'data-refresh-grid-id'=>'sale-grid',
                                'title'=>Yii::t('app','Update Client Info'),
                              ), 
                          ),
                       ),
                 ),
	),
)); ?>    

<?php /*$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sale-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'sale_time',
		array('name'=>'client_id',
                      'value'=>'$data->client==null ?"N/A":$data->client->first_name . " " . $data->client->last_name'
                ),
		//'employee_id',
		//'sub_total',
                array('name' =>'amount',
                      'header'=>'Amount',
                      'value' =>array($this,"gridPaidAmount"),
                ),
                 array('name' =>'balance',
                      'header'=>'Balance',
                      'value' =>array($this,"gridBalance"),
                ),
		//'payment_type',
		'remark',
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=> Yii::t('app','Edit'),
                      'template'=>'{payment}{cost}{price}',
                      //'template'=>'{detail}{update}{delete}',
                      //'htmlOptions'=>array('width'=>'190px'),
                      'buttons' => array(
                           'payment' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>Yii::t('app','Payment'),
                            'url'=>'Yii::app()->createUrl("salepayment/create",array("sale_id"=>$data->id,"amount"=>$data->sub_total))',
                            'options' => array(
                                'data-update-dialog-title' => 'Entery Payment',
                                'class'=>'label label-warning',
                                'title'=>'Entery Payment',
                              ), 
                          ),
                          'cost' => array(
                            'click' => 'updateDialogOpen',
                            //'label'=>"<span class='text-info'>" . Yii::t('app','Cost') . "</span><i class='icon-info-sign'></i> ",
                            'label'=>Yii::t('app','Cost'),
                            'url'=>'Yii::app()->createUrl("Item/CostHistory", array("item_id"=>$data->id))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app','Cost History'),
                                'class'=>'label label-info',
                                'title'=>'Cost History',
                                'data-refresh-grid-id'=>'sale-grid',
                              ), 
                          ),
                          'price' => array(
                            'click' => 'updateDialogOpen',
                            //'label'=>"<span class='text-info'>" . Yii::t('app','Price') . "</span><i class='icon-info-sign'></i> ",
                            'label'=>Yii::t('app','Price'),  
                            'url'=>'Yii::app()->createUrl("Item/PriceHistory", array("item_id"=>$data->id))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app','Price History'),
                                'class'=>'label label-success',
                                'title'=>'Price History',
                              ), 
                          ),
                       ),
                 ),
	),
)); */?>
    
<?php $this->endWidget(); ?>    

</div>
</div>