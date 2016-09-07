<script>
function printpage()
{
    var mymenu = document.getElementById('menu');
    mymenu.style.display = "hide";
    var myFooter= document.getElementById('footer');
    myFooter.style.display = "none";
    var mybutton = document.getElementById('mybutton');
    mybutton.style.display = "none";
    var mybreak = document.getElementById('ibreak');
    mybreak.style.display = "none";
    //Whatever other elements to hide.
    window.print();
    return true;
}
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'invoice-payment-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('class'=>'well'),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

        <div style="display:none">
	<?php echo $form->textFieldRow($model,'invoice_id',array('class'=>'span4')); ?>
        </div>
            
	<?php echo $form->textFieldRow($model,'invoice_number',array('class'=>'span4','maxlength'=>50,'readonly'=>true)); ?>
        
        <?php echo $form->textFieldRow($model,'amount',array('class'=>'span4','maxlength'=>50,'readonly'=>true,'id'=>'amount_id')); ?>
        
        <?php echo $form->textFieldRow($model,'amount_paid',array('class'=>'span4','maxlength'=>10,'id'=>'amount_paid_id')); ?>
        
        <?php echo $form->textFieldRow($model,'give_away',array('class'=>'span4','maxlength'=>10,'id'=>'give_away_id')); ?>

	<?php //echo $form->textFieldRow($model,'date_paid',array('class'=>'span4')); ?>
        
        <div class="control-group">
            <label class="control-label" for="date_paid">Payment Date</label>   
            <div class="controls">
            <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'name'=>'date_paid',
                    'attribute'=>'date_paid',
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

	<?php echo $form->textAreaRow($model,'note',array('rows'=>2, 'cols'=>10, 'class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($model,'modified_date',array('class'=>'span4')); ?>

	<div class="form-actions" id="mybutton">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
                
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create & Print' : 'Save & Print',
                        'htmlOptions'=>array('onclick'=>'{printpage();}'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
                
 <?php
    Yii::app()->clientScript->registerScript( 'giveawayOnFucus', "
        jQuery( function($){
            $(document).on('click focusin','#amount_paid_id',function(e) {
                this.value = '';
            });
        });
      ");
 ?>

<?php
    Yii::app()->clientScript->registerScript( 'calculateGiveAway', "
        jQuery( function($){
            $(document).on('change','#amount_paid_id',function(e) {
                var paidAmount=$(this).val();
                var amount=$('#amount_id').val();
                var give_away;
                give_away=amount-paidAmount;
                if (give_away<0)
                {
                    alert('Paid Amount should be less than Owe Amount');
                    return false;
                }
                else
                {
                    $('#give_away_id').val(give_away);
                }
            });
        });
      ");
 ?> 
        



