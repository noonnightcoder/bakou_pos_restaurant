<?php if (isset($table_info)) { ?>
    <span class="label label-info label-xlg">
        <i class="ace-icon fa fa-coffee"></i>
        <?php echo yii::t('app','Serving').   ': ' .  '<b>' .  $table_info->name  .' - ' . Common::GroupAlias(Yii::app()->orderingCart->getGroupId()) . '</b>'; ?>
    </span>
    <span class="label label-info label-xlg">
        <i class="ace-icon fa fa-clock-o"></i>
        <?= $time_go; ?>
    </span>
<?php } ?>
<?php if (isset($ordering_status)) { ?>
    <span class="<?php echo $ordering_status_span; ?>">
        <i class="<?php echo $ordering_status_icon; ?>"></i>
        <?= $ordering_msg; ?>
    </span>
<?php } ?>
