<?php 
    if(isset($supplier)) 
    {
        $this->widget('yiiwheels.widgets.box.WhBox', array(
               'title' => Yii::t('app','Select Supplier (Optional)'),
               'headerIcon' => 'menu-icon fa fa-users',
               'content' => $this->renderPartial('_supplier_selected',array('model'=>$model,'supplier'=>$supplier,'supplier_mobile_no'=>$supplier_mobile_no,'count_item'=>$count_item),true),
         ));
    }else 
    { 
        $this->widget('yiiwheels.widgets.box.WhBox', array(
               'title' => Yii::t('app','Select Supplier (Optional)'),
               'headerIcon' => 'menu-icon fa fa-users',
               'content' => $this->renderPartial('_supplier',array('model'=>$model,'count_item'=>$count_item),true)
         ));
    }
?>