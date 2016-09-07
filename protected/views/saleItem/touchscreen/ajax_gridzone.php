<?php //echo Yii::app()->orderingCart->getTableId() . ' - ' . Yii::app()->orderingCart->getGroupId(); ?>
<div class="widget-container-col" id="grid_zone">    
    <div class="widget-box">
        <div class="widget-header widget-header-flat">
            <h5 class="widget-title bigger lighter">Zone</h5>
            
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="1 ace-icon fa fa-chevron-up bigger-125"></i>
                </a>
            </div>
            <div class="btn-group"> 
                <?php  foreach ($zones as $zone) { ?> 
                    <?php if ($zone->id==$zone_id) { ?>
                        <?php echo TbHtml::linkButton($zone->zone_name,array(
                            'color'=>TbHtml::BUTTON_COLOR_INFO,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'ace-icon fa fa-globe bigger-110 green',
                            'url'=>Yii::app()->createUrl('saleItem/index/',array('zone_id'=>$zone->id)),
                            'class'=>'btn btn-white btn-round zone-btn active',
                        )); ?>
                    <?php } else { ?>
                        <?php echo TbHtml::linkButton($zone->zone_name,array(
                            'color'=>TbHtml::BUTTON_COLOR_INFO,
                            'size'=>TbHtml::BUTTON_SIZE_SMALL,
                            'icon'=>'ace-icon fa fa-globe bigger-110 green',
                            'url'=>Yii::app()->createUrl('saleItem/index/',array('zone_id'=>$zone->id)),
                            'class'=>'btn btn-white btn-round zone-btn',
                        )); ?>
                    <?php } ?>
                <?php } ?>


                <?php if ($zone_id==-1) { ?>
                    <?php echo TbHtml::linkButton("All",array(
                        'color'=>TbHtml::BUTTON_COLOR_INFO,
                        'size'=>TbHtml::BUTTON_SIZE_SMALL,
                        'icon'=>'ace-icon fa fa-globe bigger-110 green',
                        'url'=>Yii::app()->createUrl('saleItem/index/',array('zone_id'=>-1)),
                        'class'=>'btn btn-white btn-round zone-btn active',
                    )); ?>
                <?php } else { ?>
                    <?php echo TbHtml::linkButton("All",array(
                        'color'=>TbHtml::BUTTON_COLOR_INFO,
                        'size'=>TbHtml::BUTTON_SIZE_SMALL,
                        'icon'=>'ace-icon fa fa-globe bigger-110 green',
                        'url'=>Yii::app()->createUrl('saleItem/index/',array('zone_id'=>-1)),
                        'class'=>'btn btn-white btn-round zone-btn',
                    )); ?>
                <?php } ?>
            </div>
           
        </div>
       
        <div class="widget-body">
            <!-- /section:custom/widget-box.toolbox -->
            <div class="widget-main padding-12">
                <?php  foreach ($tables as $table) { ?> 
                    <?php if ($table["id"]==$table_id) { ?>
                      <?php //echo TbHtml::imagePolaroid('holder.js/74x74/tablename/text:' . $table['name']); ?>
                        <?php echo TbHtml::linkButton($table['name'],array(
                          'color'=>TbHtml::BUTTON_COLOR_INFO,
                          'size'=>TbHtml::BUTTON_SIZE_LARGE,
                          'icon'=>'ace-icon fa fa-square-o bigger-110 green',
                          'url'=>Yii::app()->createUrl('saleItem/index/',array('table_id'=>$table['id'])),
                          'class'=>'btn btn-green btn-info btn-round table-btn',
                        )); ?>
                    <?php } elseif ($table["busy_flag"]==0) { ?>
                        <?php //echo $table["busy_flag"]; ?>
                        <?php echo TbHtml::linkButton($table['name'],array(
                          'color'=>TbHtml::BUTTON_COLOR_INFO,
                          'size'=>TbHtml::BUTTON_SIZE_LARGE,
                          'icon'=>'ace-icon fa fa-square-o bigger-110',
                          'url'=>Yii::app()->createUrl('saleItem/index/',array('table_id'=>$table['id'])),
                          'class'=>'btn btn-white btn-info btn-round table-btn',
                        )); ?>
                    <?php } else { ?>
                        <?php echo TbHtml::linkButton($table['name'],array(
                          'color'=>TbHtml::BUTTON_COLOR_WARNING,
                          'size'=>TbHtml::BUTTON_SIZE_LARGE,
                          'icon'=>'ace-icon fa fa-square-o bigger-110',
                          'url'=>Yii::app()->createUrl('saleItem/index/',array('table_id'=>$table['id'])),
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
    </div>
</div> <!--/end2nddiv--> 