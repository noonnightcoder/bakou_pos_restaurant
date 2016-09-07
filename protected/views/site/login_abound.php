<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div class="page-header">
    <blockquote><p class="text-info"><?php echo Yii::t('app', 'Welcome'); ?> Bakou Point-Of-Sale</p>
        <small><?php echo Yii::t('app', 'Slogan'); ?> <cite title="Point of Sale System">POS in Cambodia</cite></small>
    </blockquote>
</div>

<div class="row">
	
    <div class="span8" style="float: none;margin-left: auto; margin-right: auto;">
    <?php  $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app', 'Login'),
              'headerIcon' => 'icon-lock',
    )); ?>    
    
    <?php   /*
            $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=> Yii::t('app', 'Login'),
            ));
        */ 
     
    ?>
        
       <p><?php echo Yii::t('app', 'LoginPhrase'); ?><p>
       <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'login-form',
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
       )); ?>

            <p><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>
            <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

            <?php echo $form->textFieldControlGroup($model,'username',array('class'=>'span3','maxlength'=>30)); ?>

            <?php echo $form->passwordFieldControlGroup($model,'password',array('class'=>'span3','maxlength'=>30)); ?>


            <div class="form-actions">
                 <?php echo TbHtml::submitButton(Yii::t('app', 'Login'),array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
            </div>

        <?php $this->endWidget(); ?>
    
    <?php $this->endWidget();?>

    </div>

</div>