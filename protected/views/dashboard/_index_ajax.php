<?php
    $records=$report->saleDailyChart();
    $date = array();
    $amount = array();
    foreach($records as $record) 
    {
        $amount[] = floatval($record["amount"]);
        $date[] = $record["date"];
    }
?>
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


