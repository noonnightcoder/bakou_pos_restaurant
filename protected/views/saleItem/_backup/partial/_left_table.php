<div class="widget-body" id="table_grid">
    <!-- /section:custom/widget-box.toolbox -->
    <div class="widget-main padding-12">

        <?php  foreach ($tables as $table) { ?>
            <?php if ($table["id"]==$table_id) { ?>
                 <a class="btn btn-white btn-success btn-round table-btn active btn-lg" href="<?php echo Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])); ?>">
                    <i class="ace-icon fa fa-check-square-o bigger-110 green"></i>
                    <?php echo $table['name'] ?>
                    <span class="badge badge-info white"><?php echo Common::GroupAlias(Yii::app()->orderingCart->getGroupId()); ?></span>
                </a>
            <?php } elseif ($table["busy_flag"]==0) { ?>
                <?php echo TbHtml::linkButton($table['name'],array(
                    'color'=>TbHtml::BUTTON_COLOR_INFO,
                    'size'=>TbHtml::BUTTON_SIZE_LARGE,
                    'icon'=> 'ace-icon fa fa-square-o bigger-110',
                    'url'=>Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])),
                    'class'=>'btn btn-white btn-info btn-round table-btn',
                )); ?>
            <?php } else { ?>
                <!--<a class="btn-white btn-round table-btn active btn btn-warning btn-lg" href="<?php /*echo Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])); */?>">
                            <i class="ace-icon fa fa-square-o bigger-110"></i>
                            <?php /*echo $table['name'] */?>
                            <span class="badge badge-pink white"><?php /*echo Common::GroupAlias(Yii::app()->orderingCart->getGroupId()); */?></span>
                        </a>-->
                <?php echo TbHtml::linkButton($table['name'],array(
                    'color'=>TbHtml::BUTTON_COLOR_WARNING,
                    'size'=>TbHtml::BUTTON_SIZE_LARGE,
                    'icon'=> 'ace-icon fa fa-ban bigger-110',
                    'url'=>Yii::app()->createUrl('saleItem/SetTable/',array('table_id'=>$table['id'])),
                    'class'=>'btn-white btn-round table-btn active',
                )); ?>
            <?php } ?>
        <?php } ?>

    </div>

    <div class="widget-toolbox padding-8 clearfix" id="group_cart">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        )); ?>
        <?php echo $form->dropDownListControlGroup($model,'group',Desk::itemAlias('group'),
            array('class'=>'input-small','id'=>'group_id','options'=>array(Yii::app()->orderingCart->getGroupId()=>array('selected'=>true)),
            )); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>