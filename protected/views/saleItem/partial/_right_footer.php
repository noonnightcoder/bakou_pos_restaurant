<div class="widget-toolbox padding-8 clearfix" id="payment_footer_cart">
    <div class="pull-right">
        <?php if ($count_payment > 0 && $amount_due <= 0) { ?>
            <?php echo TbHtml::linkButton(Yii::t('app', 'Print Receipt'), array(
                'id' => 'finish_sale_button',
                'color' => TbHtml::BUTTON_COLOR_INFO,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'glyphicon-off white',
                'url' => Yii::app()->createUrl('SaleItem/CompleteSale/'),
                'class' => 'complete-sale pull-right',
                'title' => Yii::t('app', 'Complete Sale'),
            )); ?>
        <?php } else { ?>
            <?php echo TbHtml::linkButton(Yii::t('app', 'Payment'), array(
                'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                'size' => TbHtml::BUTTON_SIZE_SMALL,
                'icon' => 'glyphicon-heart white',
                'url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                'class' => 'add-payment pull-right',
                'title' => Yii::t('app', 'Add Payment'),
            )); ?>
        <?php } ?>
        <div style="display: none;">
            <?php echo $form->dropDownList($model, 'payment_type',
                InvoiceItem::itemAlias('payment_type'),
                array('class' => 'span3 pull-right', 'id' => 'payment_type_id')); ?>
        </div>
        <div class="pull-right">
            <?php /*echo $form->textField($model,'payment_amount',array('class'=>'input-medium numpad','style'=>'text-align: right',
                                        'maxlength'=>10,'id'=>'payment_amount_id','data-url'=>Yii::app()->createUrl('SaleItem/AddPayment/'),
                                        'placeholder'=>Yii::t('app','Payment Amount'),
                            )); */ ?>
            <?php echo $form->textField($model, 'payment_amount', array(
                //'value' => '', //$amount_change,
                'class' => 'input-medium text-right payment-amount-txt numpad',
                'id' => 'payment_amount_id',
                'data-url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                'placeholder' => Yii::t('app',
                        'Payment Amount') . ' ' . Yii::app()->settings->get('site',
                        'currencySymbol'),
                //'prepend' =>  Yii::app()->settings->get('site', 'currencySymbol'),
            ));
            ?>

        </div>
        <div class="pull-right"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
        <div class="pull-right">
            <?php
            if (isset($giftcard_info)) {
                $this->renderPartial('partial/_right_giftcard_selected', array(
                    'model' => $model,
                    'giftcard_info' => $giftcard_info,
                    'giftcard_id' => $giftcard_id
                ));
            } else {
                $this->renderPartial('partial/_right_giftcard', array('model' => $model));
            }
            ?>
        </div>
    </div>
    <div class="pull-left" id="btn_footer">

        <!--<div class="btn-group print_kitchen">
            <button class="btn btn-primary btn-white dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                <i class="ace-icon fa fa-print"></i>
                <?/*= Yii::t('app', 'Printing'); */?>
                <i class="ace-icon fa fa-angle-down icon-on-right"></i>
            </button>
            <ul class="dropdown-menu">
                <?php /*foreach ($print_categories as $print_category): */?>
                    <li>
                        <a href="<?/*= Yii::app()->createUrl('SaleItem/PrintKitchen/',
                            array('category_id' => $print_category['id'])) */?>"><?/*= Yii::t('app',
                                $print_category['name']); */?></a>
                    </li>
                <?php /*endforeach; */?>
                <li>
                    <a href="<?/*= Yii::app()->createUrl('SaleItem/PrintCustomer/') */?>"><?/*= Yii::t('app',
                            'Customer'); */?></a>
                </li>
            </ul>
        </div>-->

        <?php foreach ($print_categories as $print_category): ?>

        <?php echo TbHtml::linkButton(Yii::t('app', $print_category['name']), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_SMALL,
            'icon' => ' ace-icon fa fa-print',
            'class' => 'btn-confirm-order',
            'url' => Yii::app()->createUrl('SaleItem/PrintKitchen'),
            'title' => Yii::t('app', 'Customer'),
        )); ?>

        <?php endforeach; ?>

        <?php echo TbHtml::linkButton(Yii::t('app', 'Customer'), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_SMALL,
            'icon' => ' ace-icon fa fa-print',
            'class' => 'btn-confirm-order',
            'url' => Yii::app()->createUrl('SaleItem/PrintCustomer'),
            'title' => Yii::t('app', 'Customer'),
        )); ?>


        <?php /* echo TbHtml::linkButton(Yii::t('app', 'Confirm'), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_SMALL,
            'icon' => ' ace-icon fa fa-floppy-o white',
            'class' => 'btn-confirm-order',
            'url' => Yii::app()->createUrl('SaleItem/confirmOrder'),
            'title' => Yii::t('app', 'Confirm Order'),
        )); */?>

    </div>
</div><!--/endtoolbarfooter-->