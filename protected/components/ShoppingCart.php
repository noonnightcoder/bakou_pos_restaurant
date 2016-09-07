<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class ShoppingCart extends CApplicationComponent
{

    //private $quantity;

    private $session;

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

    public function getSaleCookie()
    {
        return Yii::app()->settings->get('system', 'saleCookie') == '' ? "0" : Yii::app()->settings->get('system', 'saleCookie');
    }

    public function getCart()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['cart'])) {
            $this->setCart(array());
        }
        return $this->session['cart'];
    }

    public function setCart($cart_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['cart'] = $cart_data;
        //$session=Yii::app()->session;
        //$session['cart']=$cart_data;
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
            $this->setSaleTime(date('d/m/Y h:i:s a'));
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

    public function getSaleId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['saleid'])) {
            $this->setSaleId(null);
        }
        return $this->session['saleid'];
    }

    public function setSaleId($saleid_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['saleid'] = $saleid_data;
    }

    public function clearSaleId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['saleid']);
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
    
    public function getZoneId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['zoneid'])) {
            $this->setZoneId(null);
        }
        return $this->session['zoneid'];
    }

    public function setZoneId($zoneid_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['zoneid'] = $zoneid_data;
    }

    public function clearZoneId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['zoneid']);
    }
    
    public function getTableId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['tableid'])) {
            $this->setTableId(null);
        }
        return $this->session['tableid'];
    }

    public function setTableId($tableid_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['tableid'] = $tableid_data;
    }

    public function clearTableId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['tableid']);
    }
    
    public function addItem($item_id, $quantity = 1, $discount = '0', $price = null, $description = null)
    {
        $this->setSession(Yii::app()->session);
        //Get all items in the cart so far...
        $items = $this->getCart();

        $models = Item::model()->getItemPriceTier($item_id, $this->getPriceTier());

        foreach ($models as $model) {
        
            $item_data = array($item_id =>
                array(
                    'item_id' => $model["id"],
                    'name' => $model["name"],
                    'item_number' => $model["item_number"],
                    'quantity' => $quantity,
                    'price' => round($model["unit_price"], $this->getDecimalPlace()),
                    //'price' => $price != null ? round($price, $this->getDecimalPlace()) : round($model["unit_price"], $this->getDecimalPlace()),
                    'discount' => $discount,
                    'description' => $description != null ? $description : $model["description"],
                )
            );
        }

        if (isset($items[$item_id])) {
            $items[$item_id]['quantity']+=$quantity;
        } else {
            $items += $item_data;
        }

        $this->setCart($items);
        
        return true;
    }
    
    public function addMenu($item_id,$table_id, $zone_id, $employee_id, $client_id, $quantity = 1, $price=null) 
    {
        Sale::model()->saveOrderMenu($table_id,$client_id,$zone_id,$employee_id,$item_id,$quantity,$price);
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

    public function editItem($item_id, $quantity, $discount, $price, $description)
    {
        $items = $this->getCart();
        if (isset($items[$item_id])) {
            $items[$item_id]['quantity'] = $quantity;
            $items[$item_id]['discount'] = $discount;
            $items[$item_id]['price'] = round($price, $this->getDecimalPlace());
            $items[$item_id]['description'] = $description;
            $this->setCart($items);
        }

        return false;
    }

    public function deleteItem($item_id)
    {
        $items = $this->getCart();
        unset($items[$item_id]);
        $this->setCart($items);
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
        $this->setSession(Yii::app()->session);
        unset($this->session['cart']);
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
        $subtotal = 0;
        $items = $this->getCart();
        foreach ($items as $id => $item) {
            if (substr($item['discount'], 0, 1) == '$') {
                $subtotal+=round($item['price'] * $item['quantity'] - substr($item['discount'], 1), Yii::app()->shoppingCart->getDecimalPlace(), PHP_ROUND_HALF_DOWN);
            } else {
                $subtotal+=round($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100, Yii::app()->shoppingCart->getDecimalPlace(), PHP_ROUND_HALF_DOWN);
            }
        }
        
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
        $total = 0;
        foreach ($this->getCart() as $item) {
            if (substr($item['discount'], 0, 1) == '$') {
                $total+=round($item['price'] * $item['quantity'] - substr($item['discount'], 1), Yii::app()->shoppingCart->getDecimalPlace(), PHP_ROUND_HALF_DOWN);
            } else {
                $total+=round($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100, Yii::app()->shoppingCart->getDecimalPlace(), PHP_ROUND_HALF_DOWN);
            }
        }
         
        $total=$total - $total*$this->getGDiscount()/100;

        //return number_format((float)$total,2);
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
        $qtytotal = 0;
        foreach ($this->getCart() as $line => $item) {
            $qtytotal+=$item['quantity'];
        }
        return $qtytotal;
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
        $this->emptyCart();
        $this->emptyPayment();
        $this->removeCustomer();
        $this->clearComment();
        $this->clearSaleId();
        $this->clearSaleTime();
        $this->removeEmployee();
        $this->clearPriceTier();
        $this->clearGDiscount();
        $this->clearZoneId();
        $this->clearTableId();
   
    }
    
    public function clearSaleCart() 
    {
        $this->emptyCart();
        $this->emptyPayment();
        $this->removeCustomer();
        $this->clearComment();
        $this->clearSaleId();
        $this->clearSaleTime();
        $this->clearPriceTier();
        $this->clearGDiscount();
    }

}

?>
