<li class="dropdown-header new-order-dropdown-header">
    <i class="ace-icon fa fa-exclamation-triangle"></i>
    <?php echo $sale_order->countNewOrder(); ?> New Orders
</li>

<li class="dropdown-content new-order-menu">
    <ul class="dropdown-menu dropdown-navbar navbar-pink" id="new_order_menu">
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