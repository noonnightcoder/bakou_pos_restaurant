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

        <?php $this->renderPartial('partial/_header_view_btn', array(
        )); ?>

    <?php $this->endWidget(); ?>

</div>

<script>
    jQuery( function($){
        $('div#report_header').on('click','.btn-view',function(e) {
            e.preventDefault();
            var data=$("#report-form").serialize();
            $.ajax({url: '<?=  Yii::app()->createUrl($this->route); ?>',
                type : 'GET',
                dataType : 'json',
                data:data,
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    $("#report_grid").html(data.div);
                    return false;
                }
            });
        });
    });
</script>


