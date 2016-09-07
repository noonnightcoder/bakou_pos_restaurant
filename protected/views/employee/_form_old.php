<div class="row-fluid">
        <?php $this->widget('bootstrap.widgets.TbAlert', array(
                'block'=>true, // display a larger alert block?
                'fade'=>true, // use transitions?
                'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                'alerts'=>array( // configurations per alert type
                    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), 
                    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
                ),
        )); ?>

        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'employee-form',
                'enableAjaxValidation'=>false,
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        )); ?>

        <div class="span5">
            <h4 class="header blue"><?php echo Yii::t('app','Employee Basic Information') ?></h4>
                <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

                <?php //echo $form->errorSummary($model); ?>

                <?php echo $form->textFieldControlGroup($model,'first_name',array('class'=>'span10','maxlength'=>50,'data-required'=>'true')); ?>

                <?php echo $form->textFieldControlGroup($model,'last_name',array('class'=>'span10','maxlength'=>50,'data-required'=>'true')); ?>

                <?php echo $form->textFieldControlGroup($model,'mobile_no',array('class'=>'span10','maxlength'=>15)); ?>

                <?php echo $form->textFieldControlGroup($model,'adddress1',array('class'=>'span10','maxlength'=>60)); ?>

                <?php echo $form->textFieldControlGroup($model,'address2',array('class'=>'span10','maxlength'=>60)); ?>

                <?php echo $form->textFieldControlGroup($model,'city_id',array('class'=>'span10')); ?>

                <?php echo $form->textFieldControlGroup($model,'country_code',array('class'=>'span10','maxlength'=>2)); ?>

                <?php echo $form->textFieldControlGroup($model,'email',array('class'=>'span10','maxlength'=>30,'data-type'=>'email')); ?>

                <?php echo $form->textAreaControlGroup($model,'notes',array('rows'=>2, 'cols'=>20, 'class'=>'span10')); ?>
        </div>

        <div class="span6">
                <h4 class="header blue"><?php echo Yii::t('app','Employee Login Info') ?></h4>
                <?php echo $form->textFieldControlGroup($user,'user_name',array('class'=>'span8','maxlength'=>60,'placeholder'=>'User name', 'autocomplete'=>'off','data-required'=>'true')); ?>

                <?php if ($model->isNewRecord) { ?>

                <?php echo $form->passwordFieldControlGroup($user,'Password',array('class'=>'span8','maxlength'=>128,'placeholder'=>'User Password','autocomplete'=>'off')); ?>

                <?php echo $form->passwordFieldControlGroup($user,'PasswordConfirm',array('class'=>'span8','maxlength'=>128, 'placeholder'=>'Password Confirm','autocomplete'=>'off')); ?>

                <?php } ?>

                <?php //echo $form->textFieldControlGroup($user,'employee_id',array('class'=>'span5')); ?>
                <h4 class="header blue"><?php echo Yii::t('app','Employee Permissions and Access'); ?></h4>
                
                <?php echo $form->inlineCheckBoxListControlGroup($user, 'items',Authitem::model()->getAuthItemItem(),array('class'=>'ace-checkbox-2')); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'sales', Authitem::model()->getAuthItemSale(),array('class'=>'ace-checkbox-2')); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'receivings', Authitem::model()->getAuthItemReceiving()); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'reports', Authitem::model()->getAuthItemReport()); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'employees', Authitem::model()->getAuthItemEmployee()); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'customers', Authitem::model()->getAuthItemClient()); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'suppliers', Authitem::model()->getAuthItemSupplier()); ?>

                <?php echo $form->inlineCheckBoxListControlGroup($user, 'store', Authitem::model()->getAuthItemStore(),array('class'=>'ace-checkbox-2')); ?>
                
                
            <div class="form-actions">
                <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','form.button.create') : Yii::t('app','form.button.save'),array(
                   'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                   //'size'=>TbHtml::BUTTON_SIZE_SMALL,
               )); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
</div>
        
