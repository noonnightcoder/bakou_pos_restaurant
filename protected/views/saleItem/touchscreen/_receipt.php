<style>
#sale_return_policy {
    width: 80%;
    margin: 0 auto;
    text-align: center;
}   

/*Receipt styles start*/
#receipt_wrapper {
    font-family: Arial;
    width: 98% !important;
    font-size: 11px !important;
    margin: 0 auto !important;
    padding: 0 !important;
}

    
#receipt_items td {
  //position: relative;
  padding: 3px;
}      
</style>
<div class="container" id="receipt_wrapper"> 
    <!--
    <div class="row">
        <div class="col-xs-6">
            <h1> <img src="logo.png">Logo here</h1>
        </div>
        <div class="col-xs-6 text-right">
            <h1>INVOICE</h1>
            <h1><small>Invoice #001</small></h1>
        </div>
    </div>
    -->
    <div class="row">
        <div class="col-xs-6">
            <p>
                <?php echo TbHtml::image(Yii::app()->baseUrl . '/images/vitking_house.jpg','Company\'s logo',array('width'=>'150')); ?> <br>
                <!--
                <?php //echo TbHtml::encode('The Best Healthy Foods'); ?> <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo TbHtml::encode('For Your Health'); ?><br> -->
            </p>
        </div>
        <div class="col-xs-6 text-right">
            <p>
                <?php echo TbHtml::b(Yii::app()->getsetSession->getLocationName() . ' Branch'); ?> <br>
                <?php echo TbHtml::b(Yii::app()->getsetSession->getLocationNameKH()); ?> <br>
                <?php echo TbHtml::encode('Tel: ' . Yii::app()->getsetSession->getLocationPhone()); ?> <br>
                <?php echo TbHtml::encode(Yii::app()->getsetSession->getLocationPhone1()); ?>  <br>
                <?php echo TbHtml::encode(Yii::app()->getsetSession->getLocationAddress()); ?>  <br>
                <?php echo TbHtml::encode(Yii::app()->getsetSession->getLocationAddress1()); ?> <br>
                <?php echo TbHtml::encode(Yii::app()->getsetSession->getLocationAddress2()); ?> <br>
            </p>
        </div>
    </div>
    <!-- / end client details section -->
    
    <div class="row">
        <div class="col-xs-6">
            <p>
                <?php echo Yii::t('app','Cashier') . " : ". TbHtml::encode(ucwords($employee_name)); ?> <br>
                <?php echo Yii::t('app','Table') . " : ". TbHtml::b(TbHtml::encode(ucwords($table_info->name) . '-' . Common::GroupAlias($group_id))); ?>  <br>
                <?php echo TbHtml::encode(Yii::t('app','Wifi Pass')  . ' ' . Yii::app()->getsetSession->getLocationWifi()); ?> <br>
            </p>
        </div>
        <div class="col-xs-6 text-right">
            <p>
                <?php echo TbHtml::encode(Yii::t('app','Invoice ID') . " : "  . Yii::app()->getsetSession->getLocationCode() . ' - ' . $sale_id); ?> <br>
                <?php echo TbHtml::encode(Yii::t('app','Date') . " : ". $transaction_date); ?> <br>
                <?php echo TbHtml::encode(Yii::t('app','Time') . " : ". $transaction_time); ?> <br>
            </p>
        </div>
    </div>

    <table class="table" id="receipt_items">
        <thead>
            <tr>
                <th style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Name'); ?></th>
                <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Price'); ?></th>
                <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo TbHtml::encode(Yii::t('app','Qty')); ?></th>
                <!--
                <th class="<?php //echo Yii::app()->settings->get('sale','discount'); ?>">
                    <?php //echo TbHtml::encode(Yii::t('app','Discount')); ?>
                </th>
                -->
                <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo TbHtml::encode(Yii::t('app','Total')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
            <?php foreach($items as $id=>$item): ?>
                <?php
                       $i=$i+1;
                       $total_item=number_format($item['total'],Yii::app()->shoppingCart->getDecimalPlace());
                       $item_id=$item['item_id'];
                ?>
                <tr>
                    <!-- <td class="center"><?php //echo TbHtml::encode($i); ?></td> -->

                    <?php if ($item['topping']==0) { ?>
                        <td><?php echo TbHtml::encode($item['name']); ?></td>
                    <?php } else { ?>
                         <td align="right"><span class="text-info"><?php echo $item['name']; ?></span></td>
                    <?php } ?>
                    <td class="center"><?php echo TbHtml::encode(number_format($item['price'],Yii::app()->shoppingCart->getDecimalPlace())); ?></td>
                    <td class="center"><?php echo TbHtml::encode($item['quantity']); ?></td>
                    <!-- <td class="<?php //echo Yii::app()->settings->get('sale','discount'); ?>"><?php //echo TbHtml::encode($item['discount']); ?></td> -->
                    <td class="text-right"><?php echo TbHtml::encode($total_item); ?>
                </tr>
            <?php endforeach; ?> <!--/endforeach-->  
            <tr class="gift_receipt_element">
                <td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo Yii::t('app','Sub Total'); ?></td>
                <td colspan="1" style='text-align:right;border-top:2px solid #000000;'> <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></td>
            </tr>
            <tr class="gift_receipt_element">
                <td colspan="3" class="text-right">Discount</td>
                <td colspan="1" class="text-right"> 
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                </td>
            </tr>
             <tr class="gift_receipt_element">
                <td colspan="3" class="text-right"><?php echo Yii::t('app','Total'); ?></td>
                <td colspan="1" class="text-right">
                    <span style="font-size:15px;">
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                    </span>
                </td>
            </tr>
            <?php foreach($payments as $payment_id=>$payment): ?> 
            <tr>
                <td colspan="3" style='text-align:right'><?php echo Yii::t('app','Paid Amount'); ?></td>
                <td colspan="1" style='text-align:right'> 
                    <span style="font-size:15px">
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($payment['payment_amount'],Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                    </span>
                 </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="3" style='text-align:right'><?php echo Yii::t('app','Change Due'); ?></td>
                <td colspan="1" style='text-align:right'> 
                    <span style="font-size:15px;">
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_due,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="return_policy" style="width:200px; margin:0 auto;">
    <div id="return_policy" align="center"><?php echo Yii::t('app',Yii::app()->settings->get('site', 'returnPolicy')); ?></div>
</div>

<script>
$(window).bind("load", function() {
    setTimeout(window.location.href='index',5000); 
    window.print();
    return true;
});    
</script>