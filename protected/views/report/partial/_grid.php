<div class="widget-box widget-color-blue" id="widget-box-2">

    <!--<div class="table-header">
        <?/*= $title */?>
    </div>-->

    <div class="widget-header">
    <h5 class="widget-title bigger lighter">
        <i class="ace-icon fa fa-signal"></i>
        <?= $title ?>
    </h5>

    <div class="widget-toolbar">
        <a href="<?/*= $this->createUrl('report/PrintCloseSale')*/?>" data-action="">
            <i class="ace-icon fa fa-print white"></i>
        </a>
    </div>

</div>

<?php $this->widget('EExcelView', array(
    'id' => $grid_id,
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $data_provider,
    'template' => "{items}\n{exportbuttons}\n",
    'columns' => $grid_columns,
));
?>

</div>
