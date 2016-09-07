<style>
.btn-group {
  display: flex !important;
}
</style>

<?php
$this->breadcrumbs=array(
	'Item'=>array('admin'),
	'Manage',
);
?>
<div class="row" id="item_cart">
<div class="col-xs-12 widget-container-col ui-sortable">
    
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','List of Items'),
              'headerIcon' => 'ace-icon fa fa-list',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
)); ?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

    <div class="page-header">

        <div class="nav-search search-form" id="nav-search">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>

        <?php if (Yii::app()->user->checkAccess('item.create')) { ?>

            <?php echo TbHtml::linkButton(Yii::t('app', 'Add New
            '), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'ace-icon fa fa-plus white',
                'url' => $this->createUrl('createImage'),
            )); ?>

            &nbsp;&nbsp;

            <?php echo CHtml::activeCheckBox($model, 'item_archived', array(
                'value' => 1,
                'uncheckValue' => 0,
                'checked' => ($model->item_archived == 'false') ? false : true,
                'onclick' => "$.fn.yiiGridView.update('item-grid',{data:{archivedItem:$(this).is(':checked')}});"
            )); ?>

            Show archived/deleted item

        <?php } ?>

    </div>

    <?php /*echo TbHtml::linkButton(Yii::t( 'app', 'New Category' ),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'size'=>TbHtml::BUTTON_SIZE_SMALL,
            'icon'=>'glyphicon-briefcase white',
            'url'=>$this->createUrl('category/create'),
            'class'=>'update-dialog-open-link',
            'data-update-dialog-title' => Yii::t('app','form.category._form.header_create'),
    )); */?><!--

    --><?php /*echo TbHtml::linkButton(Yii::t( 'app', 'form.category.admin.header_title' ),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'size'=>TbHtml::BUTTON_SIZE_SMALL,
            'icon'=>'glyphicon-list white',
            'url'=>$this->createUrl('category/admin'),
    )); */?>

    <?php
    $pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize',
        $pageSize,
        array( 10 => 10, 25 => 25, 50 => 50, 100 => 100, 150 => 150, 200 => 200 ),
        array(
            'class'  => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('item-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <?php if(Yii::app()->user->hasFlash('success')):?>
        <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
    <?php endif; ?>


    <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'id' => 'item-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'fixedHeader' => true,
        'type' => TbHtml::GRID_TYPE_HOVER,
        'template'=>"{items}\n{summary}\n{pager}",
        'summaryText'=>'Showing {start}-{end} of {count} entries ' . $pageSizeDropDown .  ' rows per page',
        'htmlOptions' => array('class' => 'table-responsive panel'),
        'columns' => array(
            /*
            array('name'=>'id',
                 'value'=>'CHtml::link(CHtml::image(Yii::app()->controller->createUrl("loadImage", array("id"=>$data->primaryKey))),array(Yii::app()->controller->createUrl("loadImage", array("id"=>$data->primaryKey))),array("data-rel"=>"colorbox"));',
                 'type'=>'raw',
           ),
             *
           */
            array(
                'name' => 'item_number',
                'value' => '$data->status=="1" ? $data->item_number : "<span class=\"text-muted\">  $data->item_number <span>" ',
                'type'  => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'name',
                'value' => '$data->status=="1" ? CHtml::link($data->name, Yii::app()->createUrl("item/UpdateImage",array("id"=>$data->primaryKey))) : "<span class=\"text-muted\">  $data->name <span>" ',
                'type'  => 'raw',
                'filter' => '',
            ),
            /*
            array('name'=>'description',
                  'headerHtmlOptions'=>array('class'=>'hidden-480 hidden-xs'),
                  'htmlOptions'=>array('class' => 'hidden-480 hidden-xs'),
            ),
             *
            */
            array(
                'name' => 'topping',
                'header' => 'Type',
                'value' => '($data->topping==0)? "Main-Menu" : "Topping" ',
                //'filter' => '',
                'filter'=> CHtml::activeDropDownList($model,'topping',array(1 => 'Topping', 0 => 'Main-Menu'),array('empty' => '')),
            ),
            array(
                'name' => 'category_id',
                'value' => '$data->category_id==null? " " : $data->category->name',
                'filter' =>  CHtml::listData(Category::model()->findAll(array('order'=>'name')), 'id', 'name')
            ),
            array(
                'name' => 'unit_price',
                'value' => '$data->status=="1" ? $data->unit_price : "<span class=\"text-muted\">  $data->unit_price <span>" ',
                'type'  => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$data->status=="1" ? TbHtml::labelTb("Active", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Archived")',
                'filter' => '',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app', 'Action'),
                'template'=>'<div class="hidden-sm hidden-xs btn-group">{delete}{undeleted}{update}</div>',
                //'htmlOptions'=>array('class'=>'hidden-sm hidden-xs btn-group'),
                'buttons' => array(
                    'delete' => array(
                        'label' => Yii::t('app', 'Delete Item'),
                        //'icon'=>'bigger-120 glyphicon-trash',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'form.item._form.header_update'),
                            'titile' => 'Edit Item',
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Restore Item'),
                        'url' => 'Yii::app()->createUrl("Item/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("Item/UpdateImage", array("id"=>$data->id))',
                        'label' => Yii::t('app', 'Edit Item'),
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'form.item._form.header_update'),
                            'titile' => 'Edit Item',
                            //'data-refresh-grid-id'=>'item-grid',
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.update")',
                    ),
                ),
            ),
        ),
    )); ?>

    <?php $this->endWidget(); ?>
</div>
</div>

<script>
$(document).ready(function () {
 
window.setTimeout(function() {
    $(".alert").fadeTo(1500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
 
});
</script>

<?php 
    Yii::app()->clientScript->registerScript( 'undoDelete', "
        jQuery( function($){
            $('div#item_cart').on('click','a.btn-undodelete',function(e) {
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
                            $.fn.yiiGridView.update('item-grid');
                            return false;
                          }
                    });
                });
        });
      ");
 ?>  


<div class="waiting"><!-- Place at bottom of page --></div>