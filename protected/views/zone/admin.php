<style>
.btn-group {
  display: flex !important;
}
</style>
<?php
/* @var $this ZoneController */
/* @var $model Zone */

$this->breadcrumbs=array(
	Yii::t('app','Zone') => array('admin'),
	Yii::t('app','Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#zone-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="zone_cart">

    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                   'title' => Yii::t( 'app', 'List of Zone' ),
                   'headerIcon' => 'ace-icon fa fa-globe',
                   'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),    
     ));?>

    <?php $this->widget('ext.modaldlg.EModalDlg'); ?>

    <div class="page-header">
        <div class="search-form nav-search" id="nav-search">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>

        <?php if (Yii::app()->user->checkAccess('zone.create')) { ?>

            <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'glyphicon-plus white',
                'url' => $this->createUrl('create'),
                'class' => 'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t('app', 'Add New'),
                'data-refresh-grid-id' => 'zone-grid',
            )); ?>

            &nbsp;&nbsp;

            <?php echo CHtml::activeCheckBox($model, 'zone_archived', array(
                'value' => 1,
                'uncheckValue' => 0,
                'checked' => ($model->zone_archived == 'false') ? false : true,
                'onclick' => "$.fn.yiiGridView.update('zone-grid',{data:{ZoneArchived:$(this).is(':checked')}});"
            )); ?>


            <?= Yii::t('app','Show archived/deleted'); ?> <b><?= Yii::t('app','Zone'); ?> </b>

        <?php } ?>

    </div>

   <?php $this->widget('bootstrap.widgets.TbAlert', array(
           'block'=>true, 
           'fade'=>true, 
           'closeText'=>'&times;', 
           'alerts'=>array(
               'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), 
               'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
           ),
   )); ?>

    <?php
    $pageSize = Yii::app()->user->getState( 'zone_pageSize', Yii::app()->params[ 'defaultPageSize' ] );
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize',
        Yii::app()->user->getState('pageSize', Common::defaultPageSize()) ,
        Common::arrayFactory('page_size'),
        array(
            'class'  => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('zone-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <?php $this->widget('\TbGridView', array(
        'id' => 'zone-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => "{items}\n{summary}\n{pager}",
        'summaryText' => 'Showing {start}-{end} of {count} entries ' . $pageSizeDropDown . ' rows per page',
        'htmlOptions' => array('class' => 'table-responsive panel'),
        'columns' => array(
            array('name'=>'id',
                  'filter' => '',
            ),
            array('name' => 'zone_name',
                'value' => '$data->status=="1" ? $data->zone_name : "<span class=\"text-muted\">  $data->zone_name <span>" ',
                'type'  => 'raw',
                //'filter' =>  CHtml::listData(Zone::model()->findAll(array('condition' => 'location_id=:location_id','params' => array(':location_id'=> Yii::app()->getsetSession->getLocationId() ))), 'id', 'zone_name'),
            ),
            array(//'name' =>'desks',
                'header' => Yii::t('app','Table'),
                'value' => array($this, "gridTableColumn"),
                'type' => 'raw',
            ),
            array(
                'name' => 'location_id',
                //'header' => 'Branch',
                'value' => '($data->location_id!==null)? $data->location->name : "N/A"',
                'filter' =>  CHtml::listData(Location::model()->findAll(array('order'=>'name')), 'id', 'name'),
            ),
            array(//'name' =>'room',
                'header' => Yii::t('app','Price Tier'),
                'value' => array($this, "gridPriceTierColumn"),
            ),
            array('name'=>'sort_order',
                'filter' => '',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$data->status==1 ? TbHtml::labelTb("Active", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Archived", array("color" => TbHtml::LABEL_COLOR_DEFAULT))',
                'filter'=> CHtml::activeDropDownList($model,'status',array('1' => 'Active', '0' => 'Archived'),array('empty' => '')),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '<div class="btn-group">{Price}{view}{update}{delete}{undeleted}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'Price' => array(
                        'click' => 'updateDialogOpen',
                        'label' => Yii::t('app', 'Price'),
                        'url' => 'Yii::app()->createUrl("PriceTierZone/create/",array("zone_id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-primary',
                            'data-update-dialog-title' => Yii::t('app', 'Set Price'),
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("zone.update")',
                    ),
                    'view' => array(
                        'click' => 'updateDialogOpen',
                        'url' => 'Yii::app()->createUrl("zone/view/",array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-success',
                            'data-update-dialog-title' => Yii::t('app', 'View Zone'),
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("zone.index")',
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'click' => 'updateDialogOpen',
                        'label' => 'Update Zone',
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                            'data-update-dialog-title' => Yii::t('app', 'Update Zone'),
                            'data-refresh-grid-id' => 'zone-grid',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("zone.update")',
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("zone.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Restore Zone'),
                        'url' => 'Yii::app()->createUrl("zone/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
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
            $('div#zone_cart').on('click','a.btn-undodelete',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to do undo delete this Item?')) {
                    return false;
                }
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $.fn.yiiGridView.update('zone-grid');
                            return false;
                          }
                    });
                });
        });
      ");
 ?>  


<div class="waiting"><!-- Place at bottom of page --></div>