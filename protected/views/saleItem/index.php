<style>
    .table-btn {
        margin-left: 10px;
        margin-bottom: 12px;
    }
</style>

<?php //$this->widget('ext.modaldlg.EModalDlg'); ?>

<div id="register_container">

    <?php $this->renderPartial('partial/_left_panel',
        array(
            'model' => $model,
            'tables' => $tables,
            'zones' => $zones,
            'table_id' => $table_id,
            'zone_id' => $zone_id
        )); ?>

    <?php $this->renderPartial('partial/_right_panel', array(
        'model' => $model,
        'table_info' => $table_info,
        'items' => $items,
        'sub_total' => $sub_total,
        'amount_due' => $amount_due,
        'count_payment' => $count_payment,
        'payments' => $payments,
        'count_item' => $count_item,
        'location_id' => $location_id,
        'time_go' => $time_go,
        'print_categories' => $print_categories,
        'ordering_status' => $ordering_status,
        'ordering_msg' => $ordering_msg,
        'ordering_status_span' => $ordering_status_span,
        'ordering_status_icon' =>  $ordering_status_icon,
        'giftcard_info' => $giftcard_info,
        'giftcard_id' => $giftcard_id
    )); ?>

    <?php $this->renderPartial('partial/_js'); ?>

</div>



