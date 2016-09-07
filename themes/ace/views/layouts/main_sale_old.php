<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
    ?>
    <?php Yii::app()->bootstrap->register(); ?>
     <script>
        var BASE_URL="<?php print Yii::app()->request->baseUrl;?>";
    </script>
    
    <link rel="icon" type="image/ico" href="<?php echo $baseUrl ?>/css/img/bakouicon.ico" />
    
    <!-- bootstrap & fontawesome -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
     <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
     <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-skins.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-rtl.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-ie.min.css" />
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/loading_animation.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/colorbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery-ui-1.10.4.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/keyboard.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery.bxslider.css" />
    <?php
        $cs->registerScriptFile($baseUrl.'/js/ace-extra.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.slimscroll.min.js',CClientScript::POS_END); 
        $cs->registerScriptFile($baseUrl.'/js/jquery.bxslider.min.js',CClientScript::POS_END); 
        $cs->registerScriptFile($baseUrl.'/js/jquery.colorbox-min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/ace-elements.min.js',CClientScript::POS_END);  
        $cs->registerScriptFile($baseUrl.'/js/ace.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.jkey.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/common.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.keyboard.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/holder.js',CClientScript::POS_END);
    ?>
    
</head>

<body class="no-skin">
    <div id="menu">
        <!-- #section:basics/navbar.layout -->
        <section id="navigation-main">  
        <!-- Require the navigation -->
        <?php require_once('tpl_navigation.php')?>
        </section> <!-- /#navigation-main --> 
    </div> <!--/ menu -->

    <section class="main-body">
        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container"> 
            <!-- #section:basics/sidebar.mobile.toggle -->
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>
            <!-- #section:basics/sidebar -->
            <div class="sidebar menu-min responsive" id="sidebar">
                <?php require_once('tpl_sidebar.php')?>
            </div> <!-- /#side-bar --> 

            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="breadcrumbs" id="breadcrumbs">
                        <?php if(isset($this->breadcrumbs)):?>
                              <?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                                    'links' => $this->breadcrumbs,
                              )); ?>
                        <?php endif?>

                        <div class="nav-search" id="nav-search">
                                <form class="form-search" />
                                        <span class="input-icon">
                                                <input type="text" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
                                                <i class="icon-search nav-search-icon"></i>
                                        </span>
                                </form>
                        </div><!--#nav-search-->
                </div>

                <div class="page-content">
                    <div class="row">
                      <div class="col-xs-12">
                        <!-- Include content pages -->
                        <?php echo $content; ?>
                      </div>
                    </div>
                </div>

            </div> <!--/.main-content-->
            <!-- Require the footer -->
            <?php require_once('tpl_footer.php')?>
            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!--/.main-container-->
    </section> <!--/.main-body-->
 </body>
</html>