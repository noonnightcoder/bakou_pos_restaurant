<?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','List Of Invoice'),
              'headerIcon' => 'ace-icon fa fa-book',
)); ?>
    

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>

<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
    
 <?php /*$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'htmlOptions'=>array('class'=>'btn-rptview-opt'),
    'items' => array(
        array('label'=>Yii::t('app','Due'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'today')), 'active'=>true),
        array('label'=>Yii::t('app','Paid'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'yesterday'))),
        array('label'=>Yii::t('app','All'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'thismonth'))),
    ),
)); */?>    
    
    
<?php /* echo TbHtml::linkButton(Yii::t( 'app', 'Batch Payment' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'heart white',
        'url'=>Yii::app()->createUrl("SalePayment/payment",array('client_id'=>$client_id)),
        'class'=>'update-dialog-open-link',
        'data-refresh-grid-id'=>'sale-invoice-grid',
        'data-update-dialog-title' => Yii::t('app','Payment in Batch'),
        
)); */?>    
    
 <?php /* echo TbHtml::linkButton(Yii::t( 'app', 'Back to Client' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'plus undo',
        'url'=>$this->createUrl('client/admin'),
)); */?>   
    
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
<!-- <label class="text-info" for="sale_id"><?php //echo Yii::t('app','Invoice ID'); ?></label> --->
<?php echo $form->textField($model,'sale_id',array('class'=>'col-sm-4','maxlength'=>100,'id'=>'sale_id_id','placeholder'=>'Search Invoice')); ?>

<?php echo TbHtml::button(Yii::t('app','Go'),array(
    'size'=>TbHtml::BUTTON_SIZE_SMALL,
    'title' => Yii::t( 'app', 'Go' ),
    'ajax'=>array(
        'type'=>'get',
        'dataType'=>'json',
        'beforeSend' => 'function() { $(".waiting").show(); }',
        'complete' => 'function() { $(".waiting").hide(); }',
        'url'=>Yii::app()->createUrl('Sale/Invoice/'),
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

<div id="sale_invoice">

<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-invoice-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$model->saleInvoice($client_id,$search_text),
        //'summaryText' =>'', 
	'columns'=>array(
                array(
                    'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                    'name' => 'sale_id',
                    'header'=>Yii::t('app','Invoice ID'),
                    'url' => $this->createUrl('SalePayment/PaymentDetail'),
                    'value' => '$data["sale_id"]',
                ),
                array('name'=>'status',
                      'header'=>Yii::t('app','Payment Status'),
                      //'value'=>'"<span class=\"label label- arrowed-right arrowed-in\"><s>" . $data["status"] . "</s></span>"',
                      'value'=>array($this,"gridPaymentStatus"),
                      'type'=>'raw'
                ),
                array('name'=>'sale_time',
                      'header'=>Yii::t('app','Invoice Date'),
                      'value'=>'$data["sale_time"]',
                ),
                array('name'=>'client_id',
                      'header'=>Yii::t('app','Customer Name'), 
                      'value'=>'$data["client_id"]',
                ),
                array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),   
                      'value' =>'number_format($data["amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'paid',
                      'header'=>Yii::t('app','Paid'),   
                      'value' =>'number_format($data["paid"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'date_paid',
                      'header'=>Yii::t('app','Date Paid'),
                      'value'=>array($this,"gridDatePaidColumn"),
                    ),
               array('name'=>'note',
                      'header'=>Yii::t('app','Note'),
                      'value'=>array($this,"gridNoteColumn"),
                    ),     
               array('name'=>'Payment',
                     'value'=>array($this,"gridPaymentBtn"),  
                     'type'=>'raw',
                ),    
                /*    
                array('name'=>'balance',
                      'header'=>Yii::t('app','Balance'),   
                      'value' =>'$data["balance"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'footer'=>$model->clientBalance($client_id), 
                      'footerHtmlOptions'=>array('style' => 'text-align: right;')
                ),
                 * 
                */
                /*
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      'header'=>Yii::t('app','Action'),
                      //'template'=>'{view}{print}',
                      'template'=>'{payment}',
                      //'htmlOptions'=>array('class'=>'hidden-phone visible-desktop btn-group'),  
                      'buttons' => array(
                          'payment' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>Yii::t('app','Payment'),
                            'url'=>'Yii::app()->createUrl("SalePayment/create", array("sale_id"=>$data["sale_id"],"amount"=>$data["amount_to_paid"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Enter Payment' ),
                                'data-refresh-grid-id'=>'sale-invoice-grid',
                                'title'=>Yii::t('app','Payment Per Invoice'),
                                'class'=>'btn btn-small btn-info',
                              ), 
                          ),
                       ),
                 ),
                 * 
                 */
	),
)); ?>    

<?php $this->endWidget(); ?>   
    
</div>
