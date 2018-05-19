<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(       
         'id'=>'giftcard_form',
        'action'=>Yii::app()->createUrl('saleItem/SetDisGiftcard'),
        'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<?php 
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model'=>$model,
            'attribute'=>'giftcard_id',
            'source'=>$this->createUrl('request/suggestGiftcard'),
            'htmlOptions'=>array(
                'size'=>'20',
                'placeholder'=>Yii::t('app','Gift Card'),
            ),
            'options'=>array(
                'showAnim'=>'fold',
                'minLength'=>'3',
                'delay' => 10,
                'autoFocus'=> false,
                'select'=>'js:function(event, ui) {
                    event.preventDefault();
                    $("#SaleItem_giftcard_id").val(ui.item.id);
                    $("#giftcard_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit });
                }',
            ),
        ));
?>

<?php /*
    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
        'asDropDownList' => false,
        'model'=> $model, 
        'attribute'=>'giftcard_id',
        'pluginOptions' => array(
                'placeholder' => Yii::t('app','Type / Scan giftcard number'),
                'multiple'=>true,
                'width' => '100%',
                'tokenSeparators' => array(',', ' '),
                'allowClear'=>false,
                'minimumInputLength'=>6,
                'ajax' => array(
                    'url' => Yii::app()->createUrl('giftcard/getGiftcard/'), 
                    'dataType' => 'json',
                    'data' => 'js:function(term,page) {
                                return {
                                    term: term, 
                                    page_limit: 10,
                                    quietMillis: 10,
                                    apikey: "e5mnmyr86jzb9dhae3ksgd73"
                                };
                            }',
                    'results' => 'js:function(data,page){
                        return {results: data.results};
                    }',
                ),
        )));
    * 
    */
  ?>

<?php $this->endWidget(); ?>

<?php /*
    Yii::app()->clientScript->registerScript( 'selectGiftcard', "
        jQuery( function($){
            $('#grid_cart').on('change','#SaleItem_giftcard_id', function(e) {
                e.preventDefault();
                var remote = $('#SaleItem_giftcard_id');
                var giftcard_id=remote.val();
                var gridCart=$('#grid_cart');
                $.ajax({url: 'SetDisGiftcard',
                        dataType : 'json',
                        data : {giftcard_id : giftcard_id},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    //gridCart.html(data.div_gridcart);
                                    //remote.select2('data', null);
                                    location.reload(true);
                                }
                                else 
                                {
                                   console.log(data.message);
                                   
                                }
                          }
                    });
                });
        });
      ");
        * 
        */
 ?> 
