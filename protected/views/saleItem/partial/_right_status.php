<?php if (isset($table_info)) { ?>
    <span class="label label-info label-xlg">
        <?php echo '<b>' .  $table_info->name  .' - ' . Common::GroupAlias(Yii::app()->orderingCart->getGroupId()) . '</b>'; ?>
        <i class="ace-icon fa fa-clock-o"></i>
        <?= $time_go; ?>
    </span>
<?php } ?>

<?php if (isset($ordering_status)) { ?>

    <span class="order-status <?php echo $ordering_status_span; ?>">
        <i class="<?php echo $ordering_status_icon; ?>"></i>
        <?= $ordering_msg; ?>
    </span>

    <?php if ($ordering_status=='2') { ?>

        <?php echo TbHtml::linkButton(Yii::t('app', 'Confirm'), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_MINI,
            'icon' => ' ace-icon fa fa-floppy-o white',
            'class' => 'btn-confirm-order',
            'url' => Yii::app()->createUrl('SaleItem/confirmOrder'),
            'title' => Yii::t('app', 'Confirm Order'),
        )); ?>

    <?php } ?>

<?php } ?>

