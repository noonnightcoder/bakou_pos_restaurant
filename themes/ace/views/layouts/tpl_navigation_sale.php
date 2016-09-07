<?php
$this->pageTitle = Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl;
$sale_order = new SaleOrder;
?>
<div id="navbar" class="navbar navbar-default navbar-collapse h-navbar">
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
            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation" id="navigation_bar">
                    <ul class="nav ace-nav">
                        <!-- #section:basics/navbar.user_menu -->
                        <li class="grey">
                            <a href="<?php echo Yii::app()->createUrl('dashboard/view') ?>">
                                <i class="glyphicon glyphicon-off"></i>
                                <small><?= Yii::t('app','Exit'); ?></small>
                            </a>
                        </li>

                        <li class="purple">
                            <a data-toggle="dropdown" class="dropdown-toggle dropdown-new-order" href="#" id ="<?php echo 'send-link-'.uniqid(); ?>">
                                <?php if ($sale_order->countNewOrder() == 0 ) {  ?>
                                    <i class="ace-icon fa fa-globe"></i>
                                <?php } else { ?>
                                    <i class="ace-icon fa fa-globe icon-animated-bell"></i>
                                <?php } ?>
                                <span class="badge badge-important count_new_order"><?php echo $sale_order->countNewOrder(); ?></span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close" id="dropdown_new_order">
                                <li class="dropdown-header new-order-dropdown-header">
                                    <i class="ace-icon fa fa-exclamation-triangle"></i>
                                    <?php echo $sale_order->countNewOrder(); ?> New Orders
                                </li>

                                <li class="dropdown-content new-order-menu">
                                    <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                        <?php foreach ($sale_order->newOrdering() as $new_order) : ?>
                                            <li>
                                                <a href="<?php echo Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$new_order['desk_id'])); ?>" class="new-order-header">
                                                    <div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
														New Orders - Table <b><?= $new_order["desk_name"]; ?></b>
													</span>
                                                        <span class="pull-right badge badge-success"><?php echo $new_order["sale_time"]; ?></span>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>

                                <li class="dropdown-footer" id="dropdown_all_order">
                                    <a href="<?php echo Yii::app()->createUrl('saleItem/setZone/',array('zone_id' => -1 )); ?>">
                                        <?= Yii::t('app','See all orders'); ?>
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="green">
                            <a href="#"><?php echo Yii::app()->settings->get('site', 'companyName'); ?>
                                <i class="ace-icon fa fa-bell"></i>
                                <span class="label label-xlg label-important"><?php echo Yii::app()->getsetSession->getLocationName(); //Yii::app()->session['location_name']; ?></span>
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
                                    <!-- <img class="nav-user-photo" alt="Jasos Photo" src="<?php //echo Yii::app()->theme->baseUrl . '/avatars/user.jpg'; ?>" /> -->
                                    <span class="user-info">
                                            <small><?= Yii::t('app','Welcome'); ?> ,</small>
                                            <?php echo CHtml::encode(ucwords(Yii::app()->user->name)); ?>
                                    </span>
                                    <i class="ace-icon fa fa-caret-down"></i>
                                </a>

                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                    <!--<li>
                                        <a href="<?php /*echo Yii::app()->urlManager->createUrl('Employee/View', array('id' => Yii::app()->session['employeeid'])); */?>">
                                                <i class="ace-icon fa fa-user"></i>
                                                Profile
                                        </a>
                                    </li>-->
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
                    </ul>
            </div>

            <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>

<!--<script>
    (function worker() {
        $.ajax({
            url: 'AjaxRefresh',
            dataType : 'json',
            success: function(data) {
                $('.count_new_order').text(data.count_new_order);
                $('#table_grid').html(data.div_order_table);
                //$('#order_menu').html(data.div_order_menu);
                //$('.order-status').text('Horray');
            },
            complete: function() {
                // Schedule the next request when the current one's complete
                setTimeout(worker, 9000);
            }
        });
    })();
</script>-->

<script type='text/javascript'>
    $('#navigation_bar').on('click','a.dropdown-new-order',function(e){
        e.preventDefault();
        $.ajax({
            url: 'AjaxF5Dropdown',
            dataType : 'json',
            success : function(data) {
                $('#dropdown_new_order').html(data.div_order_navbar);
            }
        });
    });
</script>

<script type='text/javascript'>
    $('#navigation_bar').on('click','a.new-order-header',function(e){
        e.preventDefault();
        var url=$(this).attr('href')
        $.ajax({
            url: url,
            type : 'post',
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                $('#register_container').html(data);
            }
        });
    });
</script>