<div id="report_header">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'report-form',
        'method' => 'get',
        'action' => Yii::app()->createUrl($this->route),
        'enableAjaxValidation' => false,
        'layout' => TbHtml::FORM_LAYOUT_INLINE,
    )); ?>

        <?php if ($advance_search!==null) { ?>
            <?php $this->renderPartial('partial/_advance_search', array('report' => $report,)); ?>
        <?php } ?>

        <?php $this->renderPartial('partial/_header_date_range', array('report' => $report,)); ?>

        <div class="input-group">
            <?php echo TbHtml::activeDropDownList($report,'location_id',Location::model()->getLocation(),
                array('empty' => 'All Branch',
                     'options'=>array(Common::getCurLocationID()=>array('selected'=>true))
                ));
            ?>
        </div>


        <?php //echo $form->dropDownList($report,'sale_id', Category::model()->getCategory(),array('class'=>'col-xs-10 col-sm-8','prompt'=>'-- All --')); ?>



        <?php $this->renderPartial('partial/_header_view_btn', array(
        )); ?>


    <?php $this->endWidget(); ?>

</div>


