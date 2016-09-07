<?php
$this->breadcrumbs=array(
	'Customer'=>array('admin'),
	'Manage',
);
?>
<div class="row">
    <div class="col-xs-12 widget-container-col ui-sortable">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('client-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        ?>

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                      'title' => Yii::t( 'app', 'form.client.admin.header_title' ),
                      'headerIcon' => 'icon-user',
        ));?> 

        <?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
        <div class="search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
        </div><!-- search-form -->

        <?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

        <?php echo TbHtml::linkButton(Yii::t( 'app', 'form.button.addnew' ),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'glyphicon-plus white',
                'url'=>$this->createUrl('create'),
                'class'=>'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t( 'app', 'form.client._form.header_create' ),
                'data-refresh-grid-id'=>'client-grid',
        )); ?>

        <?php /* echo TbHtml::linkButton(Yii::t( 'app', 'Set Customer & Item' ),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'glyphicon-plus white',
                'url'=>$this->createUrl('clientItem/index'),
        )); */ ?>

        <?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
                'id'=>'client-grid',
                'fixedHeader' => true,
                'type' => TbHtml::GRID_TYPE_HOVER,
                //'headerOffset' => 40,
                //'responsiveTable' => true,
                'dataProvider'=>$model->search(),
                //'filter'=>$model,
                'columns'=>array(
                        'first_name',
                        'last_name',
                        'mobile_no',
                        'address1',
                        /*
                        array('name' =>'balance',
                              'header'=>'Balance',
                              'value' =>array($this,"gridBalance"),
                        ),
                         * 
                        */
                        //'address2',
                        /*
                        array('name'=>'account',
                              'header'=>Yii::t('app','Current Balance'),
                              'value'=>'$data->account->balance',
                        ),
                         * 
                        */
                        array('class'=>'bootstrap.widgets.TbButtonColumn',
                            'header'=> Yii::t('app','Edit'),  
                              //'template'=>'{delete}{update}{invoice}{payment}',
                              'template'=>'{update}{delete}',  
                              'htmlOptions'=>array('class'=>'nowrap'),
                              'buttons' => array(
                                  'update' => array(
                                    'click' => 'updateDialogOpen',
                                    'icon' => 'ace-icon fa fa-edit',
                                    'options' => array(
                                        'data-update-dialog-title' => Yii::t( 'app', 'form.client._form.header_update' ),
                                        'data-refresh-grid-id'=>'client-grid',
                                        'class'=>'btn btn-xs btn-info',
                                      ), 
                                  ), 
                                  'delete' => array(
                                    'url'=>'Yii::app()->createUrl("client/delete/",array("id"=>$data->id))',
                                    'options' => array(
                                        'class'=>'btn btn-xs btn-danger',
                                      ),   
                                  ),
                                    
                                 /* 
                                 'invoice' => array(
                                     'label'=>'Invoices',
                                     'url'=>'Yii::app()->createUrl("sale/viewInvoice/",array("client_id"=>$data->id))',
                                     'options' => array(
                                        'class'=>'btn btn-small btn-info',
                                        'title'=>'Invoice History',
                                      ), 
                                  ),
                                  'payment' => array(
                                     'label'=>'Payment',
                                     'url'=>'Yii::app()->createUrl("sale/Invoice/",array("client_id"=>$data->id))',
                                     'options' => array(
                                        'class'=>'btn btn-small btn-warning',
                                        'title'=>'Enter Payment',
                                      ), 
                                  ),
                                  * 
                                  */
                               ),
                        ),
                ),
        )); ?>

        <?php echo TbHtml::linkButton(Yii::t( 'app', 'form.button.addnew' ),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'glyphicon-plus white',
                'url'=>$this->createUrl('create'),
                'class'=>'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t( 'app', 'form.client._form.header_create' ),
        )); ?>

        <?php $this->endWidget(); ?>
    </div>
</div>
