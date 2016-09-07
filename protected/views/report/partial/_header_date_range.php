<label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
<div class="input-group">
    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
        'attribute' => 'from_date',
        'model' => $report,
        'pluginOptions' => array(
            'format' => 'dd-mm-yyyy',
        )
    ));
    ?>
    <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
</div>

<label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
<div class="input-group">
    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
        'attribute' => 'to_date',
        'model' => $report,
        'pluginOptions' => array(
            'format' => 'dd-mm-yyyy'
        )
    ));
    ?>
    <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
</div>
