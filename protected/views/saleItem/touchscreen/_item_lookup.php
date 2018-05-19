<div id="itemlookup">   
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
             'action'=>Yii::app()->createUrl('saleItem/add'),
             'method'=>'post',
             'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
             'id'=>'add_item_form',
     )); ?>     

         <?php //if (isset($table_id)) { ?>
             <?php 
             $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                     'model'=>$model,
                     'attribute'=>'item_id',
                     'source'=>$this->createUrl('request/suggestItem'),    
                     'htmlOptions'=>array(
                         'size'=>'35'
                     ),
                     'options'=>array(
                         'showAnim'=>'fold',
                         'minLength'=>'1',
                         'delay' => 10,
                         'autoFocus'=> false,
                         'select'=>'js:function(event, ui) {
                             event.preventDefault();
                             $("#SaleItem_item_id").val(ui.item.id);
                             $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess});
                             $("#quantity_" + ui.item.id).select();
                         }',
                     ),
                 ));
             ?>
         <?php //} ?>

         <span class="lable">
             <?php if (isset($table_info)) { echo '<b>Serving Table : ' . $table_info->name  .' - ' . Common::GroupAlias(Yii::app()->orderingCart->getGroupId()) . '</b>';} ?>
         </span>

    <?php $this->endWidget(); ?> <!--/endformWidget--> 
</div>