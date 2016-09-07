<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>Yii::t('app','Sales Summary'),'id'=>'tab_2_1', 'content'=>$this->renderPartial('sale_summary', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true), 'active'=>true),
        array('label'=>Yii::t('app','Top Product'),'id'=>'tab_2_2', 'content'=>$this->renderPartial('topproduct', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true)),
        ////array('label'=>Yii::t('app','Monthly Sales'),'id'=>'tab_2_3', 'content'=>'Loading, please wait..'),
        array('label'=>Yii::t('app','Daily Sales'),'id'=>'tab_2_4', 'content'=>$this->renderPartial('sale_daily', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true)),
        ////array('label'=>Yii::t('app','Hourly Sales'),'id'=>'tab_2_5', 'content'=>$this->renderPartial('sale_hourly', array('report'=>$report,'to_date'=>$to_date),true)),
        ////array('label'=>Yii::t('app','Payment Collected'),'id'=>'tab_2_6', 'content'=>$this->renderPartial('payment', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true)),
        ////array('label'=>Yii::t('app','Daily Profit'),'id'=>'tab_2_7', 'content'=>$this->renderPartial('sale_daily_profit', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true)),
        ////array('label'=>Yii::t('app','Monthly Profit'),'id'=>'tab_2_8', 'content'=>$this->renderPartial('sale_monthly_profit', array('report'=>$report),true)),
    ),
    //'events'=>array('shown'=>'js:loadContent')
)); ?>