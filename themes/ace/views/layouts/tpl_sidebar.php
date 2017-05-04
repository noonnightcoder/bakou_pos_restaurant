<!--
<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <?php //echo TbHtml::linkButton('', array('url'=>Yii::app()->urlManager->createUrl('settings/index'),'color' => TbHtml::BUTTON_COLOR_DANGER,'icon'=>'ace-icon fa fa-cog','size'=> TbHtml::BUTTON_SIZE_SMALL)); ?>
        <?php //echo TbHtml::linkButton('', array('url'=>Yii::app()->urlManager->createUrl('client/admin'),'color' => TbHtml::BUTTON_COLOR_WARNING,'icon'=>'ace-icon fa fa-group','size'=> TbHtml::BUTTON_SIZE_SMALL)); ?>
        <?php //echo TbHtml::linkButton('', array('url'=>Yii::app()->urlManager->createUrl('report/SaleReportTab'),'color' => TbHtml::BUTTON_COLOR_SUCCESS,'icon'=>'ace-icon fa fa-signal','size'=> TbHtml::BUTTON_SIZE_SMALL)); ?>
        <?php //echo TbHtml::linkButton('', array('url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice'),'color' => TbHtml::BUTTON_COLOR_INFO,'icon'=>'ace-icon fa fa-pencil','size'=> TbHtml::BUTTON_SIZE_SMALL)); ?>
    </div>
    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>
            <span class="btn btn-info"></span>
            <span class="btn btn-warning"></span>
            <span class="btn btn-danger"></span>
    </div>
</div>
<!--#sidebar-shortcuts-->

