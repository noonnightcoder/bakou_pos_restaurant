<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        //'htmlOptions'=>array('class'=>'well'),
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'client_id',array('class'=>'span4','id'=>'clientId')); ?>
        
        <?php if($model->isNewRecord) { ?>
        <div class="control-group">
        <label class="control-label" for="client_id">Client</label>    
        <div class="controls">
            <?php  
                $this->widget('bootstrap.widgets.TbSelect2', array(
                    'asDropDownList' => false,
                    'model'=> $model, 
                    //'name' => 'client_id',
                    'attribute'=>'client_id',
                    'options' => array(
                            'placeholder' => 'Type for hints...',
                            'multiple'=>false,
                            'width' => '100%',
                            'tokenSeparators' => array(',', ' '),
                            'allowClear'=>false,
                            'minimumInputLength'=>2,
                            'ajax' => array(
                                'url' => Yii::app()->createUrl('Client/getClient/'), 
                                'dataType' => 'json',
                                'data' => 'js:function(term,page) {
                                            return {
                                                term: term, 
                                                page_limit: 10,
                                                quietMillis: 10,
                                                apikey: "e5mnmyr86jzb9dhae3ksgd73" // Please create your own key!
                                            };
                                        }',
                                'results' => 'js:function(data,page){
                                    return {results: data.results};
                                }',
                            ),
                    )));
            ?>
        </div>
        </div>
        
         <?php }else 
            {
             echo $form->dropDownListRow($model,'client_id', CHtml::listData(Client::model()->findAll(), 'id', 'fullname'),array('class'=>'span4'));
            }
         ?>
        
	<?php echo $form->textFieldRow($model,'invoice_number',array('class'=>'span4','maxlength'=>50)); ?>
        
        <?php echo $form->textFieldRow($model,'amount',array('class'=>'span4')); ?>
       
        <?php echo $form->textFieldRow($model,'work_description',array('class'=>'span4')); ?>
                
        <?php //echo $form->textFieldRow($mod_invoice_item,'discount',array('class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($model,'date_issued',array('class'=>'span4','id'=>'dateissueId')); ?>
        <div class="control-group">
            <label class="control-label" for="date_issued">Date Issued</label>   
            <div class="controls">
            <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'name'=>'date_issued',
                    'attribute'=>'date_issued',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;',
                        'class'=>'span4',
                    ),
                ));
            ?>
            </div>
        </div>

	<?php //echo $form->textFieldRow($model,'payment_term',array('class'=>'span4','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'taxt1_rate',array('class'=>'span4','maxlength'=>6)); ?>

	<?php //echo $form->textFieldRow($model,'tax1_desc',array('class'=>'span4','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'tax2_rate',array('class'=>'span4','maxlength'=>6)); ?>

	<?php //echo $form->textFieldRow($model,'tax2_desc',array('class'=>'span4','maxlength'=>100)); ?>

	<?php //echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'day_payment_due',array('class'=>'span4')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
</div>

