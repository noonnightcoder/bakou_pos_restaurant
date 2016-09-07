<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'left', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>Yii::t('app','Basic Info'),'id'=>'tab_1', 'content'=>$this->renderPartial('create', array('model'=>$model),true), 'active'=>true),
        array('label'=>Yii::t('app','Quantity Unit'),'id'=>'tab_1', 'content'=>$this->renderPartial('create', array('model'=>$model),true)),
        //array('label'=>Yii::t('app','Sales Reports'),'id'=>'tab_2', 'content'=>$this->renderPartial('_sale_report_tab', array('report'=>$report,'from_date'=>$from_date,'to_date'=>$to_date),true)),
        //array('label'=>Yii::t('app','Inventories'),'id'=>'tab_3', 'content'=>$this->renderPartial('inventory', array('report'=>$report,'filter'=>$filter), true)),
    ),
    //'events'=>array('shown'=>'js:loadContent')
)); ?>
</div>

<div class="waiting"><!-- Place at bottom of page -->Waiting..</div>