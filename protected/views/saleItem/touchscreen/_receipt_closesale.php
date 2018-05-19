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
    <div class="row">
        <div class="col-xs-12">
            <p>
                <?php echo Yii::t('app','Date') . " : ". TbHtml::encode($transaction_date); ?>  - &nbsp;
                <?php echo Yii::t('app','Cashier') . " : ". TbHtml::b(ucwords($employee)); ?>
            </p>
        </div>
    </div>

    <table class="table" id="receipt_items">
        <thead>
            <tr>
                <th style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Name'); ?></th>
                <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo TbHtml::encode(Yii::t('app','Qty')); ?></th>
                <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo TbHtml::encode(Yii::t('app','Price')); ?></th> 
                <th class="text-right" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo TbHtml::encode(Yii::t('app','Total')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
            <?php foreach($items as $id=>$item): ?>
                <?php
                       $i=$i+1;
                ?>
                <tr>
                    
                    <?php if ($item['total_flag'] == 1) { ?>
                         <td class='center'><?php echo TbHtml::b($item['name']); ?></td>   
                        <td class="center">
                            <?php echo TbHtml::b($item['quantity']); ?>
                        </td>
                        <td class="center"></td>
                        <td class="text-right">
                            <?php echo TbHtml::b(number_format($item['total'],Yii::app()->shoppingCart->getDecimalPlace())); ?>
                        </td>
                    <?php } else { ?>
                        <td><?php echo TbHtml::encode($item['name']); ?></td>   
                        <td class="center">
                            <?php echo TbHtml::encode($item['quantity']); ?></td>
                        <td class="center">
                              <?php echo number_format($item['price'],Yii::app()->shoppingCart->getDecimalPlace()); ?>
                        </td>
                        <td class="text-right">
                            <?php echo number_format($item['total'],Yii::app()->shoppingCart->getDecimalPlace()); ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php endforeach; ?> <!--/endforeach-->  
            <tr class="gift_receipt_element">
                <td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo TbHtml::b(Yii::t('app','Dis. on Invoice')); ?></td>
                <td colspan="1" style='text-align:right;border-top:2px solid #000000;'> 
                    <span style="font-size:15px;font-weight:bold">
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($totals[2],Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                    </span>
                </td>
            </tr> 
            <tr class="gift_receipt_element">
                <td colspan="3" style='text-align:right'><?php echo TbHtml::b(Yii::t('app','Total')); ?></td>
                <td colspan="1" style='text-align:right'> 
                    <span style="font-size:15px;font-weight:bold">
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($totals[1],Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                    </span>
                </td>
            </tr> 
        </tbody>
    </table>
</div>

<script>
$(window).bind("load", function() {
    //setTimeout(window.location.href='index',5000); 
    window.print();
    window.close();
    return true;
});    
</script>