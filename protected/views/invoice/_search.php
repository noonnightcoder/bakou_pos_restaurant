<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	//'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'inline',  
        'htmlOptions'=>array('onsubmit'=>'return false;'),
)); ?>

	<label class="control-label" for="from_date">Start Date</label>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'name'=>'from_date',
                    'attribute'=>'from_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        //'style'=>'height:20px;',
                        'class'=>'span2',
                    ),
                ));
           
         ?>
        
        <label class="control-label" for="to_date">End Date</label>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'name'=>'to_date',
                    'attribute'=>'to_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        //'style'=>'height:20px;',
                        'class'=>'span2',
                    ),
                ));
           
         ?>
        
        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'label'=>'Go', 
                        'htmlOptions'=>array(
                            'ajax'=>array(
                                'type'=>'get',
                                'dataType'=>'json',
                                'url'=>Yii::app()->createUrl('invoice/Report/'),
                                'success'=>'function (data) {
                                             $("#data").html(data.div);
                                             console.log(data.status);
                                             //$.fn.yiiGridView.update("sale-transaction-grid");
                                       }'
                            )
                        )
        )); ?>
        
	<?php //echo $form->textFieldRow($model,'date_issued',array('class'=>'span4','hint'=>'>=2013-05-26  or <=2013-05-23' )); ?>

        <?php /* echo $form->textFieldRow($model,'flag',array('class'=>'span4',
                                            'maxlength'=>100,
                                            'hint'=>'1=Yes ; 0=No',
            )); 
            */
        
        ?>

<?php $this->endWidget(); ?>
