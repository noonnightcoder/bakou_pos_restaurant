<?php foreach ($values as $key => $val): ?>
    <div class="form-group"> 
        <?php echo CHtml::label($model->getAttributesLabels($key), $key, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
        <div class="col-sm-9">
        <?php 
            if ($key === 'language') {
                echo CHtml::dropDownList(get_class($model) . '[' . $category . '][' . $key . ']',$val,array('kh'=>Yii::t('app','Khmer'),'en'=>Yii::t('app','English')));
            } else if ($key === 'decimalPlace') {
                echo CHtml::dropDownList(get_class($model) . '[' . $category . '][' . $key . ']',$val,array(0=>'0',1=>'1',2=>'2',3=>'3',4=>'4'));
            } else if ($key === 'itemNumberPerPage') {
                echo CHtml::dropDownList(get_class($model) . '[' . $category . '][' . $key . ']',$val,  Common::arrayFactory('page_size'));

            } else  {
                echo CHtml::textField(get_class($model) . '[' . $category . '][' . $key . ']', $val, array('class'=>'span4')); 
            }
 
        ?>
        <?php echo CHtml::error($model, $category); ?>
        </div>    
    </div>
<?php endforeach; ?>
