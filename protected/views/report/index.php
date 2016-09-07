<?php
/*
|-----------------------------------------------------
| Report Template
|-----------------------------------------------------
|
| Header as date range
| Content as grid
|
*/
?>

<?php $this->renderPartial('partial/' . $header_view, array(
    'report' => $report,
    'advance_search' => $advance_search,
    'header_tab' => $header_tab, // Using for tab style
)); ?>

<br />

<!-- Flash message layouts.partial._flash_message -->
<?php $this->renderPartial('//layouts/alert/_flash'); ?>

<div id="report_grid">

    <?php $this->renderPartial('partial/' . $grid_view, array(
        'report' => $report,
        'data_provider' => $data_provider ,
        'grid_columns' => $grid_columns,
        'grid_id' => $grid_id,
        'title' => $title,
    )); ?>

</div>

<?php $this->renderPartial('partial/_js',array(
));?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
