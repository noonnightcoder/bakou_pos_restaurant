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
        font-size: 12px !important;
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
        <div class="col-md-2 col-md-offset-5">
            fkdfldaljf<br>
            dsfslfjf<br>    
        </div>
    </div>
    -->
    <div class="row">
        <div class="col-xs-6">
            <p>
                <?php //echo Yii::t('app','Cashier') . " : ". TbHtml::encode(ucwords($employee->first_name)); ?> <br>
                <?php echo Yii::t('app','Table') . " : ". TbHtml::encode(ucwords($table_info->name) . '-' . Common::GroupAlias($group_id)); ?> <br>
            </p>
        </div>
        <div class="col-xs-6 text-right">
            <p>
                <?php echo Yii::t('app','Invoice ID') . " : " . TbHtml::b(Yii::app()->getsetSession->getLocationCode() . ' - ' . $sale_id); ?> <br>
                <?php echo TbHtml::b(Yii::t('app','Date') . " : ". $transaction_date); ?> <br>
                <?php echo TbHtml::b(Yii::t('app','Time') . " : ". $transaction_time); ?> <br>
            </p>
        </div>
    </div>

    <table class="table" id="receipt_items">
        <thead>
        <tr>
            <th><?php echo Yii::t('app','Code'); ?></th>
            <th><?php echo Yii::t('app','Name'); ?></th>
            <th class="center" ><?php echo TbHtml::encode(Yii::t('app','Qty')); ?></th>
            <th class="<?php echo Yii::app()->settings->get('sale','discount'); ?>">
                <?php echo TbHtml::encode(Yii::t('app','Discount')); ?>
            </th>
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

                <td>
                    <?php echo TbHtml::b($item['item_number']); ?>
                </td>
                <?php if ($item['topping']==0) { ?>
                    <td>
                            <span style="font-size:15px;font-weight:bold">
                                <?php echo TbHtml::b($item['name']); ?>
                            </span>
                    </td>
                <?php } else { ?>
                    <td align="right">
                             <span class="text-info" style="font-size:15px;font-weight:bold">
                                <?php echo TbHtml::b($item['name']); ?>
                             </span>
                    </td>
                <?php } ?>
                <!-- <td class="center"><?php //echo TbHtml::encode(number_format($item['price'],Yii::app()->shoppingCart->getDecimalPlace())); ?></td>-->
                <td class="center"><?php echo TbHtml::b($item['quantity']); ?></td>
                <td class="<?php echo Yii::app()->settings->get('sale','discount'); ?>"><?php echo TbHtml::encode($item['discount']); ?></td>
            </tr>
        <?php endforeach; ?> <!--/endforeach-->
        </tbody>
    </table>

</div>

<script>
    $(window).bind("load", function() {
        jsPrintSetup.setPrinter('<?php echo Yii::app()->getsetSession->setLocationPrinterReceipt(); ?>');
        console.log(jsPrintSetup.getPrinter());
        jsPrintSetup.printWindow(window);
        setTimeout(window.location.href='index',1000);
        //window.print();
        return true;
    });
</script>

<!--<script>
function printpage()
{
    setTimeout(window.location.href='index',500);
    window.print();
    return true;
}
window.onload=printpage();
</script>-->