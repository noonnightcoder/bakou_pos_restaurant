<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'payment-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
    <!-- testing whether from_date / to_date variable passing ocrrectly -->
    <p class="label-important"><?php //echo $from_date; ?></p>
    
    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'payment_from_date_id','append'=>'<i class="ace-icon fa fa-calendar">?</i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'payment_from_date_id',
                        'trigger'=>'payment_from_date_id',    
                        'dateFormat'=>'%d-%m-%Y',    
                    ));
    ?>

    <label class="text-info" for="to_date">End Date</label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'payment_to_date_id','append'=>'<i class="ace-icon fa fa-calendar">?</i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'payment_to_date_id',
                        'trigger'=>'payment_to_date_id',    
                        'dateFormat'=>'%d-%m-%Y',    
                    ));
    ?>

    <?php echo TbHtml::button(Yii::t('app','Go'),array(
            //'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'size'=>TbHtml::BUTTON_SIZE_MINI,
            'title' => Yii::t( 'app', 'Go' ),
            'ajax'=>array(
                'type'=>'get',
                'dataType'=>'json',
                'beforeSend' => 'function() { $(".waiting").show(); }',
                'complete' => 'function() { $(".waiting").hide(); }',
                'url'=>Yii::app()->createUrl('Report/Payment/'),
                'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#payment").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                 }'
            )
      )); ?>
<?php $this->endWidget(); ?>    
    
    
<div id="payment">
   
<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
        'id'=>'payment-grid',
	'dataProvider'=>$report->payment(),
        'summaryText' => '<p class="text-info" align="left"> Payment Collected From  ' . $from_date . ' To ' . $to_date .  '</p>',
	'columns'=>array(
                array('name'=>'payment_type',
                      'header'=>'Payment Type',
                      'value'=>'$data["payment_type"]',
                ),
                array('name'=>'quantity',
                      'header'=>'Count',
                      'value'=>'number_format($data["quantity"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>number_format($report->paymentTotalQty(),Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                ),
		array('name'=>'amount',
                      'header'=>'Amount',
                      'value'=>'number_format($data["amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->paymentTotalAmount(),Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                ),
	),
)); ?>
    
</div>
    
<div class="waiting"><!-- Place at bottom of page --></div>    