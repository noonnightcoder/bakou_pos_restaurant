<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Item Expiry'),
              'headerIcon' => 'icon-calendar',
));?>

<?php $this->widget('bootstrap.widgets.TbNav', array(
        'type' => TbHtml::NAV_TYPE_PILLS,
        'htmlOptions'=>array('class'=>'btn-item-expiry-opt'),
        'items' => array(
            array('label'=>'1' . Yii::t('app','Month'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'1')), 'active'=>$mfilter=='1'?true:false),
            array('label'=>'2' . Yii::t('app','Months'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'2')), 'active'=>$mfilter=='2'?true:false),
            array('label'=>'3' . Yii::t('app','Months'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'3')), 'active'=>$mfilter=='3'?true:false),
            array('label'=>'6' . Yii::t('app','Months'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'6')), 'active'=>$mfilter=='6'?true:false),
            array('label'=>'12' . Yii::t('app','Months'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'12')),'active'=>$mfilter=='13'?true:false),
            //array('label'=>'|', 'url'=>'#'),
            //array('label'=>Yii::t('app','Fast Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'negative'))),
            //array('label'=>Yii::t('app','Slow Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'negative'))),
            //array('label'=>Yii::t('app','Non Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry',array('mfilter'=>'negative'))),
        ),
)); ?>

<?php //$this->widget( 'ext.modaldlg.EModalDlg' ); ?>
    <br/>

<div id="rpt-item_expire_grid">

<?php $this->widget('EExcelView',array(
	'id'=>'rpt-item-expiry-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->itemExpiry($mfilter),
        //'summaryText' =>'<p class="text-info" align="left">'. Yii::t("app","Inventories") .'</p>', 
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'columns'=>array(
                array('name'=>'received',
                      'header'=>Yii::t('app','Received'),
                      'value'=>'$data["received"]'
                ),
		array('name'=>'name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["name"]'
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity'),
                      'value'=>'$data["quantity"]'
                ),
                array('name'=>'month_expire',
                      'header'=>Yii::t('app','Expire on'),
                      'value'=>'$data["month_expire"]',
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

</div> <!-- End of Content -->

<?php $this->endWidget(); ?>
     
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
</a> 

<?php 
    Yii::app()->clientScript->registerScript( 'itemexpiryViewOption', "
        jQuery( function($){
            $('.btn-item-expiry-opt li a').on('click', function(e) {
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
                                  $('#rpt-item_expire_grid').html(data.div);
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