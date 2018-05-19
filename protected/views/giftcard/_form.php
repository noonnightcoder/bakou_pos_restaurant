<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'id'=>'giftcard-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'giftcard_number',array('span'=>5,'maxlength'=>60)); ?>

            <?php echo $form->textFieldControlGroup($model,'discount_amount',array('span'=>5,'maxlength'=>15)); ?>

            <?php //echo $form->textFieldControlGroup($model,'discount_type',array('span'=>5,'maxlength'=>2)); ?>

            <?php //echo $form->textFieldControlGroup($model,'status',array('span'=>5,'maxlength'=>1)); ?>

            <?php //echo $form->textFieldControlGroup($model,'client_id',array('span'=>5)); ?>

            <div class="form-group">

                <label class="col-sm-3 control-label" for="Giftcard_startdate"><?php echo Yii::t('app','Start Date') ?></label>

                <div class="col-sm-9">

                    <?php echo CHtml::activeDropDownList($model, 'day', Common::arrayFactory('day'), array('value' => 1)); ?>

                    <?php echo CHtml::activeDropDownList($model, 'month', Common::arrayFactory('month'), array('prompt' => yii::t('app','Month'))); ?>

                    <?php echo CHtml::activeDropDownList($model, 'year', Common::arrayFactory('exp_year'), array('prompt' => yii::t('app','Year'))); ?>

                    <span class="help-block"> <?php echo $form->error($model,'start_date'); ?> </span>
                </div>

            </div>

            <div class="form-group">

                <label class="col-sm-3 control-label" for="Giftcard_enddate"><?php echo Yii::t('app','End Date') ?></label>

                <div class="col-sm-9">

                    <?php echo CHtml::activeDropDownList($model, 'e_day', Common::arrayFactory('day'), array('value' => 1)); ?>

                    <?php echo CHtml::activeDropDownList($model, 'e_month', Common::arrayFactory('month'), array('prompt' => yii::t('app','Month'))); ?>

                    <?php echo CHtml::activeDropDownList($model, 'e_year', Common::arrayFactory('exp_year'), array('prompt' => yii::t('app','Year'))); ?>

                    <span class="help-block"> <?php echo $form->error($model,'end_date'); ?> </span>
                </div>

            </div>

            <?php echo $form->dropDownListControlGroup($model,'location_id', Location::model()->getLocation()); ?>

            <?php /*echo $form->dropDownListControlGroup($model,'client_id', Client::model()->getCustomer(),array('prompt'=>'No Customer')); */?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->