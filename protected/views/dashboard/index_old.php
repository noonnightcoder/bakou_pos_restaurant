<?php
$this->breadcrumbs=array(
	'Dashboard',
);
?>
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
    <div class="row">
            <div class="span12">
                    <!--PAGE CONTENT BEGINS-->
                     <div class="row-fluid">
                        <div class="span11">
                            <?php 
                            $this->widget(
                                'yiiwheels.widgets.highcharts.WhHighCharts',
                                array(
                                    'pluginOptions' => array(
                                        //'chart'=> array('type'=>'bar'),
                                        'title'  => array('text' => Yii::t('app','Daily Sales')),
                                        'xAxis'  => array(
                                            'categories' => $date
                                        ),
                                        'yAxis'  => array(
                                            'title' => array('text' => 'Amount in Riel')
                                        ),
                                        'series' => array(
                                            array('name'=>'Date - ' .  date('M Y'),'data' => $amount),
                                        )
                                    )
                                )
                            ); 
                            ?>
                        </div><!--/span-->
                    </div>


                    <div class="row-fluid">
                            <div class="span6">
                                    <?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
                                        'id'=>'top-product-grid-qty',
                                        'fixedHeader' => true,
                                        'responsiveTable' => true,
                                        'type'=>TbHtml::GRID_TYPE_BORDERED,
                                        'dataProvider'=>$report->dashtopFood(),
                                        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','This Year Top 10 Food ') . Yii::t('app','Ranked by QUANTITY') .'</p>', 
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

                            <div class="span6">
                                    <?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
                                        'id'=>'top-product-grid-amount',
                                        'fixedHeader' => true,
                                        'responsiveTable' => true,
                                        'type'=>TbHtml::GRID_TYPE_BORDERED,
                                        'dataProvider'=>$report->dashtopBeverage(),
                                        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','This Year Top 10 Beverage ') . Yii::t('app','Ranked by QUANTITY') .'</p>', 
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

            </div><!--/row-->

    </div><!--/.row-fluid-->
          
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

