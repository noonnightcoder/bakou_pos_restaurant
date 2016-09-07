<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class OrderingCart extends CApplicationComponent
{

    //private $quantity;

    private $session;
    private $active_status=1;

    //private $decimal_place;

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($value)
    {
        $this->session = $value;
    }

    public function getDecimalPlace()
    {
        return Yii::app()->settings->get('system', 'decimalPlace') == '' ? 2 : Yii::app()->settings->get('system', 'decimalPlace');
    }

    public function getCart()
    {
        //$cart=array();
        $cart = SaleOrder::model()->getOrderCart($this->getSaleId(), Yii::app()->getsetSession->getLocationId());

        $this->settingSaleSum();

        return $cart;
    }

    public function setCart($cart_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['cart'] = $cart_data;
    }
    
    /*
     * To get payment session
     * $return $session['payment']
     */
    public function getPayments()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['payments'])) {
            $this->setPayments(array());
        }
        return $this->session['payments'];
    }

    public function setPayments($payments_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['payments'] = $payments_data;
    }

    public function getCustomer()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['customer'])) {
            $this->setCustomer(null);
        }
        return $this->session['customer'];
    }

    public function setCustomer($customer_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['customer'] = $customer_data;
    }

    public function removeCustomer()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['customer']);
    }

    public function getEmployee()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['employee'])) {
            $this->setEmployee(null);
        }
        return $this->session['employee'];
    }

    public function setEmployee($employee_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['employee'] = $employee_data;
    }

    public function removeEmployee()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['employee']);
    }
    
    public function getSaleTime()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['saletime'])) {
            $this->setEmployee(date('d/m/Y h:i:s a'));
        }
        return $this->session['saletime'];
    }

    public function setSaleTime($saletime_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['saletime'] = $saletime_data;
    }

    public function clearSaleTime()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['saletime']);
    }

    
    public function getPriceTier()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['pricetier'])) {
            $this->setPriceTier(null);
        }
        return $this->session['pricetier'];
    }

    public function setPriceTier($pricetier_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['pricetier'] = $pricetier_data;
    }

    public function clearPriceTier()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['pricetier']);
    }

    public function getComment()
    {
        $this->setSession(Yii::app()->session);
        return $this->session['comment'];
    }

    public function setComment($comment)
    {
        $this->setSession(Yii::app()->session);
        $this->session['comment'] = $comment;
    }

    public function clearComment()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['comment']);
    }
    
    public function getGDiscount()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['gdiscount'])) {
            $this->setGDiscount(null);
        }
        return $this->session['gdiscount'];
    }

    public function setGDiscount($gdiscount)
    {
        $this->setSession(Yii::app()->session);
        $this->session['gdiscount'] = $gdiscount;
    }

    public function clearGDiscount()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['gdiscount']);
    }
    
    public function getDisGiftcard()
    {
       return SaleOrder::model()->getDisGiftcard($this->getTableId(), $this->getGroupId(),Yii::app()->getsetSession->getLocationId());
    }

    public function setDisGiftcard($giftcard_id)
    {
        return SaleOrder::model()->setDisGiftcard($this->getSaleId(),Yii::app()->getsetSession->getLocationId(),$giftcard_id);
    }

    public function clearDisGiftcard()
    {
        return SaleOrder::model()->clearDisGiftcard($this->getSaleId(),Yii::app()->getsetSession->getLocationId());
    }
    
    public function getZoneId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['zoneid'])) {
            $this->setZoneId(-1);
        }
        return $this->session['zoneid'];
    }
    
    public function setZoneId($zoneid_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['zoneid'] = $zoneid_data;
        
        $this->setPriceByZone($zoneid_data);
    }

    public function clearZoneId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['zoneid']);
    }
    
    public function getGroupId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['groupid'])) {
            $this->setGroupId(1);
        }
        return $this->session['groupid'];
    }
    
    public function setGroupId($groupid_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['groupid'] = $groupid_data;
    }

    public function clearGroupId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['groupid']);
    }
    
    public function getTableId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['tableid'])) {
            $this->setTableId(null);
        }
        return $this->session['tableid'];
    }

    public function setTableId($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['tableid'] = $data;
        
        $desk=Desk::model()->findByPk($data);
        
        if ($desk) {
            $this->setPriceByZone($desk->zone_id);
        }
    }

    public function clearTableId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['tableid']);
    }

    public function getSaleId()
    {
        $sale_order = SaleOrder::model()->find('desk_id=:desk_id and group_id=:group_id and location_id=:location_id and status=:status',
            array(
                ':desk_id' => $this->getTableId(),
                ':group_id' => $this->getGroupId(),
                ':location_id' => Yii::app()->getsetSession->getLocationId(),
                ':status' => $this->active_status
            ));

        return isset($sale_order) ? $sale_order->id : null;
    }

    public function setSaleId($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['saleid'] = $data;
    }

    public function clearSaleId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['saleid']);
    }
    
    public function getSaleQty()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['saleqty'])) {
            $this->setSaleQty(0);
        }
        return $this->session['saleqty'];
    }

    public function setSaleQty($saleqty_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['saleqty'] = $saleqty_data;
      
    }

    public function clearSaleQty()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['saleqty']);
    }
    
    public function getSaleSubTotal()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['salesubtotal'])) {
            $this->setSaleSubTotal(0);
        }
        return $this->session['salesubtotal'];
    }

    public function setSaleSubTotal($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['salesubtotal'] = $data;
      
    }

    public function clearSaleSubTotal()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['salesubtotal']);
    }
    
    public function getSaleDiscount()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['salediscount'])) {
            $this->setSaleDiscount(0);
        }
        return $this->session['salediscount'];
    }

    public function setSaleDiscount($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['salediscount'] = $data;
      
    }

    public function clearSaleDiscount()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['salediscount']);
    }
    
    public function getSaleTotal()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['saletotal'])) {
            $this->setSaleTotal(0);
        }
        return $this->session['saletotal'];
    }

    public function setSaleTotal($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['saletotal'] = $data;
      
    }

    public function clearSaleTotal()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['saletotal']);
    }
    
    public function settingSaleSum()
    {
        $all_total = SaleOrder::model()->getAllTotal($this->getSaleId(),Yii::app()->getsetSession->getLocationId());
        
        $this->setSaleQty($all_total[0]);
        $this->setSaleSubTotal($all_total[1]);
        $this->setSaleTotal($all_total[2]);
        $this->setSaleDiscount($all_total[3]);
    }

    public function addItem($item_id, $quantity = 1, $item_parent_id = 0)
    {
        return SaleOrder::model()->saveOrderingItem($item_id, $this->getTableId(), $this->getGroupId(), $this->getCustomer(), Yii::app()->session['employeeid'], $quantity, $this->getPriceTier(), $item_parent_id, Yii::app()->getsetSession->getLocationId());
    }
    
    public function f5ItemPriceTier()
    {
        $this->setSession(Yii::app()->session);
        //Get all items in the cart so far...
        $items = $this->getCart();
        
        foreach ($items as $item) {
            $models = Item::model()->getItemPriceTier($item['item_id'], $this->getPriceTier());
            foreach ($models as $model) {
               if (isset($items[$item['item_id']])) {
                    $items[$item['item_id']]['price'] = round($model['unit_price'], $this->getDecimalPlace());
               }
            }
        }    
        
        $this->setCart($items);
        return true;
    }

    public function editItem($item_id, $quantity, $discount, $price, $item_parent_id,$location_id)
    {
        SaleOrder::model()->editOrderMenu($this->getSaleId(),$item_id, $quantity, $price, $discount, $item_parent_id,Yii::app()->getsetSession->getLocationId());
    }

    public function deleteItem($item_id,$item_parent_id)
    {
        SaleOrder::model()->delOrderItem($item_id,$item_parent_id,$this->getTableId(),$this->getGroupId(),Yii::app()->getsetSession->getLocationId());
    }

    public function outofStock($item_id)
    {
        $item = Item::model()->findbyPk($item_id);

        if (!$item)
            return false;

        $quanity_added = $this->getQuantityAdded($item_id);

        if ($item->quantity - $quanity_added < 0) {
            return true;
        }

        return false;
    }

    protected function getQuantityAdded($item_id)
    {
        $items = $this->getCart();
        $quanity_already_added = 0;
        foreach ($items as $item) {
            if ($item['item_id'] == $item_id) {
                $quanity_already_added+=$item['quantity'];
            }
        }

        return $quanity_already_added;
    }

    protected function emptyCart()
    {
        SaleOrder::model()->cancelOrderMenu($this->getTableId(), $this->getGroupId(),Yii::app()->getsetSession->getLocationId());
    }

    /*
     * To add payment to payment session $_SESSION['payment']
     * @param string $payment_id as payment type, float $payment_amount amount of payment 
     */
    public function addPayment($payment_id, $payment_amount)
    {
        $this->setSession(Yii::app()->session);
        $payments = $this->getPayments();
        $payment = array($payment_id =>
            array(
                'payment_type' => $payment_id,
                'payment_amount' => $payment_amount
            )
        );

        //payment_method already exists, add to payment_amount
        if (isset($payments[$payment_id])) {
            $payments[$payment_id]['payment_amount'] += $payment_amount;
        } else {
            //add to existing array
            $payments += $payment;
        }

        $this->setPayments($payments);
        return true;
    }

    public function deletePayment($payment_id)
    {
        $payments = $this->getPayments();
        unset($payments[$payment_id]);
        $this->setPayments($payments);
    }

    protected function emptyPayment()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['payments']);
    }

    public function getSubTotal()
    {
        $subtotal = SaleOrder::model()->getOrderSubTotal($this->getTableId(), $this->getGroupId(),Yii::app()->getsetSession->getLocationId());
         
        return round($subtotal, $this->getDecimalPlace());
    }

    /**
     * Returns total price for all units of the position
     * @param bool $withDiscount
     * @return float
     *
     */
    public function getTotal()
    {
        $total = SaleOrder::model()->getOrderTotal($this->getTableId(), $this->getGroupId(),Yii::app()->getsetSession->getLocationId());
   
        return round($total, $this->getDecimalPlace());
    }
    
    public function getDiscount()
    {
        $total = SaleOrder::model()->getOrderDiscount($this->getTableId(), $this->getGroupId(),Yii::app()->getsetSession->getLocationId());
       
        return round($total, $this->getDecimalPlace());
    }

    //Alain Multiple Payments
    public function getPaymentsTotal()
    {
        $subtotal = 0;
        foreach ($this->getPayments() as $payments) {
            $subtotal+=$payments['payment_amount'];
        }
        //return number_format((float)$subtotal,2);
        return $subtotal;
    }

    //Alain Multiple Payments
    public function getAmountDue()
    {
        //$amount_due=0;
        $sales_total = $this->getTotal();
        $payment_total = $this->getPaymentsTotal();
        $amount_due = $sales_total - $payment_total;
        return $amount_due;
    }

    //get Total Quatity
    public function getQuantityTotal()
    {
        return SaleOrder::model()->getOrderTotalQty($this->getTableId(), $this->getGroupId(),Yii::app()->getsetSession->getLocationId());
    }

    public function copyEntireSale($sale_id)
    {
        $this->clearAll();
        $sale = Sale::model()->findbyPk($sale_id);
        $sale_item = SaleItem::model()->getSaleItem($sale_id);
        $payments = SalePayment::model()->getPayment($sale_id);

        foreach ($sale_item as $row) {
            if ($row->discount_type == '$') {
                $discount_amount = $row->discount_type . $row->discount_amount;
            } else {
                $discount_amount = $row->discount_amount;
            }
            $this->addItem($row->item_id, $row->quantity, $discount_amount, $row->price, $row->description);
        }
        foreach ($payments as $row) {
            $this->addPayment($row->payment_type, $row->payment_amount);
        }

        $this->setCustomer($sale->client_id);
        $this->setComment($sale->remark);
        $this->setSaleId($sale_id);
        $this->setEmployee($sale->employee_id);
        $this->setSaleTime($sale->sale_time);
        $this->setGDiscount($sale->discount_amount);
        
    }

    public function copyEntireSuspendSale($sale_id)
    {
        $this->clearAll();
        $sale = Sale::model()->findbyPk($sale_id);
        $sale_item = SaleItem::model()->getSaleItem($sale_id);
        $payments = SalePayment::model()->getPayment($sale_id);
        $sale_table = SaleTable::model()->getSaleTable($sale_id);

        foreach ($sale_item as $row) {
            if ($row->discount_type == '$') {
                $discount_amount = $row->discount_type . $row->discount_amount;
            } else {
                $discount_amount = $row->discount_amount;
            }

            $this->addItem($row->item_id, $row->quantity, $discount_amount, $row->price, $row->description);
        }

        foreach ($payments as $row) {
            $this->addPayment($row->payment_type, $row->payment_amount);
        }

        $this->setCustomer($sale->client_id);
        $this->setComment($sale->remark);
        $this->setGDiscount($sale->discount_amount);
        $this->setSaleId($sale_id);
        $this->setZoneId($sale_table->zone_id);
        $this->setTableId($sale_table->table_id);
    }

    public function saleClientCookie($client_id)
    {
        //$this->clearAll();
        $sale_item = SaleClientCookie::model()->findAll('client_id=:client_id', array(':client_id' => $client_id));

        if (isset($sale_item)) {
            foreach ($sale_item as $row) {
                $this->addItem($row->item_id, $row->quantity, $row->discount_amount, $row->price, $row->description);
            }
        }
    }

    public function clearAll()
    {
        //$this->emptyCart();
        $this->emptyPayment();
        //$this->removeCustomer();
        //$this->clearComment();
        //$this->clearSaleId();
        //$this->clearSaleTime();
        //$this->removeEmployee();
        $this->clearPriceTier();
        $this->clearGDiscount();
        //$this->clearZoneId();
        $this->clearTableId();
        $this->clearGroupId();
    }
    
    public function clearOrderCart() 
    {
        //$this->emptyCart();
        $this->emptyPayment();
        $this->removeCustomer();
        $this->clearComment();
        $this->clearSaleId();
        $this->clearSaleTime();
        $this->clearPriceTier();
        $this->clearGDiscount();
    }
    
    public function changeTable($new_table_id)
    {
       return SaleOrder::model()->changeTable($this->getTableId(),$new_table_id,$this->getGroupId(),Yii::app()->getsetSession->getLocationId(),$this->getPriceTier(),Yii::app()->session['employeeid']);
    }
    
    protected function setPriceByZone($zone_id)
    {
        $model = PriceTierZone::model()->find('zone_id=:zone_id',array(":zone_id"=>$zone_id));
        if (isset($model)) {
            $this->setPriceTier($model->price_tier_id);
        } else {
            $this->setPriceTier(Null);
        }
    }

}

?>
