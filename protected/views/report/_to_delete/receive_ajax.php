<?php if ($date_view==1) { ?>
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'method'=>'get',
            'enableAjaxValidation'=>false,
            'layout'=>TbHtml::FORM_LAYOUT_INLINE,
    )); ?>

    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'from_date_id','append'=>'<i class="ace-icon fa fa-calendar"></i>')); ?>
    <?php $this->widget('ext.calendar.Calendar',
                    array(
                    'inputField'=>'from_date_id',
                    'trigger'=>'from_date_id',    
                    'dateFormat'=>'%d-%m-%Y',    
             ));
    ?>

    <label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'to_date_id','append'=>'<i class="ace-icon fa fa-calendar"></i>')); ?>
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
            'url'=>Yii::app()->createUrl('Report/ReceiveInvoice/'),
            'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#receive_invoice").html(data.div);
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
)
        ); ?>
    