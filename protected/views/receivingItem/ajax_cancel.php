<?php if ( $count_item<>0 ) { ?> 
    <div align="right"> 
    <?php echo TbHtml::linkButton(Yii::t('app','Cancel Receiving'),array(
            'color'=>TbHtml::BUTTON_COLOR_DANGER,
            'size'=>TbHtml::BUTTON_SIZE_SMALL,
            'icon'=>'glyphicon-remove',
            'url'=>Yii::app()->createUrl('ReceivingItem/CancelRecv/'),
            'class'=>'cancel-recv',
            'title' => Yii::t( 'app', 'Cancel' ),
    )); ?>
    </div>
<?php } ?>