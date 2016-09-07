<div class="span6" style="float: none;margin-left: auto; margin-right: auto;">
<div id="item_asset">
<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
        'id'=>'item-asset-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->itemasset(),
        'summaryText' => '<p class="text-info" align="left">' . Yii::t('app','Total Asset') .  '</p>',
	'columns'=>array(
		array('name'=>'total_qty',
                      'header'=>Yii::t('app','Quantity'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'value'=>'number_format($data["total_qty"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;')
                ),
               array('name'=>'total_amount',
                     'header'=>Yii::t('app','Amount'), 
                     'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                     'value'=>'number_format($data["total_amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                     'htmlOptions'=>array('style' => 'text-align: right;')
                ),
	),
)); ?>
</div>
</div>