<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />     
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
        $baseUrl = Yii::app()->theme->baseUrl; 
        $cs = Yii::app()->getClientScript();
      //Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <?php Yii::app()->bootstrap->registerCoreCss(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/style-blue.css" />
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
	<?php 
	  $cs->registerCssFile($baseUrl.'/css/abound.css');
	?>
        <!-- styles for style switcher -->
  </head>

<body>
    
<section class="main-body">
    <div>
            <!-- Include content pages -->
            <?php echo $content; ?>
    </div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>

</body>
</html>