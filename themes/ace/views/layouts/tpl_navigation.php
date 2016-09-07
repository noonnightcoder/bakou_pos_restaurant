<?php
$this->pageTitle = Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl;
/*
$location = Location::model()->findByPk(Yii::app()->session['location_id']);
if ($location) {
    Yii::app()->session['location_name'] = $location->name;
}
 * 
*/
?>
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
            </button>

            <!-- /section:basics/sidebar.mobile.toggle -->
            <div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand -->
                    <a href="<?php echo Yii::app()->createUrl('dashboard/view') ?>" class="navbar-brand">
                            <small>
                                    <i class="fa fa-leaf"></i>
                                    Ezy Tool
                            </small>
                    </a>

                    <!-- /section:basics/navbar.layout.brand -->

                    <!-- #section:basics/navbar.toggle -->

                    <!-- /section:basics/navbar.toggle -->
            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                            
                        <!-- #section:basics/navbar.user_menu -->
                        <li class="green">
                            <a href="#"><?php echo Yii::app()->settings->get('site', 'companyName'); ?>
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="label label-xlg label-important"><?php echo Yii::app()->getsetSession->getLocationName(); ?></span>
                            </a>
                        </li>
                        <li class="white">
                            <i class="glyphicon glyphicon-time"></i>
                            <span class="">
                                <?php  echo date("H:i j M Y"); ?>
                            </span>
                        </li>
                        <li class="light-blue">
                                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                    <span class="user-info">
                                            <small><?= Yii::t('app','Welcome'); ?>,</small>
                                            <?php echo CHtml::encode(ucwords(Yii::app()->user->name)); ?>
                                    </span>
                                    <i class="ace-icon fa fa-caret-down"></i>
                                </a>

                                <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                    <li>
                                        <a href="<?php echo Yii::app()->urlManager->createUrl('RbacUser/Update', array('id' => Yii::app()->user->id)); ?>">
                                                <i class="ace-icon fa fa-key"></i>
                                                <?= Yii::t('app','Change Password'); ?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                  
                                    <li>
                                        <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>">
                                            <i class="ace-icon fa fa-power-off"></i>
                                            <?= Yii::t('app','Logout'); ?>
                                        </a>
                                    </li>
                                  
                                </ul>
                        </li>

                            <!-- /section:basics/navbar.user_menu -->
                    </ul>
            </div>

            <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>