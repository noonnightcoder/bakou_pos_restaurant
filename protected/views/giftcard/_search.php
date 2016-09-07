<?php $form = $this->beginWidget('\TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'layout' => TbHtml::FORM_LAYOUT_SEARCH,
)); ?>

<?php //echo $form->textFieldControlGroup($model, 'giftcard_number', array('span' => 5, 'maxlength' => 60)); ?>

<span class="input-icon">
    <?php echo CHtml::activeTelField($model, 'giftcard_number',
        array('class' => 'col-xs-12', 'placeholder' => Yii::t('app', 'Search'))); ?>
    <i class="ace-icon fa fa-search nav-search-icon"></i>
</span>
<?php $this->endWidget(); ?>

