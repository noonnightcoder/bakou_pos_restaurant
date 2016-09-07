<div id="employee_tab" style="width:1000px; margin:0 auto;">
    
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
              'title' => 'New Employee',
              'headerIcon' => 'icon-user',
              //'content' => $this->renderPartial('_form', array('model'=>$model), true),
 )); ?>  

<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>'Employee Basic Information', 'content'=>$this->renderPartial('create', array('model'=>$model), true), 'active'=>true),
        array('label'=>'Employee Login Info', 'content'=>$this->renderPartial('rbacUser/_form', array('user'=>$user), true)),
        //array('label'=>'Employee Permissions and Access', 'content'=>$this->renderPartial('create', array('model'=>$model), true)),
    ),
)); ?>

<?php  $this->endWidget(); ?>

</div>