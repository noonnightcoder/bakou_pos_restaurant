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