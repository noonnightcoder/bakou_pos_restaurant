<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?> 
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
        //'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
        <?php  
                $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'asDropDownList' => false,
                    'model'=> $model, 
                    'attribute'=>'supplier_id',
                    'pluginOptions' => array(
                            'placeholder' => Yii::t('app','Type supplier name / phone number'),
                            'multiple'=>false,
                            'width' => '75%',
                            'tokenSeparators' => array(',', ' '),
                            'allowClear'=>false,
                            //'minimumInputLength'=>0,
                            'ajax' => array(
                                'url' => Yii::app()->createUrl('Supplier/getSupplier/'), 
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
   
           <?php echo TbHtml::linkButton(Yii::t( 'app', 'New' ),array(
                'color'=>TbHtml::BUTTON_COLOR_INFO,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'glyphicon-plus white',
                'url'=>$this->createUrl('Supplier/AddSupplier/'),
                'class'=>'update-dialog-open-link',
                 'data-update-dialog-title' => Yii::t( 'app', 'form.supplier._form.header_create' ),
            )); ?>
           
            <div id="comment_content">
                <?php echo $form->textFieldControlGroup($model,'comment',array('rows'=>1, 'cols'=>10,'class'=>'span1','maxlength'=>250,'id'=>'comment_id')); ?>
            </div>
             
<?php $this->endWidget(); ?>

<?php 
    Yii::app()->clientScript->registerScript( 'selectSupplier', "
        jQuery( function($){
            $('#ReceivingItem_supplier_id').on('change', function(e) {
                e.preventDefault();
                var remote = $('#ReceivingItem_supplier_id');
                var supplier_id=remote.val();
                var supplierCart=$('#supplier_cart');
                $.ajax({url: 'SelectSupplier',
                        dataType : 'json',
                        data : {supplier_id : supplier_id},
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    supplierCart.html(data.div_suppliercart);   
                                    remote.select2('data', null);
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
