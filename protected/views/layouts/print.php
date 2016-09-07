<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
</head>
<body>
<div class="container" id="page">

        <div id="menu">
        <?php $this->widget('bootstrap.widgets.TbNavbar', array(
            //'type'=>'', // null or 'inverse'
            'brand'=>'',
            'brandUrl'=>'',
            'collapse'=>true, // requires bootstrap-responsive.css
            'items'=>array(
                array(
                    'class'=>'bootstrap.widgets.TbMenu',
                    'items'=>array(
                        array('label'=>'Home', 'icon'=>'home', 'url'=>Yii::app()->urlManager->createUrl('site/index'), 'active'=>$this->id .'/'. $this->action->id=='site/index'?true:false),
                        array('label'=>'Invoice', 'icon'=>'th', 'url'=>Yii::app()->urlManager->createUrl('invoice/admin'), 'active'=>$this->id .'/'. $this->action->id=='invoice/admin'?true:false),
                        array('label'=>'Customer', 'icon'=>'user', 'url'=>Yii::app()->urlManager->createUrl('client/admin'), 'active'=>$this->id .'/'. $this->action->id=='client/admin'?true:false),
                        array('label'=>'Item', 'icon'=>'briefcase', 'url'=>Yii::app()->urlManager->createUrl('item/admin'), 'active'=>$this->id .'/'. $this->action->id=='item/admin'?true:false),
                        array('label'=>'Supplier', 'icon'=>'user', 'url'=>Yii::app()->urlManager->createUrl('supplier/admin'), 'active'=>$this->id .'/'. $this->action->id=='supplier/admin'?true:false),
                        //array('label'=>'Debter', 'icon'=>'user', 'url'=>Yii::app()->urlManager->createUrl('debtcollector/admin'), 'active'=>$this->id .'/'. $this->action->id=='debtcollector/admin'?true:false),
                        array('label'=>'Sale', 'icon'=>'tags', 'url'=>Yii::app()->urlManager->createUrl('saleitem/admin'), 'active'=>$this->id .'/'. $this->action->id=='saleitem/admin'?true:false),
                        array('label'=>'Report', 'icon'=>'signal', 'url'=>Yii::app()->urlManager->createUrl('invoice/report'), 'active'=>$this->id .'/'. $this->action->id=='invoice/report'?true:false),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')','icon'=>'user', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                ),
            )
            ));
         ?> 
        </div>
        
        <div id="ibreak"><br /><br /></div>   
     
	<?php echo $content; ?>

	<div class="clear"></div>
        
</div><!-- page -->   
</body>
</html>
