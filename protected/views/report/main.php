<?php $this->renderPartial('partial/_header', array(
    'report' => $report,
    'from_date' => $from_date,
    'to_date' => $to_date
)); ?>

<br />

<div id="report_grid">

    <?php $this->renderPartial('partial/_grid', array(
        'report' => $report,
        'data_provider' => $data_provider ,
        'grid_columns' => $grid_columns,
        'grid_id' => $grid_id,
        'title' => $title,
        'from_date' => $from_date,
        'to_date' => $to_date,
    )); ?>

</div>
