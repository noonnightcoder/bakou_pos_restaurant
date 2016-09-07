<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
        'title' => Yii::t('app','Total Quantity') . ' : ' . $count_item,
        'headerIcon' => 'icon-tasks',
));?>   
    <?php if ( $count_item<>0 ) { ?>
        <div align="right">       
        <?php echo TbHtml::linkButton(Yii::t('app','Cancel'),array(
                'color'=>TbHtml::BUTTON_COLOR_DANGER,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'remove',
                'url'=>Yii::app()->createUrl('ClientItem/CancelSale/'),
                'class'=>'cancel-sale',
                'title' => Yii::t( 'app', 'Cancel' ),
        )); ?>

        <?php echo TbHtml::linkButton(Yii::t('app','Done'),array(
                'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'off white',
                'url'=>Yii::app()->createUrl('ClientItem/CompleteSale/'),
                'class'=>'complete-tran',
                'title' => Yii::t( 'app', 'Complete' ),
         )); ?>         
        </div>
      <?php } ?>
 <?php $this->endWidget(); ?> <!--/endtaskwidget-->