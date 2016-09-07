<?php foreach ($values as $key => $val): ?>
    <div class="form-group"> 
        <?php echo CHtml::label($model->getAttributesLabels($key), $key, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
        <div class="col-sm-9">
        <?php 
            echo CHtml::checkBox(get_class($model) . '[' . $category . '][' . $key . ']', $val,array('class'=>'ace-checkbox-2'));
            echo '<span class="lbl"></span>';
        ?>
        <?php echo CHtml::error($model, $category); ?>
        </div>    
    </div>
<?php endforeach; ?>
