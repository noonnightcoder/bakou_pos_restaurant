<h4 class="header blue bolder smaller"><?php echo Yii::t('app','Employee Login Info') ?></h4>    
<div class="row-fluid">
     
    <div class="span7">
         
    <?php echo $form->textFieldControlGroup($user,'user_name',array('class'=>'span6','maxlength'=>60,'placeholder'=>'User name', 'autocomplete'=>'off','data-required'=>'true')); ?>    

    <?php echo $form->passwordFieldControlGroup($user,'Password',array('class'=>'span6','maxlength'=>128,'placeholder'=>'User Password','autocomplete'=>'off')); ?>

    <?php echo $form->passwordFieldControlGroup($user,'PasswordConfirm',array('class'=>'span6','maxlength'=>128, 'placeholder'=>'Password Confirm','autocomplete'=>'off')); ?>

    </div>  
    
     <div class="span5">
            <input type="file" />
    </div>
   
</div>
<h4 class="header blue bolder smaller"><?php echo Yii::t('app','Employee Basic Information') ?></h4>
<div class="row-fluid">
     <div class="span7">
    <?php echo $form->textFieldControlGroup($model,'first_name',array('class'=>'span6','maxlength'=>50,'data-required'=>'true')); ?>

    <?php echo $form->textFieldControlGroup($model,'last_name',array('class'=>'span6','maxlength'=>50,'data-required'=>'true')); ?>

    <?php echo $form->textFieldControlGroup($model,'mobile_no',array('class'=>'span6','maxlength'=>15)); ?>

    <?php echo $form->textFieldControlGroup($model,'adddress1',array('class'=>'span6','maxlength'=>60)); ?>

    <?php echo $form->textFieldControlGroup($model,'address2',array('class'=>'span6','maxlength'=>60)); ?>

    <?php echo $form->textFieldControlGroup($model,'city_id',array('class'=>'span6')); ?>

    <?php echo $form->textFieldControlGroup($model,'country_code',array('class'=>'span6','maxlength'=>2)); ?>

    <?php echo $form->textFieldControlGroup($model,'email',array('class'=>'span6','maxlength'=>30,'data-type'=>'email')); ?>

    <?php echo $form->textAreaControlGroup($model,'notes',array('rows'=>2, 'cols'=>20, 'class'=>'span6')); ?>
     </div>
</div>
<?php //$this->endWidget(); ?>     

