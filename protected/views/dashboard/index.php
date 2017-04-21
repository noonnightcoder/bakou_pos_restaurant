<?php
$this->breadcrumbs=array(
	Yii::t('app','Dashboard'),
);
?>
<?php
    $date = array();
    $sub_total = array();
    $total = array();

    foreach($report->saleDailyChart() as $record)
    {
        $date[] = $record["date"];
        $sub_total[] = $record["sub_total"];
        $total[] = $record["total"];
    }

?>

<div class="">
        <div class="row">

            <!--PAGE CONTENT BEGINS-->
            <div class="col-xs-12">

                <div class="space-8"></div>

               <?php $this->renderPartial('partial/widget_chart', array(
                    'date' => $date,
                    'sub_total' => $sub_total,
                    'total' => $total,
                )); ?>

                <div class="space-8"></div>

                <?php $this->renderPartial('partial/widget_topten', array(
                    'report' => $report,
                )); ?>

            </div><!--/row-->
        </div>
</div>
          
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

<!--http://stackoverflow.com/questions/5052543/how-to-fire-ajax-request-periodically-->

<!--http://stackoverflow.com/questions/13668484/warn-user-when-new-data-is-inserted-on-database-->

<!--<script>
(function worker() {
    $.ajax({
        url: 'AjaxRefresh',
        success: function(data) {
            $('.summary_header').html(data);
        },
        complete: function() {
            // Schedule the next request when the current one's complete
            setTimeout(worker, 10000);
        }
    });
})();
</script>-->

