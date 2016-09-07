<?php 
    if(isset($customer)) 
    {
        $this->widget('yiiwheels.widgets.box.WhBox', array(
               'title' => Yii::t('app','form.sale.client_title'), //'Select Customer (Optional)',
               'headerIcon' => 'icon-user',
               'content' => $this->renderPartial('_client_selected',array('model'=>$model,'customer'=>$customer,'customer_mobile_no'=>$customer_mobile_no),true)
         ));
    }else 
    { 
        $this->widget('yiiwheels.widgets.box.WhBox', array(
               'title' => Yii::t('app','form.sale.client_title'),
               'headerIcon' => 'icon-user',
               'content' => $this->renderPartial('_client',array('model'=>$model),true)
         ));
    }
?>