<?php
    $report=new Report;
    $this->pageTitle=Yii::app()->name;
    $baseUrl = Yii::app()->theme->baseUrl; 
?>
<?php
    list($count_12, $qty_12)=$report->itemExpiryCount(12);
    list($count_6, $qty_6)=$report->itemExpiryCount(6);
    list($count_5, $qty_5)=$report->itemExpiryCount(5);
    list($count_4, $qty_4)=$report->itemExpiryCount(4);
    list($count_3, $qty_3)=$report->itemExpiryCount(3);
    list($count_2, $qty_2)=$report->itemExpiryCount(2);
    list($count_1, $qty_1)=$report->itemExpiryCount(1);
?>

<div class="navbar">
        <div class="navbar-inner">
                <div class="container-fluid">  
                        <?php $this->widget('bootstrap.widgets.TbNavbar', array(
                            //'brandLabel'=>'<img src="'. $baseUrl . '/css/images/logo-text2.png" width="88" height="60" alt="Bakou">',
                            'brandLabel' => '<small><i class="icon-leaf"></i> Bakou Point Of Sale</small>',
                            'display' => null, // default is static to to
                            //'collapse' => true,
                            'items' => array(
                                array(
                                    'class' => 'bootstrap.widgets.TbNav',
                                    'htmlOptions'=>array('class'=>'ace-nav pull-right'),
                                    'submenuHtmlOptions'=>array('class'=>'pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer'),
                                    'encodeLabel' => false,
                                    'items' => array(
                                        array('label' =>'<span class="badge badge-grey">4</span>','icon'=>'tasks','class'=>'grey',
                                                'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                                                    'items'=>array(
                                                        array('label' => '4 Tasks Complete','icon'=>'ok','class'=>'nav-header'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left">Software Update</span><span class="pull-right">65%</span></div> <div class="progress progress-mini"><div style="width:65%" class="bar"></div></div>', 'url' => '#'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left">Hardware Upgrade</span><span class="pull-right">35%</span></div> <div class="progress progress-mini progress-danger"><div style="width:35%" class="bar"></div></div>', 'url' => '#'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left">Unit Testing</span><span class="pull-right">15%</span></div> <div class="progress progress-mini progress-warning"><div style="width:15%" class="bar"></div></div>', 'url' => '#'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left">Bug Fixes</span><span class="pull-right">90%</span></div> <div class="progress progress-mini progress-success"><div style="width:90%" class="bar"></div></div>', 'url' => '#'),
                                                    ),
                                        ),
                                        array('label' =>'<span class="badge badge-important">8<span>','icon'=>'bell-alt animated-bell','class'=>'purple',
                                                'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                                                    'items'=>array(
                                                        array('label' => '8 Notifications','icon'=>'warning-sign','class'=>'nav-header'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left"><i class="btn btn-mini no-hover btn-pink icon-comment"></i>Expire within '. $count_1 . ' month</span><span class="pull-right badge badge-info">'. $qty_1 .'</span></div>', 'url' => '#'),
                                                        array('label' => '<i class="btn btn-mini btn-primary icon-user"></i>Bob just signed up as an editor ...', 'url' => '#'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left"><i class="btn btn-mini no-hover btn-success icon-shopping-cart"></i>New Orders</span><span class="pull-right badge badge-success">+8</span></div>', 'url' => '#'),
                                                        array('label' => '<div class="clearfix"><span class="pull-left"><i class="btn btn-mini no-hover btn-info icon-twitter"></i> Followers</span><span class="pull-right badge badge-info">+11</span></div>', 'url' => '#'),
                                                        array('label' => 'See all notifications','icon'=>'arrow-right')
                                                    ),
                                        ),
                                        array('label' =>'5','icon'=>'envelope animated-vertical','class'=>'green', 'url' => '#'),
                                        array('label' =>'<img class="nav-user-photo" alt="Jasos Photo" src="'. Yii::app()->theme->baseUrl .'/avatars/user.jpg" /><span class="user-info"><small>Welcome,</small>'. ucwords(Yii::app()->user->name). '</span>','class'=>'light-blue', 'url' => '#',
                                              'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                                                'items'=>array(
                                                        array('label' => Yii::t('app','Profile'),'icon'=> TbHtml::ICON_USER, 'url' => Yii::app()->urlManager->createUrl('Employee/View',array('id'=>Yii::app()->session['employeeid'])) ),
                                                        array('label' => Yii::t('app','Change Password'),'icon'=>  TbHtml::ICON_EDIT, 'url' => Yii::app()->urlManager->createUrl('RbacUser/Update',array('id'=>Yii::app()->user->id)) ),
                                                        array('label' => Yii::t('app', 'Logout') . ' (Alt+Q)','icon'=> TbHtml::ICON_OFF, 'url' => array('/site/logout')),
                                                 ),
                                                
                                        ),
                                    ),
                                ),
                            ),
                        )); ?>
                </div><!--/.container-fluid-->
        </div><!--/.navbar-inner-->
</div>
