<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Sale Item Summary'),
              'headerIcon' => 'ace-icon fa fa-signal',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'saily-item-summary-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
 
    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'salesummary_from_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'salesummary_from_date',
                        'trigger'=>'salesummary_from_date',    
                        'dateFormat'=>'%d-%m-%Y',    
                    ));
    ?>

    <label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'salesummary_to_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'salesummary_to_date',
                        'trigger'=>'salesummary_to_date',    
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
                'url'=>Yii::app()->createUrl('Report/SaleItemSummary/'),
                'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#sale_item_summary").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                 }'
            )
      )); ?>
<?php $this->endWidget(); ?>  
 
<br />
    
<div id="sale_item_summary" >
      
<?php $this->widget('EExcelView',array(
        'id'=>'sale-item-summary-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->saleItemSummary(),
        //'filter'=>$filtersForm,
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Sales Item Summary') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>', 
	'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>array(
		        array('name'=>'item_name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["item_name"]',
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'date_report',
                      'header'=>Yii::t('app','Date'),
                      'value' =>'$data["date_report"]',
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','QTY'),
                      'value' =>'number_format($data["quantity"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		        array('name'=>'sub_total',
                      'header'=>Yii::t('app','Sub Total'),
                      'value' =>'number_format($data["sub_total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
	),
)); ?>
    
</div>

<?php $this->endWidget(); ?>    

<div class="waiting"><!-- Place at bottom of page --></div>    