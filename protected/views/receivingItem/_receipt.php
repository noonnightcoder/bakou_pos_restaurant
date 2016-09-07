<script>
function printpage()
{
    var mymenu = document.getElementById('menu');
    mymenu.style.display = "none";
    var myFooter= document.getElementById('footer');
    myFooter.style.display = "none";
    var mybutton = document.getElementById('mybutton');
    mybutton.style.display = "none";
    //Whatever other elements to hide.
    window.print();
    window.location.href='index';
    return true;
}
</script>
<div class="span8" style="float: none;margin-left: auto; margin-right: auto;">
    <?php
    if (isset($error_message))
    {   
        echo '<h2 style="text-align: center;">'.$error_message.'</h1>';  
    } 
    else {
    ?>
        <div id="receipt_header" style="width:200px; margin:0 auto;">
            <div id="company_name" align="center"><?php echo Yii::app()->settings->get('site', 'companyName'); ?></div>
            <div id="company_address" align="center"><?php echo Yii::app()->settings->get('site', 'companyAddress'); ?></div>
            <div id="company_phone" align="center"><?php echo Yii::app()->settings->get('site', 'companyPhone'); ?></div>
            <div id="sale_receipt" align="center"><?php echo 'Sales Receipt'; ?></div>
            <div id="sale_time" align="center"><?php echo $transaction_time ?></div>
        </div>    
        <div id="receipt_general_info">
            <?php if(isset($supplier))
            {
            ?>
                 <div id="customer"><?php echo 'Customer name : '. $supplier; ?></div>
            <?php
            }
            ?>
            <div id="sale_id"><?php echo "Receiving ID: ".  $receiving_id; ?></div>
            <div id="employee"><?php echo "Employee : ". $employee; ?></div>
        </div>
        <div class="span8">  
            <table class="table" id="receipt_items">
                <thead>
                    <tr><th>Item Name</th><th>Price</th><th style='text-align:center;'>Quantity</th><th style='text-align:center;'>Discount</th><th style='text-align:right;'>Total</th></tr>
                </thead>
                <tbody id="cart_contents">
                    <?php foreach(array_reverse($items,true) as $id=>$item): ?>
                     <?php
                            if (substr($item['discount'],0,1)=='$')
                            {
                                $total_item=($item['price']*$item['quantity']-substr($item['discount'],1));
                            }    
                            else  
                            {  
                                $total_item=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
                            } 
                      ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['price']; ?></td>
                                <td style='text-align:center;'><?php echo $item['quantity']; ?></td>
                                <td style='text-align:center;'><?php echo $item['discount'] ?></td>
                                <td style='text-align:right;'><?php echo $total_item; ?>
                            </tr>
                    <?php endforeach; ?> <!--/endforeach-->

                    <tr>
                        <td colspan="4" style='text-align:right;border-top:2px solid #000000;'><?php echo 'Sub Total' ?></td>
                        <td colspan="2" style='text-align:right;border-top:2px solid #000000;'><?php echo $sub_total; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style='text-align:right;'><?php echo 'Total'; ?></td>
                        <td colspan="2" style='text-align:right'><?php echo $total; ?></td>
                    </tr>

                    <?php foreach($payments as $payment_id=>$payment): ?> 
                        <?php //$splitpayment=explode(':',$payment['payment_type']) ?>
                        <tr>
                            <td colspan="4" style='text-align:right;'><?php echo $payment['payment_type']; ?></td>
                            <td colspan="2" style='text-align:right;'><?php echo $payment['payment_amount']; ?></td>  
                        </tr>
                    <?php endforeach;?>

                    <tr>
                        <td colspan="4" style='text-align:right;'><?php echo 'Change Due'; ?></td>
                        <td colspan="2" style='text-align:right;'><?php echo $amount_change; ?></td>  
                    </tr>    

                </tbody>

            </table>
        </div>
    
        <div id="return_policy" style="width:200px; margin:0 auto;">
            <div id="return_policy"><?php echo Yii::app()->settings->get('site', 'returnPolicy'); ?></div>
        </div> 

        <div id="mybutton">
            <?php echo TbHtml::linkButton(Yii::t( 'app', 'Print' ),array(
                'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'print white',
                'onclick'=>'{printpage();}',
            )); ?> 
            <?php echo TbHtml::linkButton(Yii::t( 'app', 'Edit' ),array(
                'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'pencil white',
                'url'=>$this->createUrl('ReceivingItem/EditReceiving',array('receiving_id'=>$receiving_id)),
            )); ?> 
        </div>
    <?php } ?>
    
</div>
    
