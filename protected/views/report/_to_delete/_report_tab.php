<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>Yii::t('app','Sale Invoices'),'id'=>'tab_1', 'content'=>$this->renderPartial('sale', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date,'date_view'=>$date_view),true),'active'=>true),
        //array('label'=>Yii::t('app','Item Expiry'),'id'=>'tab_4', 'content'=>$this->renderPartial('item_expiry', array('report'=>$report,'mfilter'=>$mfilter), true)),
        //array('label'=>Yii::t('app','Item Inactive'),'id'=>'tab_6', 'content'=>$this->renderPartial('item_inactive', array('report'=>$report,'mfilter'=>$mfilter), true)),
        //array('label'=>Yii::t('app','Receive Invoices'),'id'=>'tab_7', 'content'=>$this->renderPartial('receive', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date,'date_view'=>$date_view),true)),
        array('label'=>Yii::t('app','Sales Reports'),'id'=>'tab_2', 'content'=>$this->renderPartial('_sale_report_tab', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true)),
        array('label'=>Yii::t('app','Inventories'),'id'=>'tab_3', 'content'=>$this->renderPartial('inventory', array('report'=>$report,'filter'=>$filter), true)),
        array('label'=>Yii::t('app','Total Asset'),'id'=>'tab_5', 'content'=>$this->renderPartial('item_asset', array('report'=>$report,'filter'=>$filter), true)),
        
    ),
    //'events'=>array('shown'=>'js:loadContent')
)); ?>
</div>

<script>
function loadContent(e){
     
    var tabId = e.target.getAttribute("href");
   
    var ctUrl = ''; 

    if(tabId === '#tab_1') {
        ctUrl = '<?php echo Yii::app()->createUrl("Report/SaleInvoice"); ?>';
    } else if(tabId === '#tab_2') {
        ctUrl = '<?php echo Yii::app()->createUrl("Report/SaleReportTab"); ?>';
    } else if(tabId === '#tab_3') {
        ctUrl = 'url to get tab 3 content';
    } else if(tabId === '#tab_2_1') {
        ctUrl = '<?php echo Yii::app()->createUrl("Report/SaleSummary"); ?>';
    } else if(tabId === '#tab_2_2') {
        ctUrl = '<?php echo Yii::app()->createUrl("Report/SaleReportTab"); ?>';
    } else if(tabId === '#tab_2_3') {
        ctUrl = 'url to get tab 3 content';
    } else if(tabId === '#tab_2_4') {
        ctUrl = '<?php echo Yii::app()->createUrl("Report/SaleDaily"); ?>';
    } else if(tabId === '#tab_2_5') {
        ctUrl = 'url to get tab 3 content';
    } else if(tabId === '#tab_2_6') {
        ctUrl = 'url to get tab 3 content';
    }
    
    console.log('tab number : ' + tabId + 'url to load : ' + ctUrl);
   
    if(ctUrl !== '') {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'html',
            cache    : false,
            beforeSend : function() { $('.waiting').show(); },
            complete : function() { $('.waiting').hide(); },
            success  : function(html)
            {
                jQuery(tabId).html(html);
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }
    
    e.preventDefault();
    
    return false;
}
</script>

<?php  /*
    Yii::app()->clientScript->registerScript( 'tabLoadAjaxContent', "
        jQuery( function($){
            $('#yw5').on('show', function (e) {
                var tabId =e.target.getAttribute('href'); // activated tab
                
                if(tabId === '#tab_1') {
                     ctUrl = 'SaleInvoice';
                } else if(tabId === '#tab_2') {
                    ctUrl = 'SaleReportTab';
                } else if(tabId === '#tab_3') {
                    ctUrl = 'url to get tab 3 content';
                } else if(tabId === '#tab_2_1') {
                    ctUrl = 'Report/SaleSummary';
                } else if(tabId === '#tab_2_2') {
                    ctUrl = 'SaleReportTab';
                } else if(tabId === '#tab_2_3') {
                    ctUrl = 'url to get tab 3 content';
                } else if(tabId === '#tab_2_4') {
                    ctUrl = 'SaleDaily); ?>';
                } else if(tabId === '#tab_2_5') {
                    ctUrl = 'url to get tab 3 content';
                } else if(tabId === '#tab_2_6') {
                    ctUrl = 'url to get tab 3 content';
                }
                
                if(ctUrl !== '') {
                    $.ajax({
                        url      : ctUrl,
                        type     : 'POST',
                        dataType : 'html',
                        cache    : false,
                        beforeSend : function() { $('.waiting').show(); },
                        complete : function() { $('.waiting').hide(); },
                        success  : function(html)
                        {
                            jQuery(tabId).html(html);
                        },
                        error:function(){
                                alert('Request failed');
                        }
                    });
                }
                
                console.log(ctUrl);
          });
        });  
    ");
 * 
 */
 ?>

<div class="waiting"><!-- Place at bottom of page --></div>