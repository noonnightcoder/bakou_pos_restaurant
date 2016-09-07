<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
   <meta charset="utf-8" />
   <title><?php echo CHtml::encode($this->pageTitle); ?></title>
   <meta name="description" content="overview &amp; stats" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
    ?>
    <?php Yii::app()->bootstrap->registerCoreCss(); ?>
    <?php //Yii::app()->bootstrap->registerResponsiveCss(); ?>
     <script>
        var BASE_URL="<?php print Yii::app()->request->baseUrl;?>";
    </script>
   
    <!-- fontawesome --> 
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.onpage-help.css" />
  
    <?php /*
        $cs=Yii::app()->clientScript;
        $cs->registerCssFile($baseUrl .'/css/font-awesome.min.css');
        $cs->registerCssFile($baseUrl .'/css/ace.min.css');

        $cs->scriptMap=array(
             'font-awesome.min.css'=>$baseUrl. '/css/all_login.css',
             'ace.min.css'=> $baseUrl. '/css/all_login.css',
        );
      * 
      */
    ?>
</head>

<body class="login-layout">
<section class="main-body">
     <div class="main-container">
        <!-- Include content pages -->
        <?php echo $content; ?>
    </div>
</section>
</body>
</html>