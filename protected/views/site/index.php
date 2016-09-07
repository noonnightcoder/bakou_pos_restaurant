<?php
/* @var $this SiteController */
//$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 
?>
<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' =>"<p class='text-info'>" . Yii::t('app','Welcome to Bakou Point-Of-Sale, click an icon below to rock!') . "</p>",
              'headerIcon' => 'icon-shopping-cart',
)); ?>
    
    <!--
    <blockquote style="border:none"><p class="text-info">Welcome to Bakou Point-Of-Sale, click an icon below to rock!</p>
       <small>Easiest & famous <cite title="Point of Sale System">POS in Cambodia</cite></small>
    </blockquote>
    -->
    
    <?php if (Yii::app()->user->checkAccess('sale.edit')) { ?>
    <a href="<?php echo Yii::app()->urlManager->createUrl('saleItem/index'); ?>" style="text-decoration: none"> 
        <blockquote style="border:none">
            <img src="<?php echo $baseUrl ;?>/img/sales.png" width="68" height="68" alt="Sale (F2)">
            <span class="text-info"><font size="5"><?php echo Yii::t('app','Sales') . ' (F2)'; ?></font></span>
            <small><?php echo Yii::t('app','Process sales and returns') ?></small>
        </blockquote>
    </a> 
    <?php } ?>
    
    <?php if (Yii::app()->user->checkAccess('item.index')) { ?>
    <a href="<?php echo Yii::app()->urlManager->createUrl('item/admin'); ?>" style="text-decoration: none"> 
        <blockquote style="border:none">
        <img src="<?php echo $baseUrl ;?>/img/items.png" width="68" height="68" alt="<?php echo Yii::t('app','Add, Update, Delete, and Search') . Yii::t('app','Items') ?>">
        <span class="text-info"><font size="5"><?php echo Yii::t('app','Items'); ?></font></span>
        <small><?php echo Yii::t('app','Add, Update, Delete, and Search') . Yii::t('app','Items') ?></small>
        </blockquote>
    </a> 
    <?php } ?>
    
    <?php if (Yii::app()->user->checkAccess('receiving.edit')) { ?>
    <a href="<?php echo Yii::app()->urlManager->createUrl('receivingItem/index'); ?>" style="text-decoration: none"> 
        <blockquote style="border:none">
        <img src="<?php echo $baseUrl ;?>/img/receivings.png" width="68" height="68" alt="<?php echo Yii::t('app','Process Purchase orders') ?>">
        <span class="text-info"><font size="5"><?php echo Yii::t('app','Receivings'); ?></font></span>
        <small><?php echo Yii::t('app','Process Purchase orders') ?></small>
        </blockquote>
    </a>
    <?php } ?>
    
    <?php if (Yii::app()->user->checkAccess('report.index')) { ?>
    <a href="<?php echo Yii::app()->urlManager->createUrl('report/reporttab'); ?>" style="text-decoration: none"> 
        <blockquote style="border:none">
        <img src="<?php echo $baseUrl ;?>/img/reports.png" width="68" height="68" alt="<?php echo Yii::t('app','View and generate reports') ?>">
        <span class="text-info"><font size="5"><?php echo Yii::t('app','Reports'); ?></font></span>
        <small><?php echo Yii::t('app','View and generate reports') ?></small>
        </blockquote>
    </a> 
    <?php } ?>
    
    <?php if (Yii::app()->user->checkAccess('client.index')) { ?>
    <a href="<?php echo Yii::app()->urlManager->createUrl('client/admin'); ?>" style="text-decoration: none"> 
        <blockquote style="border:none">    
            <img src="<?php echo $baseUrl ;?>/img/clients.png" width="68" height="68" alt="<?php echo Yii::t('app','Add, Update, Delete, and Search customers') ?>">
            <span class="text-info"><font size="5"><?php echo Yii::t('app','Customers'); ?></font></span>
            <small><?php echo Yii::t('app','Add, Update, Delete, and Search') . Yii::t('app','Customers') ?></small>
        </blockquote>
    </a> 
    <?php } ?>
    
    <?php if (Yii::app()->user->checkAccess('supplier.index')) { ?>
    <a href="<?php echo Yii::app()->urlManager->createUrl('supplier/admin'); ?>" style="text-decoration: none"> 
        <blockquote style="border:none">  
        <img src="<?php echo $baseUrl ;?>/img/suppliers.png" width="68" height="68" alt="<?php echo Yii::t('app','Add, Update, Delete, and Search suppliers') ?>">
        <span class="text-info"><font size="5"><?php echo Yii::t('app','Suppliers'); ?></font></span>
        <small><?php echo Yii::t('app','Add, Update, Delete, and Search') . Yii::t('app','Suppliers') ?></small>
        </blockquote>
    </a> 
    <?php } ?>
    
 <?php $this->endWidget();?>

</div