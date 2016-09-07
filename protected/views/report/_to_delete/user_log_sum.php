<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','User Log Summary'),
              'headerIcon' => 'ace-icon fa fa-signal',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-log-summary-form',
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
    
     <?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
 
    <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'userlog_from_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'userlog_from_date',
                        'trigger'=>'userlog_from_date',    
                        'dateFormat'=>'%d-%m-%Y',    
                    ));
    ?>

    <label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
    <?php echo $form->textFieldControlGroup($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'userlog_to_date','append'=>'<i class="ace-icon fa fa-calendar"></i>','readonly'=>true)); ?>
    <?php  $this->widget('ext.calendar.Calendar',
                        array(
                        'inputField'=>'userlog_to_date',
                        'trigger'=>'userlog_to_date',    
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
                'url'=>Yii::app()->createUrl('Report/userLogSummary/'),
                'success'=>'function (data) {
                        if (data.status==="success")
                        {
                           $("#user_log_summary").html(data.div);
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
    
<div id="user_log_summary" >
      
<?php $this->widget('EExcelView',array(
        'id'=>'user-log-summary-grid',
        'fixedHeader' => true,
        //'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->UserLogSummary(),
        'htmlOptions'=>array('class'=>'table-responsive panel'),
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','User Log Summary') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>', 
	'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>
                array('employee_id',
		        array('name'=>'fullname',
                      'header'=>Yii::t('app','Full Name'),
                      'value'=>'$data["fullname"]',
                ),
                array('name'=>'date_log',
                      'header'=>Yii::t('app','Date Log'),
                      'value' =>'$data["date_log"]',
                ),
                array('name'=>'nlog',
                      'header'=>Yii::t('app','# Log'),
                      'value' =>'number_format($data["nlog"],Yii::app()->shoppingCart->getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('class'=>'bootstrap.widgets.TbButtonColumn',
                      'template'=>'{view}',  
                      'htmlOptions'=>array('class'=>'hidden-phone visible-desktop btn-group'),
                      'buttons' => array(
                          'view' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>'Detail',
                            'url'=>'Yii::app()->createUrl("report/userLogdt", array("employee_id"=>$data["employee_id"],"full_name"=>$data["fullname"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'User Log Detail' ),
                                'title'=>Yii::t('app','Detail'),
                                'class'=>'btn btn-xs btn-info',
                                'id'=>uniqid(),  
                                'live'=>false,
                              ), 
                          ),
                       ),
                 ),
	),
)); ?>
    
</div>

<?php $this->endWidget(); ?>    

<div class="waiting"><!-- Place at bottom of page --></div>    