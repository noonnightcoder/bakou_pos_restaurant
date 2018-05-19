<!-- #section:left.div.layout -->
<div class="col-xs-12 col-sm-5 widget-container-col" id="grid_zone">
    <div class="widget-box">
        <div class="widget-header widget-header-flat widget-header-small">
            <i class="ace-icon fa fa-globe"></i>
            <h5 class="widget-title bigger"><?= Yii::t('app','Zone'); ?></h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up bigger-125"></i>
                </a>
            </div>

            <div class="btn-group">
                <?php  foreach ($zones as $zone) { ?>
                    <?php if ($zone->id==$zone_id) { ?>
                        <?php echo TbHtml::linkButton($zone->zone_name,array(
                            'color'=>TbHtml::BUTTON_COLOR_INFO,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'ace-icon fa fa-globe bigger-110 green',
                            'url'=>Yii::app()->createUrl('saleItem/setZone/',array('zone_id'=>$zone->id)),
                            'class'=>'btn btn-white btn-round zone-btn active',
                        )); ?>
                    <?php } else { ?>
                        <?php echo TbHtml::linkButton($zone->zone_name,array(
                            'color'=>TbHtml::BUTTON_COLOR_INFO,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'ace-icon fa fa-globe bigger-110 green',
                            'url'=>Yii::app()->createUrl('saleItem/setZone/',array('zone_id'=>$zone->id)),
                            'class'=>'btn btn-white btn-round zone-btn',
                        )); ?>
                    <?php } ?>
                <?php } ?>


                <?php if ($zone_id==-1) { ?>
                    <?php echo TbHtml::linkButton("All",array(
                        'color'=>TbHtml::BUTTON_COLOR_INFO,
                        'size'=>TbHtml::BUTTON_SIZE_SMALL,
                        'icon'=>'ace-icon fa fa-globe bigger-110 green',
                        'url'=>Yii::app()->createUrl('saleItem/setZone/',array('zone_id'=>-1)),
                        'class'=>'btn btn-white btn-round zone-btn active',
                    )); ?>
                <?php } else { ?>
                    <?php echo TbHtml::linkButton("All",array(
                        'color'=>TbHtml::BUTTON_COLOR_INFO,
                        'size'=>TbHtml::BUTTON_SIZE_SMALL,
                        'icon'=>'ace-icon fa fa-globe bigger-110 green',
                        'url'=>Yii::app()->createUrl('saleItem/setZone/',array('zone_id'=>-1)),
                        'class'=>'btn btn-white btn-round zone-btn',
                    )); ?>
                <?php } ?>
            </div>


        </div>

       <!-- <div class="widget-body" id="table_grid">
            <div class="widget-main padding-12">

                <?php /* foreach ($tables as $table) { */?>
                    <?php /*if ($table["id"]==$table_id) { */?>
                        <a class="btn btn-white btn-success btn-round table-btn active btn-lg" href="<?php /*echo Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])); */?>">
                            <i class="ace-icon fa fa-check-square-o bigger-110 green"></i>
                            <?php /*echo $table['name'] */?>
                            <span class="badge badge-info white"><?php /*echo Common::GroupAlias(Yii::app()->orderingCart->getGroupId()); */?></span>
                        </a>
                    <?php /*} elseif ($table["busy_flag"]==0) { */?>
                        <?php /*echo TbHtml::linkButton($table['name'],array(
                            'color'=>TbHtml::BUTTON_COLOR_INFO,
                            'size'=>TbHtml::BUTTON_SIZE_LARGE,
                            'icon'=> 'ace-icon fa fa-square-o bigger-110',
                            'url'=>Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])),
                            'class'=>'btn btn-white btn-info btn-round table-btn',
                        )); */?>
                    <?php /*} else { */?>
                        <?php /*echo TbHtml::linkButton($table['name'],array(
                            'color'=>TbHtml::BUTTON_COLOR_WARNING,
                            'size'=>TbHtml::BUTTON_SIZE_LARGE,
                            'icon'=> 'ace-icon fa fa-ban bigger-110',
                            'url'=>Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])),
                            'class'=>'btn-white btn-round table-btn active',
                        )); */?>
                    <?php /*} */?>
                <?php /*} */?>

            </div>

            <div class="widget-toolbox padding-8 clearfix" id="group_cart">
                <?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                )); */?>
                <?php /*echo $form->dropDownListControlGroup($model,'group',Desk::itemAlias('group'),
                    array('class'=>'input-small','id'=>'group_id','options'=>array(Yii::app()->orderingCart->getGroupId()=>array('selected'=>true)),
                    )); */?>
                <?php /*$this->endWidget(); */?>
            </div>
        </div>-->

        <?php $this->renderPartial('partial/_left_table', array(
            'model' => $model,
            'tables' => $tables,
            'zones' => $zones,
            'table_id' => $table_id,
            'zone_id' => $zone_id
        )); ?>

    </div>

    <i class="ace-icon fa fa-book"></i>
    <?php echo TbHtml::tooltip(Yii::t('app','Keyboard Shortcuts Help'),'#',
        '[F2] => Set the focus to [Gift Card] <br>
         [F1] => Set the focus to "Payment Amount" [Enter] to make payment, Press another [Enter] to Complete Sale',
         array('data-html' => 'true','placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,)
    ); ?>
</div> <!--/end.left.div-->