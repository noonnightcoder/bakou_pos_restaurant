<?php if ($date_view==1) { ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
        
<label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
<?php echo $form->textField($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'from_date_id','append'=>'<i class="icon-calendar">?</i>')); ?>
<?php $this->widget('ext.calendar.Calendar',
                array(
                'inputField'=>'from_date_id',
                'trigger'=>'from_date_id',    
                'dateFormat'=>'%d-%m-%Y', 
         ));
?>

<label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
<?php echo $form->textField($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'to_date_id','append'=>'<i class="icon-calendar">?</i>')); ?>
<?php $this->widget('ext.calendar.Calendar',
                array(
                'inputField'=>'to_date_id',
                'trigger'=>'to_date_id',    
                'dateFormat'=>'%d-%m-%Y',     
            ));
?>

<?php echo TbHtml::button(Yii::t('app','Go'),array(
    //'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
    'size'=>TbHtml::BUTTON_SIZE_SMALL,
    'title' => Yii::t( 'app', 'Go' ),
    'ajax'=>array(
        'type'=>'get',
        'dataType'=>'json',
        'beforeSend' => 'function() { $(".waiting").show(); }',
        'complete' => 'function() { $(".waiting").hide(); }',
        'url'=>Yii::app()->createUrl('Report/SaleInvoice/'),
        'success'=>'function (data) {
                    if (data.status==="success")
                    {
                       $("#sale_invoice").html(data.div);
                    }
                    else
                    {
                       alert("Ooh snap, change a few things and try again!");
                    }
               }'
    )
)); ?>

<?php $this->endWidget(); ?>
        
<?php } ?>

<?php $this->widget('EExcelView',array(
	'id'=>'sale-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'dataProvider'=>$report->saleInvoice(),
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
                array('name'=>'status',
                      'header'=>Yii::t('app','Status'), 
                      'value'=>'$data["status"]',
                ),
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      'template'=>'{view}{print}{cancel}{edit}',
                      //'template'=>'{view}',  
                      //'htmlOptions'=>array('width'=>'10px'),
                      'htmlOptions'=>array('class'=>'hidden-phone visible-desktop btn-group'),
                      'buttons' => array(
                          'view' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Detail',
                            'url'=>'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["id"],"employee_id"=>$data["employee_id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Invoice Detail' ),
                                //'class'=>'label label-important',
                                'title'=>Yii::t('app','Invoice Detail'),
                                'class'=>'btn btn-small btn-info',
                              ), 
                          ),
                          'print' => array(
                            'label'=>'print',
                            'icon'=>'print',
                            'url'=>'Yii::app()->createUrl("saleItem/Receipt", array("sale_id"=>$data["id"]))',
                            'options' => array(
                                'target'=>'_blank',
                                'title'=>Yii::t('app','Invoice Printing'),
                                'class'=>'btn btn-small btn-success',
                              ), 
                          ),
                          'cancel' => array(
                            'label'=>'cancel',
                            'icon'=>'trash',
                            'url'=>'Yii::app()->createUrl("sale/delete", array("id"=>$data["id"]))',
                            'options' => array(
                                'title'=>Yii::t('app','Cancel Invoice'),
                                'class'=>'btnCancelInvoice btn btn-small btn-danger',
                              ), 
                          ),
                          'edit' => array(
                            'label'=>'edit',
                            'icon'=>'edit',
                            'url'=>'Yii::app()->createUrl("SaleItem/EditSale", array("sale_id"=>$data["id"]))',
                            'options' => array(
                                'title'=>Yii::t('app','Edit Invoice'),
                                'class'=>'btn btn-small btn-warning',
                              ), 
                          ),
                       ),
                 ),
	),
)); ?>