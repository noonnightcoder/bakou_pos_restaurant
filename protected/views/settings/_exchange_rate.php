<?php foreach ($values as $key => $val): ?>
    <div class="form-group">
        <?php echo CHtml::label($model->getAttributesLabels($key), $key,
            array('class' => 'col-sm-3 control-label no-padding-right')); ?>
        <div class="col-sm-9">
            <?php
            echo CHtml::textField(get_class($model) . '[' . $category . '][' . $key . ']', $val, array(
                'class' => 'span4',
                'data-type' => 'number',
                'placeholder' => Yii::app()->settings->get('site',
                        'currencySymbol') . ' To ' . Yii::app()->settings->get('site', 'altcurrencySymbol'),
            ));
            ?>
            <?php echo CHtml::error($model, $category); ?>
        </div>
    </div>
<?php endforeach; ?>

