<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Transaction'),
              'headerIcon' => 'ace-icon fa fa-signal',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php $this->renderPartial('_search_receive',array(
	'report'=>$report,'date_view'=>$date_view,
)); ?>

<div id="receive_invoice">
    
<?php 
$url = Yii::app()->createUrl('receiveitem/receipt');
$link = CHtml::link('Click this.', $url, array('target'=>'_blank'));
?>
    
<br>

<?php $this->widget('EExcelView',array(
	'id'=>'receive-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'dataProvider'=>$report->receiveInvoice(),
        'summaryText' =>'<p class="text-info"> Transaction From ' . $from_date . ' To ' . $to_date . '</p>', 
	'columns'=>array(
		array('name'=>'id',
                      'header'=>Yii::t('app','ID'),
                      'value'=>'$data["id"]',
                ),
                array('name'=>'sale_time',
                      'header'=>Yii::t('app','Transaction Time'),
                      'value'=>'$data["receive_time"]',
                      //'value'=>'CHtml::link($data["sale_time"], Yii::app()->createUrl("saleitem/admin",array("id"=>$data["id"])))',
                      //'type'=>'raw',
                ),
                array('name'=>'status',
                      'header'=>Yii::t('app','Transaction Type'),
                      'value'=>'$data["status"]',
                      //'value'=>'CHtml::link($data["sale_time"], Yii::app()->createUrl("saleitem/admin",array("id"=>$data["id"])))',
                      //'type'=>'raw',
                ),
                array('name'=>'sub_total',
                      'header'=>Yii::t('app','Sub Total'),   
                      'value' =>'number_format($data["sub_total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','QTY'), 
                      'value' =>'number_format($data["quantity"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'employee_id',
                      'header'=>Yii::t('app','Cashier'), 
                      'value'=>'$data["employee_id"]',
                ),
                array('name'=>'remark',
                      'header'=>Yii::t('app','Remark'),
                      'value'=>'$data["remark"]',
                      //'value'=>'CHtml::link($data["sale_time"], Yii::app()->createUrl("saleitem/admin",array("id"=>$data["id"])))',
                      //'type'=>'raw',
                ),
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      //'template'=>'{view}{print}',
                      'template'=>'{view}',  
                      'htmlOptions'=>array('width'=>'10px'),
                      'buttons' => array(
                          'view' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Detail',
                            'url'=>'Yii::app()->createUrl("report/TransactionItem", array("receive_id"=>$data["id"],"employee_id"=>$data["employee_id"],"remark"=>$data["remark"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Transaction Detail' ),
                                //'class'=>'label label-important',
                                'title'=>Yii::t('app','Transaction Detail'),
                              ), 
                          ),
                          /*
                          'print' => array(
                            'label'=>'print',
                            'icon'=>'print',
                            'url'=>'Yii::app()->createUrl("saleitem/receipt", array("sale_id"=>$data["id"],"employee_id"=>$data["employee_id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Print Receipt' ),
                                'target'=>'_blank',
                                'title'=>Yii::t('app','Sale Invoices'),
                              ), 
                          ),
                           * 
                          */
                       ),
                 ),
	),
)); ?>

</div>

<?php $this->endWidget(); ?>

<div class="waiting"><!-- Place at bottom of page --></div>