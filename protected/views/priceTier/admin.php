<div class="row" id="pricetier_cart">
    <div class="col-xs-12 widget-container-col ui-sortable">
        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'Price Tier'),
            'headerIcon' => 'ace-icon fa fa-list',
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>

        <?php

        $this->breadcrumbs = array(
            Yii::t('app','Price Tier') => array('admin'),
            Yii::t('app','Manage'),
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#price-tier-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
        ?>

        <?php $this->widget('ext.modaldlg.EModalDlg'); ?>

        <div class="page-header">

            <div class="nav-search" id="nav-search">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
            <!-- search-form -->

            <?php if (Yii::app()->user->checkAccess('item.create')) { ?>

            <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'ace-icon fa fa-plus white',
                'url' => $this->createUrl('create'),
                'class' => 'update-dialog-open-link',
                'data-refresh-grid-id' => 'price-tier-grid',
                'data-update-dialog-title' => Yii::t('app', 'New Price Tier'),

            )); ?>

            <?php } ?>

            &nbsp;&nbsp;

            <?php echo CHtml::activeCheckBox($model, 'pricetier_archived', array(
                'value' => 1,
                'uncheckValue' => 0,
                'checked' => ($model->pricetier_archived == 'false') ? false : true,
                'onclick' => "$.fn.yiiGridView.update('price-tier-grid',{data:{archived:$(this).is(':checked')}});"
            )); ?>

            Show archived/deleted <b>Price Tier</b>

        </div>

        <?php
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
        $pageSizeDropDown = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState('pageSize', Common::defaultPageSize()) ,
            Common::arrayFactory('page_size'),
            array(
                'class' => 'change-pagesize',
                'onchange' => "$.fn.yiiGridView.update('price-tier-grid',{data:{pageSize:$(this).val()}});",
            )
        );
        ?>

        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'id' => 'price-tier-grid',
            'type' => TbHtml::GRID_TYPE_HOVER,
            'fixedHeader' => true,
            'template' => "{items}\n{summary}\n{pager}",
            'summaryText' => 'Showing {start}-{end} of {count} entries ' . $pageSizeDropDown . ' rows per page',
            'htmlOptions' => array('class' => 'table-responsive panel'),
            'dataProvider' => $model->search(),
            'columns' => array(
                array(
                    'name' => 'tier_name',
                    'value' => '$data->status=="1" ? $data->tier_name : "<span class=\"text-muted\">  $data->tier_name <span>" ',
                    'type' => 'raw',
                ),
                'modified_date',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            'click' => 'updateDialogOpen',
                            'label' => 'Update Price Tier',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
                                'data-refresh-grid-id' => 'supplier-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.update")',
                        ),
                        'delete' => array(
                            'label' => Yii::t('app', 'Delete Price Tier'),
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'form.item._form.header_update'),
                                'titile' => 'Edit Item',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.delete")',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore Price Tier'),
                            'url' => 'Yii::app()->createUrl("pricetier/restore", array("id"=>$data->id))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("item.delete")',
                        ),
                    ),
                ),
            ),
        )); ?>

        <?php $this->endWidget(); ?>

    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('restore', "
        jQuery( function($){
            $('div#pricetier_cart').on('click','a.btn-undodelete',function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to restore this Price Tier?')) {
                    return false;
                }
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $.fn.yiiGridView.update('price-tier-grid');
                            return false;
                          }
                    });
                });
        });
      ");
?>

<div class="waiting"><!-- Place at bottom of page --></div