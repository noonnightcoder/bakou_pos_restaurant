<style>
.btn-group {
  display: flex !important;
}
</style>

<?php

$this->breadcrumbs=array(
	Yii::t('app','Branch')=>array('admin'),
	Yii::t('app','Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#location-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row" id="location_cart">
<div class="col-xs-12 widget-container-col ui-sortable">
    
    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                  'title' => Yii::t('app','List Of Branch'),
                  'headerIcon' => 'ace-icon fa fa-list',
                  'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    )); ?>

    <?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

    <div class="page-header">
        <div class="nav-search" id="nav-search">
            <?php $this->renderPartial('_search',array(
                    'model'=>$model,
            )); ?>
        </div><!-- search-form -->

        <?php if (Yii::app()->user->checkAccess('branch.create')) { ?>

            <?php echo TbHtml::linkButton(Yii::t( 'app', 'Add New' ),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'ace-icon fa fa-plus white',
                'url'=>$this->createUrl('create'),
            )); ?>

         <?php } ?>

        &nbsp;&nbsp;

        <?php echo CHtml::activeCheckBox($model, 'location_archived', array(
            'value' => 1,
            'uncheckValue' => 0,
            'checked' => ($model->location_archived == 'false') ? false : true,
            'onclick' => "$.fn.yiiGridView.update('location-grid',{data:{Archived:$(this).is(':checked')}});"
        )); ?>

        <?= Yii::t('app','Show archived/deleted'); ?> <b><?= Yii::t('app','Branch'); ?> </b>
    </div>

    <?php
    $pageSize = Yii::app()->user->getState( 'location_PageSize', Yii::app()->params[ 'defaultPageSize' ] );
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize',
        Yii::app()->user->getState('pageSize', Common::defaultPageSize()) ,
        Common::arrayFactory('page_size'),
        array(
            'class'  => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('location-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <?php $this->widget('\TbGridView',array(
            'id'=>'location-grid',
            'dataProvider'=>$model->search(),
            'template' => "{items}\n{summary}\n{pager}",
            'summaryText' => 'Showing {start}-{end} of {count} entries ' . $pageSizeDropDown . ' rows per page',
            'htmlOptions'=>array('class'=>'table-responsive panel'),
            'columns'=>array(
                    //'id',
                    array('name' => 'name',
                        'value' => '$data->status=="1" ? $data->name : "<span class=\"text-muted\">  $data->name <span>" ',
                        'type'  => 'raw',
                    ),
                    array('name' => 'address',
                        'value' => '$data->status=="1" ? $data->address : "<span class=\"text-muted\">  $data->address <span>" ',
                        'type'  => 'raw',
                    ),
                    array('name' => 'phone',
                        'value' => '$data->status=="1" ? $data->phone : "<span class=\"text-muted\">  $data->phone <span>" ',
                        'type'  => 'raw',
                    ),
                    array('name' => 'phone1',
                        'value' => '$data->status=="1" ? $data->phone1 : "<span class=\"text-muted\">  $data->phone1 <span>" ',
                        'type'  => 'raw',
                    ),
                    array('name'=>'status',
                        'type'=>'raw',
                        'value'=>'$data->status==1 ? TbHtml::labelTb("Active", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Inactive", array("color" => TbHtml::LABEL_COLOR_DEFAULT))',
                    ),
                   array('class'=>'bootstrap.widgets.TbButtonColumn',
                       'template'=>'<div class="btn-group">{view}{update}{delete}{undeleted}</div>',  
                       'htmlOptions'=>array('class'=>'nowrap'),
                       'buttons' => array(
                           'view' => array(
                             'click' => 'updateDialogOpen',    
                             'url'=>'Yii::app()->createUrl("location/view/",array("id"=>$data->id))',
                             'options' => array(
                                 'class'=>'btn btn-xs btn-success',
                                 'data-update-dialog-title' => Yii::t( 'app', 'View Zone' ),
                              ),
                              'visible'=>'$data->status=="1" && Yii::app()->user->checkAccess("branch.index")',
                           ),
                           'update' => array(
                             'icon' => 'ace-icon fa fa-edit',
                             'label'=>'Update Zone',  
                             'options' => array(
                                 'class'=>'btn btn-xs btn-info',
                                  'data-update-dialog-title' => Yii::t( 'app', 'Update Branch' ),
                                  'data-refresh-grid-id'=>'zone-grid',
                              ),
                              'visible'=>'$data->status=="1" && Yii::app()->user->checkAccess("branch.update")',
                           ),   
                           'delete' => array(
                              'label'=>'Delete',
                              'options' => array(
                                 'class'=>'btn btn-xs btn-danger',
                              ),
                              'visible'=>'$data->status=="1" && Yii::app()->user->checkAccess("branch.delete")', 
                           ),
                           'undeleted' => array(
                            'label'=>Yii::t('app','Restore Branch'),
                            'url'=>'Yii::app()->createUrl("location/UndoDelete", array("id"=>$data->id))',
                            'icon'=>'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class'=>'btn btn-xs btn-warning btn-undodelete',
                            ), 
                            'visible'=>'$data->status=="0" && Yii::app()->user->checkAccess("branch.delete")',
                           ),
                        ),
                   ),
            ),
    )); ?>

    <?php $this->endWidget(); ?>
</div>
</div>

<?php 
    Yii::app()->clientScript->registerScript( 'undoDelete', "
        jQuery( function($){
            $('div#location_cart').on('click','a.btn-undodelete',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to do restore this Branch?')) {
                    return false;
                }
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $.fn.yiiGridView.update('location-grid');
                            return false;
                          }
                    });
                });
        });
      ");
 ?>  


<div class="waiting"><!-- Place at bottom of page --></div>