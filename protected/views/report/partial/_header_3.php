<div id="report_header">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'report-form',
        'method' => 'get',
        'action' => Yii::app()->createUrl($this->route),
        'enableAjaxValidation' => false,
        'layout' => TbHtml::FORM_LAYOUT_INLINE,
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbNav', array(
        'type' => TbHtml::NAV_TYPE_PILLS,
        'htmlOptions'=>array('class'=>'btn-opt'),
        'items' => $header_tab
    )); ?>

    <br />

    <?php if ($advance_search!==null) { ?>
        <div>
        <?php $this->renderPartial('partial/_advance_search', array(
            'report' => $report,
        )); ?>

        <?php $this->renderPartial('partial/_header_view_btn', array(
        )); ?>

        </div>

    <?php } ?>


    <?php $this->endWidget(); ?>

</div>


