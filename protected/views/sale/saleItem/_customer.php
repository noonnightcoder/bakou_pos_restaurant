<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'searchForm',
    'type'=>'search',
    //'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

<?php echo $form->textFieldRow($model, 'customer_id', array('class'=>'input-large', 'prepend'=>'<i class="icon-search"></i>')); ?> OR
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'New Customer',
    'type'=>'success',
    'size'=>'small',
    'buttonType'=>'link',
    'icon'=>'plus white',
    'url'=>$this->createUrl('client/create'),
    'htmlOptions'=>array(
        'class'=>'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'app', 'New Customer' ),
    ), 
)); ?>
<?php $this->endWidget(); ?>
