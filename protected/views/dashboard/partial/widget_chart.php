<div class="row">
    <div class="col-xs-12 widget-container-col">
        <div class="widget-box widget-color-blue2">
            <div class="widget-header widget-header-flat">
                <h5 class="widget-title bigger lighter">
                    <i class="ace-icon fa fa-bar-chart-o"></i>
                    <?php echo Yii::t('app','Daily Sale\'s Chart' ); ?>
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
                            'title'  => array('text' => Yii::t('app','Daily Sale') . '-' . date('M Y')),
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
