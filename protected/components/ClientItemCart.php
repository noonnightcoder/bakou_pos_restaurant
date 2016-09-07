<?php if ( ! defined('YII_PATH')) exit('No direct script access allowed');
class ClientItemCart extends CApplicationComponent
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
            $this->session=$value;
        } 
        
        public function getDecimalPlace()
        {
            return Yii::app()->settings->get('system', 'decimalPlace')==''?2:Yii::app()->settings->get('system','decimalPlace');
        }
        
        public function getSaleCookie()
        {
            return Yii::app()->settings->get('system', 'saleCookie')==''?"0":Yii::app()->settings->get('system','saleCookie');
        }
        
        public function getCart()
        {
            $this->setSession(Yii::app()->session);
            if (!isset($this->session['ci_cart']))
            {
                $this->setCart( array()) ;
            }
            return $this->session['ci_cart'];
        }
         
        public function setCart($cart_data)
        {
            $this->setSession(Yii::app()->session);
            $this->session['ci_cart']=$cart_data;
            //$session=Yii::app()->session;
            //$session['ci_cart']=$cart_data;
        }
        
        /*
         * To get payment session
         * $return $session['payment']
         */
        public function getPayments()
        {
            $this->setSession(Yii::app()->session);
            if (!isset($this->session['ci_payments']))
            {
                $this->setPayments(array());
            }
            return $this->session['ci_payments'];
        }
         
        public function setPayments($payments_data)
        {
            $this->setSession(Yii::app()->session);
            $this->session['ci_payments']=$payments_data;
        }
        
        public function getCustomer()
        {
            $this->setSession(Yii::app()->session);
            if (!isset($this->session['ci_customer']))
            {
                $this->setCustomer(null);
            }
            return $this->session['ci_customer'];
        }
        
        public function setCustomer($customer_data)
        {
            $this->setSession(Yii::app()->session);
            $this->session['ci_customer']=$customer_data;
        }
        
        public function removeCustomer()
        {
            $this->setSession(Yii::app()->session);
            unset($this->session['ci_customer']);
        }
        
        public function getComment() 
	{
            $this->setSession(Yii::app()->session);
            return $this->session['ci_comment'];
	}

	public function setComment($comment) 
	{
            $this->setSession(Yii::app()->session);
            $this->session['ci_comment']=$comment;
	}
        
        public function clearComment()
        {
            $this->setSession(Yii::app()->session);
            unset($this->session['ci_comment']);
        }
        
        public function addItem($item_id,$quantity=1,$discount='0',$price=null,$description=null)
        {
            $this->setSession(Yii::app()->session);
            //Get all items in the cart so far...
            $items = $this->getCart();
            
            $model=Item::model()->findbyPk($item_id);
            
            $item_data = array ( $item_id =>
                array(
                    'item_id'=>$model->id,
                    'name'=>$model->name,
                    'item_number'=>$model->item_number,
                    'quantity'=>$quantity,
                    'price'=>$price!=null ? round($price,$this->getDecimalPlace()): round($model->unit_price,$this->getDecimalPlace()),
                    'discount'=>$discount,
                    'description'=>$description!=null ? $description: $model->description,
                )
             );
            
            if ( isset( $items[$item_id] ) )
            {
                $items[$item_id]['quantity']+=$quantity;
            }
            else
            {
                $items += $item_data;
            }
            
            $this->setCart( $items );
            return true;
        }
        
        public function editItem($item_id,$quantity,$discount,$price,$description)
	{
		$items = $this->getCart();
		if( isset( $items[$item_id]) )
		{       
                    $items[$item_id]['quantity'] = $quantity;
                    $items[$item_id]['discount'] = $discount;
                    $items[$item_id]['price'] = round($price,$this->getDecimalPlace());
                    $items[$item_id]['description'] = $description;
                    $this->setCart($items);
		}

		return false;
	}
        
        public function deleteItem($item_id)
	{
		$items=$this->getCart();
                unset($items[$item_id]);
                $this->setCart($items);
	}
        
        public function outofStock($item_id)
	{
            $item = Item::model()->findbyPk($item_id);
            
            if (!$item) return false;
            
            $quanity_added = $this->getQuantityAdded($item_id);

            if ($item->quantity - $quanity_added < 0)
            {
                    return true;
            }

            return false;
	}
        
        protected function getQuantityAdded($item_id)
	{
            $items = $this->getCart();
            $quanity_already_added = 0;
            foreach ($items as $item)
            {
                    if($item['item_id']==$item_id)
                    {
                            $quanity_already_added+=$item['quantity'];
                    }
            }

            return $quanity_already_added;
	}
        
        protected function emptyCart()
	{
            $this->setSession(Yii::app()->session);
            unset($this->session['ci_cart']);
	}
        
        /*
         * To add payment to payment session $_SESSION['payment']
         * @param string $payment_id as payment type, float $payment_amount amount of payment 
         */
        public function addPayment($payment_id,$payment_amount)
        {
             $this->setSession(Yii::app()->session);
             $payments=$this->getPayments();
             $payment = array( $payment_id=>
		array(
			'payment_type' => $payment_id,
			'payment_amount' => $payment_amount
			)
             );
             
             //payment_method already exists, add to payment_amount
            if( isset( $payments[$payment_id] ) )
            {
                    $payments[$payment_id]['payment_amount'] += $payment_amount;
            }
            else
            {
                    //add to existing array
                    $payments += $payment;
            }

            $this->setPayments( $payments );
            return true;
            
        }
        
        public function deletePayment($payment_id)
        {
            $payments=$this->getPayments();
            unset($payments[$payment_id]);
            $this->setPayments( $payments );
        }
          
        protected function emptyPayment()
        {
              $this->setSession(Yii::app()->session);
              unset($this->session['ci_payments']);
        }
        
        public function getSubTotal()
	{
		$subtotal = 0;
                $items=$this->getCart();
		foreach($items as $id=>$item)
		{
		    if (substr($item['discount'],0,1)=='$')
                    {
                        $subtotal+=($item['price']*$item['quantity']-substr($item['discount'],1));
                    }    
                    else
                    {
                        $subtotal+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
                    } 
		}
		return round($subtotal,$this->getDecimalPlace());
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
            foreach($this->getCart() as $item)
            {   
                if (substr($item['discount'],0,1)=='$')
                {
                    $total+=($item['price']*$item['quantity']-substr($item['discount'],1));
                }    
                else
                {
                    $total+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
                } 
            }

            /* Have to calcuate with tax if there is a tax */
            /*
            foreach($this->getCart() as $tax)
            {
                    $total+=$tax;
            }
             * 
            */

            //return number_format((float)$total,2);
            return round($total,$this->getDecimalPlace());
	}
        
        //Alain Multiple Payments
	public function getPaymentsTotal()
	{
            $subtotal = 0;
            foreach($this->getPayments() as $payments)
            {
                $subtotal+=$payments['payment_amount'];
            }
            //return number_format((float)$subtotal,2);
            return $subtotal;
	}
        
        //Alain Multiple Payments
	public function getAmountDue()
	{
            //$amount_due=0;
            $sales_total= $this->getTotal();
            $payment_total = $this->getPaymentsTotal();
            $amount_due=$sales_total - $payment_total;
            return $amount_due;
	}
        
        //get Total Quatity
	public function getQuantityTotal()
	{
		$qtytotal = 0;
		foreach($this->getCart() as $line=>$item)
		{
		    $qtytotal+=$item['quantity'];
		}
		return $qtytotal;
	}
        
        public function copyEntireSale($sale_id)
        {
            $this->clearAll();
            $sale=Sale::model()->findbyPk($sale_id);
            $sale_item=SaleItem::model()->getSaleItem($sale_id);
            $payments= SalePayment::model()->getPayment($sale_id);
            
            foreach($sale_item as $row)
            {
                if ($row->discount_type=='$')
                {
                    $discount_amount=$row->discount_type.$row->discount_amount;
                }
                else
                {
                    $discount_amount=$row->discount_amount;
                }
                $this->addItem($row->item_id,$row->quantity,$discount_amount,$row->price,$row->description);
            }
            foreach($payments as $row)
            {
                $this->addPayment($row->payment_type,$row->payment_amount);
            }
            
            $this->setCustomer($sale->client_id);
            $this->setComment($sale->remark);
        }
        
        public function copyEntireSuspendSale($sale_id)
        {
            $this->clearAll();
            $sale=SaleSuspended::model()->findbyPk($sale_id);
            $sale_item=SaleSuspendedItem::model()->getSaleItem($sale_id);
            $payments=SaleSuspendedPayment::model()->getPayment($sale_id);
            
            foreach($sale_item as $row)
            {
                if ($row->discount_type=='$')
                {
                    $discount_amount=$row->discount_type.$row->discount_amount;
                }
                else
                {
                    $discount_amount=$row->discount_amount;
                }
                
                $this->addItem($row->item_id,$row->quantity,$discount_amount,$row->price,$row->description);
            }
            foreach($payments as $row)
            {
                $this->addPayment($row->payment_type,$row->payment_amount);
            }
            
            $this->setCustomer($sale->client_id);
            $this->setComment($sale->remark);
        }
        
        public function saleClientCookie($client_id)
        {
            //$this->clearAll();
            $sale_item=SaleClientCookie::model()->findAll('client_id=:client_id', array(':client_id'=>$client_id));
            
            if (isset($sale_item))
            {
                foreach($sale_item as $row)
                {
                    $this->addItem($row->item_id,$row->quantity,$row->discount_amount,$row->price,$row->description);
                }
            }
        }
        
        public function clearAll()
        {
            $this->emptyCart();
            $this->emptyPayment();
            $this->removeCustomer();
            $this->clearComment();
        }    
}
?>
