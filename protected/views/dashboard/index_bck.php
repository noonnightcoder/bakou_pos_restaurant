<?php
$this->breadcrumbs=array(
	Yii::t('app','Dashboard'),
);
?>
<?php
    $date = array();
    $sub_total = array();
    $total = array();
    foreach($report->saleDailyChart() as $record)
    {
        $date[] = $record["date"];
        $sub_total[] = floatval($record["sub_total"]);
        $total[] = floatval($record["total"]);
    }
?>
    <div class="">
            <div class="row">
                <!--PAGE CONTENT BEGINS-->
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 widget-container-col summary_header">

                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active">
                                        <a data-toggle="tab" href="#today">
                                            <i class="green ace-icon fa fa-calendar-o bigger-120"></i>
                                            <?= Yii::t('app','Today'); ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#yesterday">
                                            <i class="orange ace-icon fa fa-calendar-o bigger-120"></i>
                                            <?= Yii::t('app','Yesterday'); ?>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <div id="today" class="tab-pane fade in active">
                                        <?php foreach($report->grossSaleAmount() as $record) { ?>
                                            <?php
                                                $stat_css = $record['diff_percent'] > 0 ?  'stat-success' : 'stat-important';
                                                $infobox_css = $record['diff_percent'] > 0 ?  'infobox-green' : 'infobox-red';
                                            ?>
                                            <div class="infobox <?= $infobox_css; ?>">
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link('Gross Sale', Yii::app()->createUrl("report/SaleReportTab")); ?></div>
                                                </div>
                                                <!-- /section:pages/dashboard.infobox.stat -->
                                                <div class="stat <?= $stat_css; ?>">
                                                    <?= $record['diff_percent']; ?> %
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php foreach($report->saleInvoice2dVsLW() as $record) { ?>
                                            <?php
                                                $stat_css = $record['diff_percent'] > 0 ?  'stat-success' : 'stat-important';
                                                $infobox_css = $record['diff_percent'] > 0 ?  'infobox-blue' : 'infobox-red';
                                            ?>


                                            <div class="infobox <?= $infobox_css; ?>">
                                                <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-file"></i>
                                                </div>
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?=  number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link('Number of Invoices', Yii::app()->createUrl("report/SaleReportTab")); ?></div>
                                                </div>
                                                <!-- /section:pages/dashboard.infobox.stat -->
                                                <div class="stat <?= $stat_css; ?>">
                                                    <?= $record['diff_percent']; ?> %
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php foreach($report->avgInvoice2dVsLW() as $record) { ?>
                                            <?php
                                            $stat_css = $record['diff_percent'] > 0 ?  'stat-success' : 'stat-important';
                                            $infobox_css = $record['diff_percent'] > 0 ?  'infobox-green' : 'infobox-red';
                                            ?>

                                            <div class="infobox <?= $infobox_css; ?>">
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link('Average Invoices', Yii::app()->createUrl("report/SaleReportTab")); ?></div>
                                                </div>
                                                <!-- /section:pages/dashboard.infobox.stat -->
                                                <div class="stat <?= $stat_css; ?>">
                                                    <?= $record['diff_percent']; ?> %
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php foreach($report->ordering(0,1) as $record) { ?>

                                            <div class="infobox infobox-orange2">
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?= number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link('# of New Ordering', Yii::app()->createUrl("saleIndex")); ?></div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php foreach($report->ordering(0,0) as $record) { ?>

                                            <div class="infobox infobox-green">
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?= number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link('# of Checked Out', Yii::app()->createUrl("saleIndex")); ?></div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                     </div>

                                    <div id="yesterday" class="tab-pane fade">
                                        <?php foreach($report->grossSaleAmount(1) as $record) { ?>
                                            <?php
                                                $stat_css = $record['diff_percent'] > 0 ?  'stat-success' : 'stat-important';
                                                $infobox_css = $record['diff_percent'] > 0 ?  'infobox-green' : 'infobox-red';
                                            ?>
                                            <div class="infobox <?= $infobox_css; ?>">
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link( date('l',time() - 60 * 60 * 24) . ' Gross Sale', Yii::app()->createUrl("report/SaleReportTab")); ?></div>
                                                </div>
                                                <!-- /section:pages/dashboard.infobox.stat -->
                                                <div class="stat <?= $stat_css; ?>">
                                                    <?= $record['diff_percent']; ?> %
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php foreach($report->saleInvoice2dVsLW(1) as $record) { ?>
                                            <?php
                                                $stat_css = $record['diff_percent'] > 0 ?  'stat-success' : 'stat-important';
                                                $infobox_css = $record['diff_percent'] > 0 ?  'infobox-blue' : 'infobox-red';
                                            ?>


                                            <div class="infobox <?= $infobox_css; ?>">
                                                <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-file"></i>
                                                </div>
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?=  number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link(date('l',time() - 60 * 60 * 24) . ' # of Invoices', Yii::app()->createUrl("report/SaleReportTab")); ?></div>
                                                </div>
                                                <!-- /section:pages/dashboard.infobox.stat -->
                                                <div class="stat <?= $stat_css; ?>">
                                                    <?= $record['diff_percent']; ?> %
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php foreach($report->avgInvoice2dVsLW(1) as $record) { ?>
                                            <?php
                                            $stat_css = $record['diff_percent'] > 0 ?  'stat-success' : 'stat-important';
                                            $infobox_css = $record['diff_percent'] > 0 ?  'infobox-green' : 'infobox-red';
                                            ?>

                                            <div class="infobox <?= $infobox_css; ?>">
                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($record['amount'],Yii::app()->shoppingCart->getDecimalPlace()); ?></span>
                                                    <div class="infobox-content"><?= CHtml::link(date('l',time() - 60 * 60 * 24) . ' Average Invoices', Yii::app()->createUrl("report/SaleReportTab")); ?></div>
                                                </div>
                                                <!-- /section:pages/dashboard.infobox.stat -->
                                                <div class="stat <?= $stat_css; ?>">
                                                    <?= $record['diff_percent']; ?> %
                                                </div>
                                            </div>
                                        <?php } ?>

                                     </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="space-8"></div>

                    <div class="row">
                        <div class="col-xs-12 widget-container-col">
                            <div class="widget-box widget-color-blue2">
                                <div class="widget-header widget-header-flat">
                                    <h5 class="widget-title bigger lighter">
                                        <i class="ace-icon fa fa-bar-chart-o"></i>
                                        <?php echo Yii::t('app','Daily Sale\'s Chart'); ?>
                                    </h5>
                                    <div class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <?php
                                    $this->widget(
                                        'yiiwheels.widgets.highcharts.WhHighCharts',
                                        array(
                                            'pluginOptions' => array(
                                                //'chart'=> array('type'=>'bar'),
                                                'title'  => array('text' => Yii::t('app','Daily Sale') - date('M Y')),
                                                'xAxis'  => array(
                                                    'categories' => $date
                                                ),
                                                'yAxis'  => array(
                                                    'title' => array('text' => 'Amount in Riel')
                                                ),
                                                'series' => array(
                                                    array('name'=> 'Sub Total' , 'data' => $sub_total),
                                                    array('name'=> 'Total' ,'data' => $total),
                                                )
                                            )
                                        )
                                    );
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-8"></div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 widget-container-col">
                            <div class="widget-box widget-color-blue2">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">
                                        <i class="ace-icon fa fa-trophy"></i>
                                        <?php echo Yii::t('app','This Year Top 10 Food ') . Yii::t('app','Ranked by QUANTITY'); ?>
                                    </h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">

                                        <?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
                                            'id'=>'top-product-grid-qty',
                                            'fixedHeader' => true,
                                            'responsiveTable' => true,
                                            'type'=>TbHtml::GRID_TYPE_BORDERED,
                                            'dataProvider'=>$report->dashtopFood(),
                                            //'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','This Year Top 10 Food ') . Yii::t('app','Ranked by QUANTITY') .'</p>',
                                            'summaryText' => '',
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
                                                    'value'=>'number_format($data["qty"],Yii::app()->shoppingCart->getDecimalPlace())',
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
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 widget-container-col">
                            <div class="widget-box widget-color-blue2">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">
                                        <i class="ace-icon fa fa-trophy"></i>
                                        <?php echo Yii::t('app','This Year Top 10 Beverage ') . Yii::t('app','Ranked by QUANTITY'); ?>
                                    </h5>

                                </div>
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
                                            'id'=>'top-product-grid-amount',
                                            'fixedHeader' => true,
                                            'responsiveTable' => true,
                                            'type'=>TbHtml::GRID_TYPE_BORDERED,
                                            'dataProvider'=>$report->dashtopBeverage(),
                                            //'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','This Year Top 10 Beverage ') . Yii::t('app','Ranked by QUANTITY') .'</p>',
                                            'summaryText' => '',
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
                                </div>
                            </div>
                        </div>

                    </div>

                </div><!--/row-->
            </div>
    </div>
          
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

<!--http://stackoverflow.com/questions/5052543/how-to-fire-ajax-request-periodically-->

<!--http://stackoverflow.com/questions/13668484/warn-user-when-new-data-is-inserted-on-database-->

<!--<script>
(function worker() {
    $.ajax({
        url: 'AjaxRefresh',
        success: function(data) {
            $('.summary_header').html(data);
        },
        complete: function() {
            // Schedule the next request when the current one's complete
            setTimeout(worker, 10000);
        }
    });
})();
</script>-->