<?php 
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_LIST,
    'submenuHtmlOptions'=>array('class'=>'submenu'),
    'encodeLabel' => false,
    'items' => array(
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Dashboard')) . '</span>', 'icon'=>'menu-icon fa fa-tachometer', 'url'=>Yii::app()->urlManager->createUrl('dashboard/view'), 'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                'visible'=>Yii::app()->user->checkAccess('report.index')),
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Item')) . '</span>', 'icon'=>'menu-icon fa fa-coffee', 'url'=>Yii::app()->urlManager->createUrl('item/admin'), 'active'=>$this->id =='item',
                'visible'=> Yii::app()->user->checkAccess('item.index') || Yii::app()->user->checkAccess('item.create') || Yii::app()->user->checkAccess('item.update') || Yii::app()->user->checkAccess('item.delete')),  
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Sale')) . ' (F2) ' . '</span>', 'icon'=>'menu-icon fa fa-shopping-cart', 'url'=>Yii::app()->urlManager->createUrl('saleItem/index'), 'active'=>$this->id .'/'. $this->action->id=='saleItem/index','visible'=>Yii::app()->user->checkAccess('sale.edit')),
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Report')) .'</span>', 'icon'=>'menu-icon fa fa-signal', 'url'=>Yii::app()->urlManager->createUrl('report/reporttab'),
                    'active'=>$this->id =='report',
                    'visible'=>Yii::app()->user->checkAccess('report.index'),
                'items'=>array(
                    array('label'=>Yii::t('app','Sale Invoice'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleInvoice'
                    ),
                    array('label'=>Yii::t('app','Daily Sale'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleDaily'),
                        'active'=>$this->id .'/'. $this->action->id == 'report/SaleDaily'
                    ),
                    array('label'=>Yii::t('app','Sale Item Summary'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleItemSummary'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleItemSummary'
                    ),
                    array('label'=>Yii::t('app','Close Register'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleDailyBySaleRep'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleDailyBySaleRep'
                    ),
                    array('label'=>Yii::t('app','User Log Summary'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/UserLogSummary'),
                        'active'=>$this->id .'/'. $this->action->id =='report/UserLogSummary'
                    ),
            )),
            array('label'=>'<span class="menu-text">'. strtoupper(Yii::t('app','Setting')) . '</span>', 'icon'=>'menu-icon fa fa-cogs','url'=>Yii::app()->urlManager->createUrl('settings/index'),
                    'active'=>$this->id=='employee' ||  $this->id=='settings' || strtolower($this->id)=='default' || $this->id=='store' ||  $this->id=='zone' || $this->id=='desk' ||  $this->id=='location' || $this->id=='priceTier' || $this->id=='giftcard' || $this->id=='category',
                    'visible'=>Yii::app()->user->checkAccess('store.update'),
                           'items'=>array(
                               array('label'=>Yii::t('app', 'Employee'), 'icon'=> TbHtml::ICON_USER, 'url'=>Yii::app()->urlManager->createUrl('employee/admin'), 'active'=>$this->id =='employee',
                                    'visible'=> Yii::app()->user->checkAccess('employee.index') || Yii::app()->user->checkAccess('employee.create') || Yii::app()->user->checkAccess('employee.update') || Yii::app()->user->checkAccess('employee.delete')),
                               array('label'=>Yii::t('app','Branch'),'icon'=> TbHtml::ICON_HOME, 'url'=>Yii::app()->urlManager->createUrl('location/admin'), 'active'=>$this->id .'/'. $this->action->id=='location/admin',
                                   'visible'=> Yii::app()->user->checkAccess('branch.index') || Yii::app()->user->checkAccess('branch.create') || Yii::app()->user->checkAccess('branch.update') || Yii::app()->user->checkAccess('branch.delete')),
                               array('label'=>Yii::t('app','Zone'),'icon'=> TbHtml::ICON_GLOBE, 'url'=>Yii::app()->urlManager->createUrl('zone/admin'), 'active'=>$this->id .'/'. $this->action->id=='zone/admin',
                                    'visible'=> Yii::app()->user->checkAccess('zone.index') || Yii::app()->user->checkAccess('zone.create') || Yii::app()->user->checkAccess('zone.update') || Yii::app()->user->checkAccess('zone.delete')),
                               array('label'=>Yii::t('app','Table'),'icon'=> 'ace-icon fa fa-square-o', 'url'=>Yii::app()->urlManager->createUrl('desk/admin'), 'active'=>$this->id .'/'. $this->action->id=='desk/admin',
                                    'visible'=> Yii::app()->user->checkAccess('zone.index') || Yii::app()->user->checkAccess('zone.create') || Yii::app()->user->checkAccess('zone.update') || Yii::app()->user->checkAccess('zone.delete')),
                               array('label'=>Yii::t('app','Gift Card'),'icon'=> TbHtml::ICON_GIFT, 'url'=>Yii::app()->urlManager->createUrl('giftcard/admin'), 'active'=>$this->id .'/'. $this->action->id=='giftcard/admin',
                                   'visible'=> Yii::app()->user->checkAccess('giftcard.index') || Yii::app()->user->checkAccess('giftcard.create') || Yii::app()->user->checkAccess('giftcard.update') || Yii::app()->user->checkAccess('giftcard.delete')),
                               array('label'=>Yii::t('app','Price Tier'),'icon'=> TbHtml::ICON_ADJUST, 'url'=>Yii::app()->urlManager->createUrl('priceTier/admin'), 'active'=>$this->id .'/'. $this->action->id=='priceTier/admin',
                                   'visible'=> Yii::app()->user->checkAccess('pricetier.index') || Yii::app()->user->checkAccess('pricetier.create') || Yii::app()->user->checkAccess('pricetier.update') || Yii::app()->user->checkAccess('pricetier.delete')),
                               array('label'=>Yii::t('app', 'Category'), 'icon'=> TbHtml::ICON_LIST, 'url'=>Yii::app()->urlManager->createUrl('category/admin'), 'active'=>$this->id =='category',
                                   'visible'=> Yii::app()->user->checkAccess('item.index') || Yii::app()->user->checkAccess('item.create') || Yii::app()->user->checkAccess('item.update') || Yii::app()->user->checkAccess('item.delete')),
                               //array('label'=>Yii::t('menu','Shop Setting'),'icon'=> TbHtml::ICON_COG, 'url'=>Yii::app()->urlManager->createUrl('settings/index'), 'active'=>$this->id=='settings','visible'=>Yii::app()->user->checkAccess('store.update')),
                               //array('label'=>Yii::t('menu','Database Backup'),'icon'=> TbHtml::ICON_HDD, 'url'=>Yii::app()->urlManager->createUrl('backup/default/index'),'active'=> $this->id =='default'),
            )),
            //array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('menu', 'About US')) . '</span>', 'icon'=>'menu-icon fa fa-info-circle', 'url'=>Yii::app()->urlManager->createUrl('site/about'), 'active'=>$this->id .'/'. $this->action->id=='site/about'),
    ), 
)); 
?>

<!-- #section:basics/sidebar.layout.minimize -->
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<!-- /section:basics/sidebar.layout.minimize -->
<script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>