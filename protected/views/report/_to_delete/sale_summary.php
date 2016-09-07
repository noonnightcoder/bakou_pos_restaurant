<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'saily-summary-form',
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
                'url'=>Yii::app()->createUrl('Report/SaleSummary/'),
                'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#sale_summary").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                 }'
            )
      )); ?>
<?php $this->endWidget(); ?>  
    
<div id="sale_summary">
      
<?php $this->widget('EExcelView',array(
        'id'=>'sale-summary-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->saleSummary(),
        //'filter'=>$filtersForm,
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Sales Summary') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>', 
	'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>array(
		array('name'=>'no_of_invoice',
                      'header'=>Yii::t('app','No. of Invoices'),
                      'value'=>'$data["no_of_invoice"]',
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity Sold'),
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
                array('name'=>'discount',
                      'header'=>Yii::t('app','Discount'),
                      'value' =>'number_format($data["discount_amount"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'total',
                      'header'=>Yii::t('app','Total'),
                      'value' =>'number_format($data["total"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
	),
)); ?>
    
</div>

<div class="waiting"><!-- Place at bottom of page --></div>    