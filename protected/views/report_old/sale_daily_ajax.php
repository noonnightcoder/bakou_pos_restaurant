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
                      'value'=>'$data["date"]'
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'value' =>'number_format($data["quantity"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>number_format($report->saleDailyTotalQty(),Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                      //'value'=>'$data["quantity"]',
                      //'footer'=>$report->saleDailyTotalQty() ,
                ),
		array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),  
                      'value' =>'number_format($data["amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleDailyTotalAmount(),Yii::app()->shoppingCart->getDecimalPlace(), ".", ","),
                      'footerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
	),
)); ?>