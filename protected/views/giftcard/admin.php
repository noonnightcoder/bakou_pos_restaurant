<?php
$this->breadcrumbs = array(
    Yii::t('app','Gift Card') => array('admin'),
    Yii::t('app','Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#giftcard-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'Gift Card'),
            'headerIcon' => 'menu-icon fa fa-gift',
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>

        <?php $this->widget('ext.modaldlg.EModalDlg'); ?>


        <div class="page-header">

            <div class="nav-search" id="nav-search">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>

            <?php if (Yii::app()->user->checkAccess('giftcard.create')) { ?>

                <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'size' => TbHtml::BUTTON_SIZE_SMALL,
                    'icon' => 'glyphicon-plus white',
                    'url' => $this->createUrl('create'),
                    'class' => 'update-dialog-open-link',
                    'data-update-dialog-title' => Yii::t('app', 'New Gift Card'),
                    'data-refresh-grid-id' => 'giftcard-grid',
                )); ?>

            <?php } ?>

            &nbsp;&nbsp;

            <?php echo CHtml::activeCheckBox($model, 'giftcard_archived', array(
                'value' => 1,
                'uncheckValue' => 0,
                'checked' => ($model->giftcard_archived == 'false') ? false : true,
                'onclick' => "$.fn.yiiGridView.update('giftcard-grid',{data:{Archived:$(this).is(':checked')}});"
            )); ?>

            Show archived/deleted gift card

        </div>

        <?php
        $pageSize = Yii::app()->user->getState('giftcard_PageSize', Yii::app()->params['defaultPageSize']);
        $pageSizeDropDown = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState('pageSize', Common::defaultPageSize()) ,
            Common::arrayFactory('page_size'),
            array(
                'class' => 'change-pagesize',
                'onchange' => "$.fn.yiiGridView.update('giftcard-grid',{data:{pageSize:$(this).val()}});",
            )
        );
        ?>

        <?php $this->widget('\TbGridView', array(
            'id' => 'giftcard-grid',
            'dataProvider' => $model->search(),
            'template' => "{items}\n{summary}\n{pager}",
            'summaryText' => 'Showing {start}-{end} of {count} entries ' . $pageSizeDropDown . ' rows per page',
            'htmlOptions' => array('class' => 'table-responsive panel'),
            'columns' => array(
                //'id',
                'giftcard_number',
                'discount_amount',
                //'discount_type',
                //'status',
                'client_id',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{view}{update}{delete}{restore}</div>',
                    'htmlOptions' => array('class' => 'nowrap'),
                    'buttons' => array(
                        'view' => array(
                            'click' => 'updateDialogOpen',
                            'url' => 'Yii::app()->createUrl("giftcard/view/",array("id"=>$data->id))',
                            'options' => array(
                                'class' => 'btn btn-xs btn-success',
                                'data-update-dialog-title' => Yii::t('app', 'View Giftcard'),
                            ),
                            'visible'=>'$data->status=="1" && Yii::app()->user->checkAccess("giftcard.index")',
                        ),
                        'update' => array(
                            'icon' => 'ace-icon fa fa-edit',
                            'click' => 'updateDialogOpen',
                            'label' => 'Update Giftcard',
                            'options' => array(
                                'class' => 'btn btn-xs btn-info',
                                'data-update-dialog-title' => Yii::t('app', 'Update Giftcard'),
                                'data-refresh-grid-id' => 'giftcard-grid',
                            ),
                            'visible'=>'$data->status=="1" && Yii::app()->user->checkAccess("giftcard.update")',
                        ),
                        'delete' => array(
                            'label' => 'Delete',
                            'options' => array(
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible'=>'$data->status=="1" && Yii::app()->user->checkAccess("giftcard.delete")',
                        ),
                        'restore' => array(
                            'label'=>Yii::t('app','Restore Branch'),
                            'url'=>'Yii::app()->createUrl("giftcard/UndoDelete", array("id"=>$data->id))',
                            'icon'=>'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class'=>'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible'=>'$data->status=="0" && Yii::app()->user->checkAccess("giftcard.delete")',
                        ),
                    ),
                ),
            ),
        )); ?>

        <?php if (Yii::app()->user->checkAccess('giftcard.create')) { ?>

        <?php echo TbHtml::linkButton(Yii::t('app', 'New Gift Card'), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_SMALL,
            'icon' => 'glyphicon-plus white',
            'url' => $this->createUrl('create'),
            'class' => 'update-dialog-open-link',
            'data-update-dialog-title' => Yii::t('app', 'New Gift Card'),
            'data-refresh-grid-id' => 'giftcard-grid',
        )); ?>
        <?php  }?>

        <?php $this->endWidget(); ?>
    </div>
</div>