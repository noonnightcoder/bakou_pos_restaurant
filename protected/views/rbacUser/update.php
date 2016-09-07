<div class="span10" style="float: none;margin-left: auto; margin-right: auto;">
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' =>Yii::t('app','Change Password'),
              'headerIcon' => 'icon-lock',
              'content' => $this->renderPartial('_form', array('model'=>$model), true),
 )); ?>  

<?php $this->endWidget(); ?>
</div>