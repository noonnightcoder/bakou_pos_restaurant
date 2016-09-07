<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'topproduct-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
    <!-- testing whether from_date / to_date variable passing ocrrectly -->
    <p class="label-important"><?php //echo $from_date; ?></p>

    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'topproduct_from_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'topproduct_from_date',
                        'trigger'=>'topproduct_from_date',    
                        'dateFormat'=>'%Y-%m-%d',    
                    ));
    ?>

    <label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'toproduct_to_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'toproduct_to_date',
                        'trigger'=>'toproduct_to_date',    
                        'dateFormat'=>'%Y-%m-%d',    
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
                'url'=>Yii::app()->createUrl('Report/TopProduct/'),
                'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#topproduct").html(data.div);
                        }
                        else
                        {
                           alert("Ooh snap, change a few things and try again!");
                        }
                 }'
            )
      )); ?>

<?php $this->endWidget(); ?>    
    
    
<div id="topproduct">
   
<?php $this->widget('EExcelView',array(
        'id'=>'top-product-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->topproduct(),
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Top 10 Products') . Yii::t('app','From') . ':   ' . $from_date . '  ' . Yii::t('app','To') . ':   ' . $to_date . '   ' . Yii::t('app','Ranked by quantity') .'</p>', 
	'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>array(
                array('name'=>'rank',
                      'header'=>Yii::t('app','Rank'),
                      'value'=>'$data["rank"]',
                ),
                array('name'=>'item_name',
                      'header'=>Yii::t('app','Item Name'),  
                      'value'=>'$data["item_name"]',
                ),
                array('name'=>'qty',
                      'header'=>Yii::t('app','Quantity'),  
                      'value'=>'number_format($data["qty"],0)',
                      //'footer'=>$report->paymentTotalQty() ,
                ),
		array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),  
                      'value'=>'number_format($data["amount"],Yii::app()->shoppingCart->getDecimalPlace())',
                      //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($report->paymentTotalAmount(),'USD'),
                ),
	),
)); ?>
    
</div>
    
<div class="waiting"><!-- Place at bottom of page --></div>    