<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'saily-hourly-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
    <!-- testing whether from_date / to_date variable passing ocrrectly -->
    <p class="label-important"><?php //echo $to_date; ?></p>

    <label class="text-info" for="to_date">Select Date</label>
    <?php echo $form->textField($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'hourlysale_to_date','append'=>'<i class="icon-calendar">?</i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'hourlysale_to_date',
                        'trigger'=>'hourlysale_to_date',    
                        'dateFormat'=>'%Y-%m-%d',    
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
            'url'=>Yii::app()->createUrl('Report/SaleHourly/'),
            'success'=>'function (data) {
                         if (data.status==="success")
                        {
                           $("#sale_hourly").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                   }'

        )
    )); ?>

<?php $this->endWidget(); ?>    
    
    
<div id="sale_hourly">
   
<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
        'id'=>'sale-hourly-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->salehourly(),
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Hourly Sales') . Yii::t('app','On') . ':  ' . $to_date . '</p>', 
	'columns'=>array(
		array('name'=>'hours',
                      'header'=>Yii::t('app','Hour'),
                      'value'=>'$data["hours"]'
                ),
                array('name'=>'qty',
                      'header'=>Yii::t('app','Quantity'),
                      'value'=>'number_format($data["qty"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>number_format($report->saleHourlyTotalQty(),Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                ),
		array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),
                      'value'=>'number_format($data["amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleHourlyTotalAmount(),Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                ),
	),
)); ?>
    
</div>
    
<div class="waiting"><!-- Place at bottom of page --></div>    