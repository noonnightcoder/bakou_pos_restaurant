<div style="width:1000px; margin:0 auto;">
 
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => 'Sale Invoices',
              'headerIcon' => 'icon-asterisk',
));?>

<?php //$this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sale-grid',
	'dataProvider'=>$model->saleInvoice(),
	//'filter'=>$model,
	'columns'=>array(
		'sale_time',
		array('name'=>'amount',
                      'value'=>'$data["amount"]',
                ),
		'quantity',
                array('name'=>'employee_id',
                      'header'=>'Cashier',
                      'value'=>'$data["employee_id"]',
                ),
                array('class'=>'bootstrap.widgets.TbButtonColumn',
                      'header'=>'Inventory',
                      'template'=>'{inventory}{empty}{detail}',
                      'htmlOptions'=>array('width'=>'80px'),
                      'buttons' => array(
                          'inventory' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'inv',
                            'url'=>'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Update Item' ),
                                'class'=>'label label-important',
                                'title'=>'Update Inventory',
                              ), 
                          ),
                          'empty'=>array(
                            'label'=>' - ',     
                          ),
                       ),
                 ),
	),
)); ?>

<?php $this->endWidget(); ?>

</div>
