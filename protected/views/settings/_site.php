<?php foreach ($values as $key => $val): ?>
    <div class="form-group"> 
        <?php echo CHtml::label($model->getAttributesLabels($key), $key, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
        <div class="col-sm-9">
        <?php 
           if ($key === 'currencySymbol' || $key === 'altcurrencySymbol') {
                echo CHtml::dropDownList(get_class($model) . '[' . $category . '][' . $key . ']',$val,CurrencyType::model()->getCurrency());
           } else { 
                echo CHtml::textField(get_class($model) . '[' . $category . '][' . $key . ']', $val, array('class'=>'col-xs-10 col-sm-5')); 
           }     
        ?>
        <?php echo CHtml::error($model, $category); ?>
        </div>    
    </div>
<?php endforeach; ?>
