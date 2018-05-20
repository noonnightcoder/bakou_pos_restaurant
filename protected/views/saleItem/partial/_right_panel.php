<!-- #section:right.panel.layout -->
<div class="col-xs-12 col-sm-8 widget-container-col">

    <?php //$this->renderPartial('//layouts/alert/_gritter'); ?>
    <?php $this->renderPartial('//layouts/alert/_flash'); ?>

    <div class="grid-view widget-box" id="grid_cart">
        <div class="widget-header widget-header-flat">
            <i class="ace-icon fa fa-shopping-cart"></i>
            <h5 class="widget-title"><?= Yii::t('app','Ordering Cart'); ?></h5>

            <div class="widget-toolbar">

                <?php echo TbHtml::linkButton(Yii::t('app', 'Close Register'), array(
                    'color' => TbHtml::BUTTON_COLOR_DEFAULT,
                    'size' => TbHtml::BUTTON_SIZE_MINI,
                    'icon' => 'glyphicon-print white',
                    'url' => Yii::app()->createUrl('SaleItem/PrintCloseSale'),
                    'class' => 'close-register',
                    'title' => Yii::t('app', 'Print Report for Closing Sale'),
                )); ?>

                <div class="badge badge-info">
                    <?php echo Yii::t('app', 'Item in Cart') . ' : ' . $count_item; ?>
                </div>

                <?php /* echo TbHtml::linkButton('Merge Order',array(
                            'color'=>TbHtml::BUTTON_COLOR_INVERSE,
                            'size'=>TbHtml::BUTTON_SIZE_MINI,
                            'icon'=>'glyphicon-plus',
                            'url'=>$this->createUrl('Desk/MergeDesk/'),
                            'class'=>'update-dialog-open-link',
                            'data-update-dialog-title' => Yii::t('app','Merging Table'),
                        )); */ ?>

                <?php //$this->renderPartial('partial/_right_toolbar_ch_desk'); ?>

                <?php if (isset($table_info)) { ?>

                    <?php echo TbHtml::linkButton(Yii::t('app','Change Table'), array(
                        'color' => TbHtml::BUTTON_COLOR_INVERSE,
                        'size' => TbHtml::BUTTON_SIZE_MINI,
                        'icon' => 'glyphicon-refresh',
                        'url' => $this->createUrl('Desk/ChangeDesk/', array('location_id' => $location_id)),
                        'class' => 'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app', 'Change Table'),
                    )); ?>

                <?php } else { ?>

                    <?php echo TbHtml::linkButton('Change Table', array(
                        'color' => TbHtml::BUTTON_COLOR_INVERSE,
                        'size' => TbHtml::BUTTON_SIZE_MINI,
                        'icon' => 'glyphicon-refresh',
                        'url' => $this->createUrl('Desk/ChangeDesk/', array('location_id' => $location_id)),
                        'class' => 'update-dialog-open-link',
                        'title' => Yii::t('app', 'Select a table to change'),
                        'disabled' => true
                    )); ?>

                    <?php echo TbHtml::tooltip('<i class="ace-icon fa  fa-info-circle "></i>', '#',
                        'Plz, select a table to change',
                        array('data-html' => 'true', 'placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,)
                    ); ?>

                <?php } ?>

            </div>

        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="row">
                    <div class="col-xs-12 col-sm-12" id="itemlookup">
                        <tr>
                            <td>
                                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                    'action' => Yii::app()->createUrl('saleItem/add'),
                                    'method' => 'post',
                                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                                    'id' => 'add_item_form',
                                )); ?>
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                        'model' => $model,
                                        'attribute' => 'item_id',
                                        'source' => $this->createUrl('request/suggestItem'),
                                        'htmlOptions' => array(
                                            'size' => '28'
                                        ),
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => '1',
                                            'delay' => 10,
                                            'autoFocus' => false,
                                            'select' => 'js:function(event, ui) {
                                                             event.preventDefault();
                                                             $("#SaleItem_item_id").val(ui.item.id);
                                                             $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess(ui.item.id) });
                                                         }',
                                        ),
                                    ));
                                    ?>

                                <?php $this->renderPartial('partial/_right_status', array(
                                    'model' => $model,
                                    'table_info' => $table_info,
                                    'time_go' => $time_go,
                                    'ordering_status' => $ordering_status,
                                    'ordering_msg' => $ordering_msg,
                                    'ordering_status_span' => $ordering_status_span,
                                    'ordering_status_icon' => $ordering_status_icon,
                                )); ?>
                            </td>
                            <td>
                                <?php $this->endWidget(); ?>
                            </td>
                        </tr>
                    </div>
                    <!--<div class="col-xs-12 col-sm-3 align-right" id="order_status">
                        <?php /*$this->renderPartial('partial/_right_status', array(
                            'model' => $model,
                            'table_info' => $table_info,
                            'time_go' => $time_go,
                            'ordering_status' => $ordering_status,
                            'ordering_msg' => $ordering_msg,
                            'ordering_status_span' => $ordering_status_span,
                            'ordering_status_icon' => $ordering_status_icon,
                        )); */?>
                    </div>-->
                </div>

                <br>

                <!--<div class="row">
                    <?php /*$this->renderPartial('partial/_right_menu', array(
                        'model' => $model,
                        'table_info' => $table_info,
                        'items' => $items,
                        'sub_total' => $sub_total,
                        //'amount_due' => $amount_due,
                        'count_payment' => $count_payment,
                        'count_item' => $count_item,
                        'form' => $form,
                    )); */?>
                </div>-->


                <div class="row">
                    <?php $this->renderPartial('partial/_right_menu_sub', array(
                            'form' => $form,
                            'items' => $items,
                            'model' => $model,
                        ))
                    ?>
                </div>

                <?php echo TbHtml::buttonDropdown('All Cart', array(
                        array('label' => 'Summary Cart', 'url' => '#'),
                        TbHtml::menuDivider(),
                        array('label' => 'Cart 1', 'url' => '#'),
                        array('label' => 'Cart 2', 'url' => '#'),
                ), array('split' => true)); ?>


                <div class="row">
                    <div class="col-sm-5 pull-right">
                        <h4 class="pull-right">
                            <?php echo Yii::t('app', 'Total'); ?>
                            <span class="label label-xlg label-primary"><?php echo Yii::app()->settings->get('site',
                                        'currencySymbol') . number_format($sub_total,
                                        Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></span>
                        </h4>
                    </div>
                    <div class="col-sm-6 pull-right">
                        <h4 class="pull-right">
                            <?php echo Yii::t('app', 'Amount to Pay'); ?>
                            <span class="label label-xlg label-important"><?php echo Yii::app()->settings->get('site',
                                        'currencySymbol') . number_format($amount_due,
                                        Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></span>
                        </h4>
                    </div>
                </div>

                <?php if ($count_payment > 0) { ?>
                    <table class="table">
                        <tbody id="payment_content">
                        <?php foreach ($payments as $id => $payment): ?>
                            <tr>
                                <td><?php echo $payment['payment_type']; ?></td>
                                <td><?php echo Yii::app()->settings->get('site',
                                            'currencySymbol') . number_format($payment['payment_amount'],
                                            Yii::app()->shoppingCart->getDecimalPlace()); ?></td>
                                <td>
                                    <?php echo TbHtml::linkButton('', array(
                                        'color' => TbHtml::BUTTON_COLOR_DANGER,
                                        'size' => TbHtml::BUTTON_SIZE_MINI,
                                        'icon' => 'glyphicon-remove',
                                        'url' => Yii::app()->createUrl('SaleItem/DeletePayment',
                                            array('payment_id' => $payment['payment_type'])),
                                        'class' => 'delete-payment',
                                        'title' => Yii::t('app', 'Delete Payment'),
                                    )); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } ?>


                <?php if ($count_item <> 0) {
                    $this->renderPartial('partial/_right_footer',
                        array(
                            'model' => $model,
                            'count_payment' => $count_payment,
                            'amount_due' => $amount_due,
                            'form' => $form,
                            'print_categories' => $print_categories,
                            'giftcard_info' => $giftcard_info,
                            'giftcard_id' => $giftcard_id
                        ));
                } ?>

            </div>
            <!--/endwiget-main-->
        </div>
        <!--/endwiget-body-->

    </div>

</div>  <!--/end.right.panel-->