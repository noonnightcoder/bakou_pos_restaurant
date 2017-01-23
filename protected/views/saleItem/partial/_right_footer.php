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

        <?php foreach ($print_categories as $print_category): ?>

        <?php echo TbHtml::linkButton(Yii::t('app', $print_category['name']), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_SMALL,
            'icon' => ' ace-icon fa fa-print',
            //'class' => 'btn-confirm-order',
            'url' => Yii::app()->createUrl('SaleItem/PrintKitchen'),
            'title' => Yii::t('app', 'Customer'),
        )); ?>

        <?php endforeach; ?>

        <?php echo TbHtml::linkButton(Yii::t('app', 'Customer'), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_SMALL,
            'icon' => ' ace-icon fa fa-print',
            //'class' => 'btn-confirm-order',
            'url' => Yii::app()->createUrl('SaleItem/PrintCustomer'),
            'title' => Yii::t('app', 'Customer'),
        )); ?>


    </div>
</div><!--/endtoolbarfooter-->