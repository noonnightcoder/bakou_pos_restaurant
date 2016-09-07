<div class="row-fluid">
<div class="span12" style="float: none;margin-left: auto; margin-right: auto;">
    
<?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','List Of All Invoice'),
              'headerIcon' => 'icon-book',
)); ?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>

<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
    
 <?php echo TbHtml::linkButton(Yii::t( 'app', 'Back to Client' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
        'icon'=>'plus undo',
        'url'=>$this->createUrl('client/admin'),
)); ?>   
    
<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-invoice-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$model->Invoice($client_id),
        //'summaryText' =>'', 
	'columns'=>array(
                array('name'=>'status',
                      'header'=>Yii::t('app','Payment Status'),
                      //'value'=>'"<span class=\"label label- arrowed-right arrowed-in\"><s>" . $data["status"] . "</s></span>"',
                      'value'=>array($this,"gridPaymentStatus"),
                      'type'=>'raw'
                ),
		array('name'=>'sale_id',
                      'header'=>Yii::t('app','Sale ID'),
                      'value'=>'$data["sale_id"]',
                ),
                array('name'=>'sale_time',
                      'header'=>Yii::t('app','Sale Time'),
                      'value'=>'$data["sale_time"]',
                ),
                array('name'=>'client_id',
                      'header'=>Yii::t('app','Customer Name'), 
                      'value'=>'$data["client_id"]',
                ),
                array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),   
                      'value' =>'$data["amount"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'paid',
                      'header'=>Yii::t('app','Paid'),   
                      'value' =>'$data["paid"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'date_paid',
                      'header'=>Yii::t('app','Date Paid'),
                      'value'=>array($this,"gridDatePaidColumn"),
                    ),
                array('name'=>'note',
                      'header'=>Yii::t('app','Note'),
                      'value'=>array($this,"gridNoteColumn"),
                ),    
                array('name'=>'balance',
                      'header'=>Yii::t('app','Balance'),   
                      'value' =>'$data["balance"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'footer'=>$model->clientBalance($client_id), 
                      'footerHtmlOptions'=>array('style' => 'text-align: right;')
                ),
                /*
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      //'template'=>'{view}{print}',
                      'template'=>'{payment}',  
                      'buttons' => array(
                          'payment' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>Yii::t('app','Payment'),
                            'url'=>'Yii::app()->createUrl("salepayment/create", array("sale_id"=>$data["sale_id"],"amount"=>$data["amount_to_paid"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Enter Payment' ),
                                'data-refresh-grid-id'=>'sale-invoice-grid',
                                'title'=>Yii::t('app','Payment Per Invoice'),
                              ), 
                          ),
                       ),
                 ),
                 * 
                 */
	),
)); ?>    

<?php $this->endWidget(); ?>    

</div>
</div>