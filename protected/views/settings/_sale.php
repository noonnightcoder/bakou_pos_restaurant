<?php foreach ($values as $key => $val): ?>
    <div class="form-group"> 
        <?php echo CHtml::label($model->getAttributesLabels($key), $key, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
        <div class="col-sm-9">
        <?php 
            if($key === 'receiptPrintDraftSale' || $key === 'receiptPrint'){
                echo CHtml::checkBox(get_class($model) . '[' . $category . '][' . $key . ']', $val); 
                echo '<span class="lbl"></span>';
            } else if ($key === 'touchScreen') {
                echo CHtml::checkBox(get_class($model) . '[' . $category . '][' . $key . ']', $val); 
                echo '<span class="lbl"></span>';
            } else if ($key === 'saleCookie') {
                echo CHtml::dropDownList(get_class($model) . '[' . $category . '][' . $key . ']',$val,array('0'=>'No','1'=>'Yes'));
            } else if ($key === 'discount') {
                echo CHtml::dropDownList(get_class($model) . '[' . $category . '][' . $key . ']',$val,array(''=>'Yes','hidden'=>'No'));    
            } else  {
                echo CHtml::textField(get_class($model) . '[' . $category . '][' . $key . ']', $val, array('class'=>'span4')); 
            }
 
        ?>
        <?php echo CHtml::error($model, $category); ?>
        </div>    
    </div>
<?php endforeach; ?>
