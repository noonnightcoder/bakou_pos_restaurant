<div class="span8" style="float: none;margin-left: auto; margin-right: auto;">
    <?php
    if (isset($error_message))
    {   
        echo '<h2 style="text-align: center;">'.$error_message.'</h1>';  
    } 
    else {
    ?>
        <div id="receipt_header" style="width:200px; margin:0 auto;">
            <div id="copmany_logo" align="center"><?php echo TbHtml::image(Yii::app()->baseUrl . '/images/memoire-coffee.png','Company\'s logo',array('width'=>'110')); ?></div>
            <div id="company_name" align="center"><?php echo TbHtml::b(Yii::app()->settings->get('site', 'companyName')); ?></b></div>
            <div id="company_address" align="center"><?php echo TbHtml::b(Yii::app()->settings->get('site', 'companyAddress')); ?></div>
            <div id="company_phone" align="center"><b><?php echo TbHtml::b(Yii::app()->settings->get('site', 'companyPhone')); ?></b></div>
            <div id="sale_receipt" align="center"><?php echo TbHtml::b('Sales Receipt'); ?></div>
            <div id="sale_time" align="center"><?php echo TbHtml::b($transaction_time); ?></div>
        </div>    
        <div id="receipt_general_info">
            <?php if(isset($customer))
            {
            ?>  
                 <div id="customer"><?php echo Yii::t('app','Customer Name') . " : ". TbHtml::b(ucwords($customer)); ?></div>
            <?php
            }
            ?>
            <div id="sale_id"><?php echo TbHtml::b(Yii::t('app','Invoice ID') . " : " . $sale_id); ?></div>
            <div id="employee"><?php echo TbHtml::b(Yii::t('app','Seller') . " : ". $employee_name); ?></div>
        </div>
        <div class="span8 grid-view">  
            <table class="table" id="receipt_items">
                <thead>
                    <tr><th><?php echo Yii::t('app','Name'); ?></th>
                        <th><?php echo Yii::t('app','Price'); ?></th>
                        <th style='text-align:center;'><?php echo TbHtml::b(Yii::t('app','Quantity')); ?></th>
                        <th style='text-align:center;'><?php echo TbHtml::b(Yii::t('app','Discount')); ?></th>
                        <th style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','Total')); ?></th>
                    </tr>
                </thead>
                <tbody id="cart_contents">
                    <?php foreach(array_reverse($items,true) as $id=>$item): ?>
                     <?php
                            if (substr($item['discount'],0,1)=='$')
                            {
                                $total_item=number_format($item['price']*$item['quantity']-substr($item['discount'],1),Yii::app()->shoppingCart->getDecimalPlace());
                                $discount_symbol='$';
                            }    
                            else  
                            {  
                                $total_item=number_format($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100,Yii::app()->shoppingCart->getDecimalPlace());
                                 $discount_symbol='%';
                            } 
                      ?>
                            <tr>
                                <td><?php echo TbHtml::b($item['name']); ?></td>
                                <td><?php echo TbHtml::b(number_format($item['price'],Yii::app()->shoppingCart->getDecimalPlace())); ?></td>
                                <td style='text-align:center;'><?php echo TbHtml::b($item['quantity']); ?></td>
                                <td style='text-align:center;'><?php echo TbHtml::b($item['discount'] . $discount_symbol); ?></td>
                                <td style='text-align:right;'><?php echo TbHtml::b($total_item); ?>
                            </tr>
                    <?php endforeach; ?> <!--/endforeach-->

                    <tr>
                        <td colspan="4" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','Total')); ?></td>
                        <td colspan="2" style='text-align:right'><?php echo Yii::app()->numberFormatter->formatCurrency(($total),Yii::app()->settings->get('site', 'currencySymbol')); ?></td>
                    </tr>
                    
                     <tr>
                        <td colspan="4" style='text-align:right;'><?php echo Yii::t('app','Total in KHR'); ?></td>
                        <td colspan="2" style='text-align:right'><?php echo Yii::app()->numberFormatter->formatCurrency(($total_khr), 'R'); ?></td>
                    </tr>

                    <?php foreach($payments as $payment_id=>$payment): ?> 
                        <?php //$splitpayment=explode(':',$payment['payment_type']) ?>
                        <tr>
                            <td colspan="4" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app',$payment['payment_type'] . ' Receive')); ?></td>
                            <td colspan="2" style='text-align:right;'><?php echo TbHtml::b(Yii::app()->numberFormatter->formatCurrency($payment['payment_amount'],'USD')); ?></td>  
                        </tr>
                    <?php endforeach;?>

                    <tr>
                        <td colspan="4" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','Change Due')); ?></td>
                        <td colspan="2" style='text-align:right;'><?php echo TbHtml::b(Yii::app()->numberFormatter->formatCurrency($amount_change,'USD')); ?></td>  
                    </tr>    

                </tbody>

            </table>
        </div>
    
        <div id="return_policy" style="width:200px; margin:0 auto;">
            <div id="return_policy" align="center"><?php echo TbHtml::b(Yii::t('app',Yii::app()->settings->get('site', 'returnPolicy'))); ?></div>
        </div> 

        <div id="mybutton">
            <?php /* echo TbHtml::linkButton(Yii::t( 'app', 'Print' ),array(
                'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'print white',
                //'url'=>Yii::app()->createUrl('SaleItem/Index'),
                'onclick'=>'{printpage();}',
            )); */?> 
            <?php /*echo TbHtml::linkButton(Yii::t( 'app', 'Edit' ),array(
                'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'pencil white',
                'url'=>$this->createUrl('SaleItem/EditSale',array('sale_id'=>$sale_id)),
            )); */?> 
        </div>
    <?php } ?>
    
</div>

<script>
function printpage()
{
    //var mymenu = document.getElementById('menu');
    //var mynavsearch = document.getElementById('nav-search');
    //var mysidebar = document.getElementById('sidebar');
    //mymenu.style.display = "none";
    //mysidebar.style.display="none";
    //mynavsearch.style.display="none";
    //var myFooter= document.getElementById('footer');
    //myFooter.style.display = "none";
    //var mybutton = document.getElementById('mybutton');
    //mybutton.style.display = "none";
    //Whatever other elements to hide.
    setTimeout(window.location.href='index',500);
    window.print();
    return true;
}
window.onload=printpage();
</script>
