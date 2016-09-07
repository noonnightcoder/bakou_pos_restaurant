<?php $this->widget('EExcelView',array(
	'id'=>'rpt-item-expiry-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->itemExpiry($mfilter),
        //'summaryText' =>'<p class="text-info" align="left">'. Yii::t("app","Inventories") .'</p>', 
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'columns'=>array(
                /*
                array('name'=>'received',
                      'header'=>Yii::t('app','Received'),
                      'value'=>'$data["received"]'
                ),
                 * 
                */
		array('name'=>'name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["name"]'
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity'),
                      'value'=>'$data["quantity"]'
                ),
                array(//'name'=>'month_expire',
                      'header'=>Yii::t('app','Expire on'),
                      'value'=>'$data["expire_date"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'n_month_expire',
                      'header'=>Yii::t('app','# Months Expire'),
                      'value'=>'$data["n_month_expire"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                /*
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      'template'=>'{detail}',
                      'htmlOptions'=>array('width'=>'10px'),
                      'buttons' => array(
                          'detail' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>Yii::t('app','form.label.detail'),
                            'url'=>'Yii::app()->createUrl("Inventory/admin", array("item_id"=>$data["receiving_id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Stock History' ),
                                'class'=>'label label-important',
                                'title'=>'Inventory Details',
                              ), 
                          ),
                       ),
                 ),
                 * 
                 */
	),
)); ?>
