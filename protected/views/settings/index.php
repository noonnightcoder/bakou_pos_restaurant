<?php
$this->breadcrumbs=array(
	Yii::t('app','Shop Setting')=>array('index'),
	Yii::t('app','Manage'),
);
?>
<?php
    $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Shop Setting'),
              'headerIcon' => 'menu-icon fa fa-cog',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
)); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'settings-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions'=>array('data-validate'=>'parsley'),
)); ?>

<ul class="nav nav-tabs" id="site-settings">
    <?php

    $tabs = array();
    $i = 0;
    foreach ($model->attributes as $category => $values):?>
        <li<?php echo !$i?' class="active"':''?>><a href="#<?php echo $category ; ?>" data-toggle="tab"><?php echo Yii::t('app',ucwords(str_replace('_',' ',$category))); ?></a></li>
    <?php
    $i ++;
    endforeach;?>
</ul>

<div class="tab-content">
    <?php
    $i = 0;
    foreach ($model->attributes as $category => $values):?>
        <div class="tab-pane<?php echo !$i?' active':''?>" id="<?php echo $category; ?>">
            <?php
            $this->renderPartial(
                    '_'.$category,
                    array('model' => $model, 'values' => $values, 'category' => $category)
                );
            ?>
        </div>
    <?php
    $i ++;
    endforeach;?>
</div>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
)); ?>

<div class="form-actions">
     <?php echo TbHtml::submitButton(Yii::t( 'app', 'Save' ),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        //'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?>
</div>

<?php $this->endWidget(); ?><!--/ end form widget -->

<?php $this->endWidget(); ?>