<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'rpt-item-inactive-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->itemInactive($mfilter),
        //'summaryText' =>'<p class="text-info" align="left">'. Yii::t("app","Inventories") .'</p>', 
	'columns'=>array(
                array('name'=>'month_diff',
                      'header'=>Yii::t('app','#Months'),
                      'value'=>'$data["month_diff"]'
                ),
		array('name'=>'name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["name"]'
                ),
                array('name'=>'description',
                      'header'=>Yii::t('app','Description'),
                      'value'=>'$data["description"]'
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity'),
                      'value'=>'$data["quantity"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'sale_time',
                      'header'=>Yii::t('app','Last Sale Time'),
                      'value'=>'$data["sale_time"]',
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