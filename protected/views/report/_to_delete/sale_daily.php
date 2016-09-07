<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'saily-daily-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
    <!-- testing whether from_date / to_date variable passing ocrrectly -->
    <p class="label-important"><?php //echo $from_date; ?></p>

    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'dailysale_from_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'dailysale_from_date',
                        'trigger'=>'dailysale_from_date',    
                        'dateFormat'=>'%d-%m-%Y',    
                    ));
    ?>

    <label class="text-info" for="to_date">End Date</label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'dailysale_to_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'dailysale_to_date',
                        'trigger'=>'dailysale_to_date',    
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
            'url'=>Yii::app()->createUrl('Report/SaleDaily/'),
            'success'=>'function (data) {
                         if (data.status==="success")
                        {
                           $("#sale_daily").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                   }'
        )
     )); ?>

<?php $this->endWidget(); ?>    
    
    
<div id="sale_daily">
   
<?php $this->widget('EExcelView',array(
        'id'=>'sale-daily-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->saledaily(),
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Daily Sales') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>', 
	'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>array(
                array('name'=>'date',
                          'header'=>Yii::t('app','Date'),
                          'value'=>'$data["date_report"]',
                    ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','QTY'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'value' =>'number_format($data["quantity"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>number_format($report->saleDailyTotals()[0],Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'sub_total',
                              'header'=>Yii::t('app','Sub Total'),
                              'htmlOptions'=>array('style' => 'text-align: right;'),
                              'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                              'value' =>'number_format($data["sub_total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                              'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleDailyTotals()[1],Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                              'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                        ),
                array('name'=>'discount',
                      'header'=>Yii::t('app','Discount'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),  
                      'value' =>'number_format($data["discount_amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleDailyTotals()[2],Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'total',
                      'header'=>Yii::t('app','Total'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),  
                      'value' =>'number_format($data["total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleDailyTotals()[3],Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
	),
)); ?>
    
</div>
    
<div class="waiting"><!-- Place at bottom of page --></div>    