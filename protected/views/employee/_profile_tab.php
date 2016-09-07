<?php
$this->breadcrumbs=array(
	'Employees'=>array('admin'),
	'Create',
);
?>
<div id="user-profile-3" class="user-profile row-fluid">    
<div class="offset1 span10">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'employee-form',
            'enableAjaxValidation'=>false,
            'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>    
        <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'type'=>'tabs',
            'placement'=>'above', // 'above', 'right', 'below' or 'left'
            'tabs'=>array(
                array('label'=>Yii::t('app','Basic Info'),'id'=>'tab_1','icon'=>'icon-edit green bigger-125', 'content'=>$this->renderPartial('_profile_login', array('model'=>$model,'user'=>$user,'form'=>$form), true),'active'=>true),
                array('label'=>Yii::t('app','Acees Right'),'id'=>'tab_2','icon'=>'icon-legal purple bigger-125', 'content'=>$this->renderPartial('_profile_role', array('model'=>$model,'user'=>$user,'form'=>$form), true)),
            ),
            //'events'=>array('shown'=>'js:loadContent')
        )); ?>
    <?php $this->endWidget(); ?>     
</div>   
</div>

<div class="waiting"><!-- Place at bottom of page -->Waiting..</div>