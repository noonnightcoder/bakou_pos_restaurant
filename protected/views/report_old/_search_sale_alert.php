<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
        <?php $this->widget('bootstrap.widgets.TbNav', array(
            'type' => TbHtml::NAV_TYPE_PILLS,
            'htmlOptions'=>array('class'=>'btn-rptview-opt'),
            'items' => array(
                array('label'=>Yii::t('app','Today'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoiceAlert',array('period'=>'today')), 'active'=>true),
                array('label'=>Yii::t('app','Yesterday'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoiceAlert',array('period'=>'yesterday'))),
                array('label'=>Yii::t('app','This Month'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoiceAlert',array('period'=>'thismonth'))),
                array('label'=>Yii::t('app','Last Month'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoiceAlert',array('period'=>'lastmonth'))),
                array('label'=>Yii::t('app','Choose Period..'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoiceAlert',array('period'=>'choose'))),
            ),
        )); ?>

        <label class="text-info" for="sale_id"><?php echo Yii::t('app','Sale ID'); ?></label>
        <?php echo $form->textField($report,'sale_id',array('class'=>'span2','maxlength'=>100,'id'=>'sale_id_id')); ?>
        
        <!-- <label class="text-info" for="employee_id"><?php //echo Yii::t('app','Cashier Name'); ?></label> -->
        <?php //echo $form->textField($report,'employee_id',array('class'=>'span2','maxlength'=>100,'id'=>'employee_id')); ?>
        
        <?php if ($date_view==1) { ?>   
        
        <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
        <?php echo $form->textField($report,'from_date',array('class'=>'span2','maxlength'=>100,'id'=>'from_date_id','append'=>'<i class="icon-calendar">?</i>')); ?>
        <?php  $this->widget('ext.calendar.Calendar',
                            array(
                            'inputField'=>'from_date_id',
                            'trigger'=>'from_date_id',    
                            'dateFormat'=>'%d-%m-%Y',    
                        ));
        ?>
        
        <label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
        <?php echo $form->textField($report,'to_date',array('class'=>'span2','maxlength'=>100,'id'=>'to_date_id','append'=>'<i class="icon-calendar">?</i>')); ?>
        <?php  $this->widget('ext.calendar.Calendar',
                            array(
                            'inputField'=>'to_date_id',
                            'trigger'=>'to_date_id',    
                            'dateFormat'=>'%d-%m-%Y',    
                        ));
        ?>
        
        <?php } ?>
        
        <?php echo TbHtml::button(Yii::t('app','Go'),array(
            //'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'size'=>TbHtml::BUTTON_SIZE_SMALL,
            'title' => Yii::t( 'app', 'Go' ),
            'ajax'=>array(
                'type'=>'get',
                'dataType'=>'json',
                'beforeSend' => 'function() { $(".waiting").show(); }',
                'complete' => 'function() { $(".waiting").hide(); }',
                'url'=>Yii::app()->createUrl('Report/SaleInvoiceAlert/'),
                'success'=>'function (data) {
                             if (data.status==="success")
                            {
                               $("#sale_invoice_alert").html(data.div);
                            }
                            else
                            {
                               alert("Ooh snap, change a few things and try again!");
                            }
                       }'
            )
        )); ?>
               
        
 
          
<?php $this->endWidget(); ?>

<?php 
    Yii::app()->clientScript->registerScript( 'reportViewOption', "
        jQuery( function($){
            $('.btn-rptview-opt li a').on('click', function(e) {
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
                                  $('#sale_invoice_alert').html(data.div);
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
