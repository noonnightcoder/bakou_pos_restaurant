<?php
/*
|-----------------------------------------------------
| Report Template II
|-----------------------------------------------------
|
| Two block header search box & date range
| Content as grid
|
*/
?>

<div id="report_header">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'report-form',
        'method' => 'get',
        'action' => Yii::app()->createUrl($this->route),
        'enableAjaxValidation' => false,
        'layout' => TbHtml::FORM_LAYOUT_INLINE,
    )); ?>

        <?php $this->renderPartial('partial/_header_search_box', array(
            'report' => $report,
            'hint_text' => !isset($hint_text) ? 'Type Anything' : $hint_text,
        )); ?>

        <?php $this->renderPartial('partial/_header_date_range', array(
            'report' => $report,
        )); ?>

        <?php $this->renderPartial('partial/_header_view_btn', array(
        )); ?>

    <?php $this->endWidget(); ?>

</div>


