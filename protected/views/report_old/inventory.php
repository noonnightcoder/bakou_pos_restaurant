<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Inventories'),
              'headerIcon' => 'icon-signal',
));?>

<?php $this->widget('bootstrap.widgets.TbNav', array(
        'type' => TbHtml::NAV_TYPE_PILLS,
        'htmlOptions'=>array('class'=>'btn-inventory-opt'),
        'items' => array(
            array('label'=>Yii::t('app','All'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'all')), 'active'=>true),
            array('label'=>Yii::t('app','Low Inventory'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'low'))),
            array('label'=>Yii::t('app','Out of Stock'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'outstock'))),
            array('label'=>Yii::t('app','On Stock'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'onstock'))),
            array('label'=>Yii::t('app','Negative Stock'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
            //array('label'=>'|', 'url'=>'#'),
            /*array('label'=>Yii::t('app','Fast Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
            array('label'=>Yii::t('app','Slow Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
            array('label'=>Yii::t('app','Non Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
             * 
            */
        ),
)); ?>

<?php //$this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<div id="rpt-inventory_grid">

<?php $this->widget('EExcelView',array(
	'id'=>'rpt-inventory-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->inventory($filter),
        //'summaryText' =>'<p class="text-info" align="left">'. Yii::t("app","Inventories") .'</p>', 
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'columns'=>array(
		array('name'=>'name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["name"]'
                ),
                array('name'=>'supplier',
                      'header'=>Yii::t('app','Supplier'),
                      'value'=>'$data["supplier"]'
                ),
                array('name'=>'unit_price',
                      'header'=>Yii::t('app','Retail Price'),
                      'value'=>'$data["unit_price"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		array('name'=>'quantity',
                      'header'=>Yii::t('app','On Hand'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'cost_price',
                      'value'=>'$data["cost_price"]',
                      'header'=>Yii::t('app','Average Cost'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                 array('name'=>'reorder_level',
                      'value'=>'$data["reorder_level"]',
                      'header'=>Yii::t('app','Reorder Qty'),
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
                            'url'=>'Yii::app()->createUrl("Inventory/admin", array("item_id"=>$data["id"]))',
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

</div>

<?php $this->endWidget(); ?>

<?php 
    Yii::app()->clientScript->registerScript( 'inventoryViewOption', "
        jQuery( function($){
            $('.btn-inventory-opt li a').on('click', function(e) {
                e.preventDefault();
                var current_link=$(this);
                var url=current_link.attr('href');
                current_link.parent().parent().find('.active').removeClass('active');
                current_link.parent().addClass('active').css('font-weight', 'bold');
                $.ajax({url: url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                  $('#rpt-inventory_grid').html(data.div);
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
                });
        });
      ");
 ?>

<div class="waiting"><!-- Place at bottom of page --></div>