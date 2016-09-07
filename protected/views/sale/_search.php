<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'searchForm',
    'type'=>'search',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php //echo $form->dropDownListRow($model,'payment_type',Sale::itemAlias('register_mode'), array('class'=>'input-medium')); ?>
<?php //echo $form->textFieldRow($model, 'search', array('class'=>'span4', 'append'=>'<i class="icon-search"></i>')); ?>
<?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); ?>
 
<?php $this->endWidget(); ?>
