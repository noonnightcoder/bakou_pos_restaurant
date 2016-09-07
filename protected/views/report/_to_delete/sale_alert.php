<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Sale Invoices Check'),
              'headerIcon' => 'icon-signal',
));?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php $this->renderPartial('_search_sale_alert',array(
	'report'=>$report,'date_view'=>$date_view,
)); ?>

<div id="sale_invoice_alert">
    
<?php 
$url = Yii::app()->createUrl('saleitem/receipt');
$link = CHtml::link('Click this.', $url, array('target'=>'_blank'));
?>

<?php $this->widget('EExcelView',array(
	'id'=>'sale-alert-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'dataProvider'=>$report->saleInvoiceAlert(),
        'summaryText' =>'<p class="text-info"> Invoice From ' . $from_date . ' To ' . $to_date . '</p>', 
	'columns'=>array(
		array('name'=>'id',
                      'header'=>Yii::t('app','Invoice ID'),
                      'value'=>'$data["id"]',
                ),
                array('name'=>'sale_time',
                      'header'=>Yii::t('app','Sale Time'),
                      'value'=>'$data["sale_time"]',
                      //'value'=>'CHtml::link($data["sale_time"], Yii::app()->createUrl("saleitem/admin",array("id"=>$data["id"])))',
                      //'type'=>'raw',
                ),
                array('name'=>'sub_total',
                      'header'=>Yii::t('app','Sub Total'),   
                      'value' =>'number_format($data["sub_total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),   
                      'value' =>'number_format($data["amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity'), 
                      'value' =>'number_format($data["quantity"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'employee_id',
                      'header'=>Yii::t('app','Sold By'), 
                      'value'=>'$data["employee_id"]',
                ),
                array('name'=>'customer_id',
                      'header'=>Yii::t('app','Sold To'), 
                      'value'=>'$data["customer_id"]',
                ),
                array('name'=>'remark',
                      'header'=>Yii::t('app','Remark'), 
                      'value'=>'$data["remark"]',
                ),
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      'template'=>'{view}{print}',
                      //'template'=>'{view}',  
                      'htmlOptions'=>array('width'=>'10px'),
                      'buttons' => array(
                          'view' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Detail',
                            'url'=>'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["id"],"employee_id"=>$data["employee_id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Invoice Detail' ),
                                //'class'=>'label label-important',
                                'title'=>Yii::t('app','Invoice Detail'),
                              ), 
                          ),
                          'print' => array(
                            'label'=>'print',
                            'icon'=>'print',
                            'url'=>'Yii::app()->createUrl("saleItem/Receipt", array("sale_id"=>$data["id"]))',
                            'options' => array(
                                'target'=>'_blank',
                                'title'=>Yii::t('app','Invoice Printing'),
                              ), 
                          ),
                       ),
                 ),
	),
)); ?>
 
</div>

<?php $this->endWidget(); ?>

