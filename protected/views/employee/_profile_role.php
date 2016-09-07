<?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
         'id'=>'employee-form',
         'enableAjaxValidation'=>false,
         'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
 )); */?>   
<h4 class="header blue bolder smaller"><?php echo Yii::t('app','Employee Permissions and Access'); ?></h4>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'items',Authitem::model()->getAuthItemItem(),array('class'=>'ace-checkbox-2')); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'sales', Authitem::model()->getAuthItemSale(),array('class'=>'ace-checkbox-2')); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'receivings', Authitem::model()->getAuthItemReceiving()); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'reports', Authitem::model()->getAuthItemReport()); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'employees', Authitem::model()->getAuthItemEmployee()); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'customers', Authitem::model()->getAuthItemClient()); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'suppliers', Authitem::model()->getAuthItemSupplier()); ?>

<?php echo $form->inlineCheckBoxListControlGroup($user, 'store', Authitem::model()->getAuthItemStore(),array('class'=>'ace-checkbox-2')); ?>

 <?php //$this->endWidget(); ?> 