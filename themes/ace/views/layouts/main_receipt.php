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
    <?php //Yii::app()->bootstrap->register(); ?>
     <script>
        var BASE_URL="<?php print Yii::app()->request->baseUrl;?>";
    </script>
    
    <link rel="icon" type="image/ico" href="<?php echo $baseUrl ?>/css/img/bakouicon.ico" />
    
    <!-- printing style -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php//echo $baseUrl ?>/css/print.css" /> -->
    
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- page specific plugin styles -->
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-part2.min.css" />
    <![endif]-->
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/ace-skins.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/ace-rtl.min.css" /> -->
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-ie.min.css" />
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/loading_animation.css" />
   
    <?php 
        if (Yii::app()->components['user']->loginRequiredAjaxResponse){
            Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
                jQuery("body").ajaxComplete(
                    function(event, request, options) {
                        if (request.responseText == "'.Yii::app()->components['user']->loginRequiredAjaxResponse.'") {
                            window.location.href = options.url;
                        }
                    }
                );
            ');
        }
    ?>
</head>

<body class="no-skin">
    <div class="main-container" id="main-container">
        <div class="row">
          <div class="col-xs-12">
            <!-- Include content pages -->
            <?php echo $content; ?>
          </div>
        </div>
    </div> <!--/.main-container-->
</body>
</html>