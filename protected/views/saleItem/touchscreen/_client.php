<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?> 
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'client-form',
        'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

	<?php //echo $form->textFieldRow($model,'item_id',array('class'=>'span8','maxlength'=>100)); ?>
        
        <?php  
            $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                'asDropDownList' => false,
                'model'=> $model, 
                'attribute'=>'client_id',
                'pluginOptions' => array(
                        'placeholder' => Yii::t('app','form.sale.client_hint'),
                        'multiple'=>false,
                        'width' => '75%',
                        'tokenSeparators' => array(',', ' '),
                        'allowClear'=>false,
                        //'minimumInputLength'=>2,
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('Client/getClient/'), 
                            'dataType' => 'json',
                            'data' => 'js:function(term,page) {
                                        return {
                                            term: term, 
                                            page_limit: 10,
                                            quietMillis: 10,
                                            apikey: "e5mnmyr86jzb9dhae3ksgd73" // Please create your own key!
                                        };
                                    }',
                            'results' => 'js:function(data,page){
                                return {results: data.results};
                            }',
                        ),
                )));
          ?>

          <?php echo TbHtml::linkButton(Yii::t( 'app', '' ),array(
                'color'=>TbHtml::BUTTON_COLOR_INFO,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'glyphicon-plus white',
                'url'=>$this->createUrl('Client/AddCustomer'), //$this->createUrl('Client/Create/',array('sale_mode'=>'Y')),
                'class'=>'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t( 'app', 'form.client._form.header_create' ),
            )); ?> 
      
<?php $this->endWidget(); ?>

<?php 
    Yii::app()->clientScript->registerScript( 'selectCustomer', "
        jQuery( function($){
            $('#grid_cart').on('change','#SaleItem_client_id', function(e) {
                e.preventDefault();
                var remote = $('#SaleItem_client_id');
                var customer_id=remote.val();
                var gridCart=$('#grid_cart');
                $.ajax({url: 'SelectCustomer',
                        dataType : 'json',
                        data : {customer_id : customer_id},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    gridCart.html(data.div_gridcart);
                                    //remote.select2('data', null);
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
 ?> 
