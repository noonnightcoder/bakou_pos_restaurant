<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'daily-profit-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
    <!-- testing whether from_date / to_date variable passing ocrrectly -->
    <p class="label-important"><?php //echo $from_date; ?></p>
    
    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'dailyprofit_from_date_id','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'dailyprofit_from_date_id',
                        'trigger'=>'dailyprofit_from_date_id',    
                        'dateFormat'=>'%d-%m-%Y',    
                    ));
    ?>

    <label class="text-info" for="to_date">End Date</label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'dailyprofit_to_date_id','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'dailyprofit_to_date_id',
                        'trigger'=>'dailyprofit_to_date_id',    
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
                'url'=>Yii::app()->createUrl('Report/DailyProfit/'),
                'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#sale_daily_profit").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                 }'
            )
      )); ?>
<?php $this->endWidget(); ?> 

<div id="sale_daily_profit">
   
<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
        'id'=>'sale-daily-profit-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->saledailyprofit(),
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Daily Profit') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>',
	'columns'=>array(
		array('name'=>'date_report',
                      'header'=>Yii::t('app','Date'), 
                      'value'=>'$data["date_report"]',
                ),
                array('name'=>'sub_total',
                      'header'=>Yii::t('app','Sub Total'),
                      'value' =>'number_format($data["sub_total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol')  . number_format($report->saleDailyProfitTotals()[0],Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		array('name'=>'profit',
                      'header'=>Yii::t('app','Profit'), 
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'value' =>'number_format($data["profit"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol')  . number_format($report->saleDailyProfitTotals()[2],Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'margin',
                      'header'=>Yii::t('app','Margin'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),  
                      'value'=>'$data["margin"] . "%"',
                ),
	),
)); ?>
    
</div>
    
<div class="waiting"><!-- Place at bottom of page --></div>    