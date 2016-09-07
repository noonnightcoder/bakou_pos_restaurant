<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <span class="input-icon">
        <?php echo CHtml::activeTelField($model, 'name',
            array('class' => 'col-xs-12', 'placeholder' => Yii::t('app', 'Search'))); ?>
    <i class="ace-icon fa fa-search nav-search-icon"></i>
    </span>

<?php $this->endWidget(); ?>
