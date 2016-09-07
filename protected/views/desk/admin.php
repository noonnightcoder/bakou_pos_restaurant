<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Zone') => array('zone/admin'),
    Yii::t('app', 'Desk') => array('admin'),
    Yii::t('app', 'Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#desk-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="desk_cart">
    <?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                   'title' => Yii::t( 'app', 'List of Table' ),
                   'headerIcon' => 'ace-icon fa fa-square-o',
                   'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
     ));?>

    <div class="page-header">

        <div class="nav-search" id="nav-search">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!-- search-form -->

        <?php if (Yii::app()->user->checkAccess('zone.create')) { ?>

            <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'glyphicon-plus white',
                'url' => $this->createUrl('create'),
                'class' => 'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t('app', 'New Table'),
                'data-refresh-grid-id' => 'desk-grid',
            )); ?>

        <?php } ?>

        &nbsp;&nbsp;

        <?php echo CHtml::activeCheckBox($model, 'desk_archived', array(
            'value' => 1,
            'uncheckValue' => 0,
            'checked' => ($model->desk_archived == 'false') ? false : true,
            'onclick' => "$.fn.yiiGridView.update('desk-grid',{data:{DeskArchived:$(this).is(':checked')}});"
        )); ?>

        <?= Yii::t('app','Show archived/deleted'); ?> <b><?= Yii::t('app','Desk'); ?> </b>
    </div>

    <?php
    $pageSize = Yii::app()->user->getState( 'desk_PageSize', Yii::app()->params[ 'defaultPageSize' ] );
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize',
        Yii::app()->user->getState('pageSize', Common::defaultPageSize()) ,
        Common::arrayFactory('page_size'),
        array(
            'class'  => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('desk-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <?php $this->widget('\TbGridView', array(
        'id' => 'desk-grid',
        'dataProvider' => $model->search($zone_id),
        'template' => "{items}\n{summary}\n{pager}",
        'summaryText' => 'Showing {start}-{end} of {count} entries ' . $pageSizeDropDown . ' rows per page',
        'htmlOptions' => array('class' => 'table-responsive panel'),
        'columns' => array(
            //'id',
            array('name' => 'name',
                'value' => '$data->status=="1" ? $data->name : "<span class=\"text-muted\">  $data->name <span>" ',
                'type'  => 'raw',
            ),
           array(
                'name' => 'zone_id',
                'value' => '$data->zone->zone_name'
            ),
            'sort_order',
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$data->status==1 ? TbHtml::labelTb("Activated", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Archived", array("color" => TbHtml::LABEL_COLOR_DEFAULT))',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '<div class="btn-group">{update}{delete}{undeleted}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'update' => array(
                        'click' => 'updateDialogOpen',
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'Update Table'),
                            'data-refresh-grid-id' => 'desk-grid',
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("zone.update")',
                    ),
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("desk/delete/",array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("zone.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Restore Desk'),
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'url' => 'Yii::app()->createUrl("desk/UndoDelete", array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("zone.delete")',
                    ),
                ),
            ),
        ),
    )); ?>

  
   <?php $this->endWidget(); ?>

</div>

<?php 
    Yii::app()->clientScript->registerScript( 'undoDelete', "
        jQuery( function($){
            $('div#desk_cart').on('click','a.btn-undodelete',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to do restore this Desk?')) {
                    return false;
                }
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $.fn.yiiGridView.update('desk-grid');
                            return false;
                          }
                    });
                });
        });
      ");
 ?>  


<div class="waiting"><!-- Place at bottom of page --></div>