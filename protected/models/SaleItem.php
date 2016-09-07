<?php

/**
 * This is the model class for table "sale_item".
 *
 * The followings are the available columns in table 'sale_item':
 * @property integer $id
 * @property integer $sale_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property integer $discount_type
 *
 * The followings are the available model relations:
 * @property Item $item
 * @property Sale $sale
 */
class SaleItem extends CActiveRecord
{
        public $client_id;
        public $payment_type;
        public $comment;
        public $payment_amount;
        public $name;
        public $discount;
        public $sub_total;
        public $total_discount;
        public $tier_id;
        public $gdiscount;
        public $group;
        public $giftcard_id;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaleItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sale_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('sale_id, item_id, unit_price, quantity', 'required'),
                        //array('quantity', 'required'),
			array('sale_id, item_id, line', 'numerical', 'integerOnly'=>true),
			array('quantity, cost_price, unit_price, price, discount_amount', 'numerical'),
			array('description, discount_type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sale_id, item_id, description, line, quantity, cost_price, unit_price, price, discount_amount, discount_type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
			'sale' => array(self::BELONGS_TO, 'Sale', 'sale_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'sale_id' => Yii::t('app', 'Sale'), //'Sale',
            'item_id' => Yii::t('app', 'Item'), //'Item',
            'description' => Yii::t('app', 'Description'), //'Description',
            'line' => Yii::t('app', 'Line'), //'Line',
            'quantity' => Yii::t('app', 'Quantity'), //'Quantity',
            'cost_price' => Yii::t('app', 'Buy price'), //'Cost Price',
            'unit_price' => Yii::t('app', 'Sale Price'), // 'Unit Price',
            'price' => Yii::t('app', 'Price'), //'Price',
            'discount_amount' => Yii::t('app', 'Discount Amount'), // 'Discount Amount',
            'discount_type' => Yii::t('app', 'Discount Type'),//'Discount Type',
            'name' => Yii::t('model', 'Name'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'group' => Yii::t('app','Group')
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sale_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sale_id',$this->sale_id);
		//$criteria->compare('item_id',$this->item_id);
		//$criteria->compare('description',$this->description,true);
		//$criteria->compare('line',$this->line);
		//$criteria->compare('quantity',$this->quantity);
		//$criteria->compare('cost_price',$this->cost_price);
		//$criteria->compare('unit_price',$this->unit_price);
		//$criteria->compare('price',$this->price);
		//$criteria->compare('discount_amount',$this->discount_amount);
		//$criteria->compare('discount_type',$this->discount_type);
                
        $criteria->condition="sale_id=:sale_id";
        $criteria->params = array(':sale_id' => $sale_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getSaleItem($sale_id)
        {
            $model = SaleItem::model()->findAll('sale_id=:saleId',array(':saleId'=>$sale_id));
            return $model;
        }        
        
        public function get_cart()
	{
                if (!Yii::app()->session['cart'])    
			$this->set_cart(array());
                
		return Yii::app()->session['cart'];
	}

	public function set_cart($cart_data)
	{
            Yii::app()->session['cart']=$card_data;
	}
              
        public function dataArray($items=array())
        {
            
          $dataProvider = new CArrayDataProvider(
                        $items, array(
                        'sort'=>array(
                          'attributes'=>array('name', 'id', 'quantity'),
                          //'defaultOrder'=>array('active' => true, 'name' => false),
                        ),
                        'pagination'=>array(
                          'pageSize'=>100,
                          ),        
            ));
          
            return $dataProvider;

        }
        
        /*
         * To get payment session
         * $return $session['payment']
         */
        public function getPaymentCart()
        {
            $session=Yii::app()->session;
            if (!isset($session['payment']))
            {
                $this->setPaymentCart(array());
            }
            return $session['payment'];
        }
        
        /*
         * To set/update paymenet session
         */
        public function setPaymentCart($items)
        {
            $session=Yii::app()->session;
            $session['payment']=$items;
        }
        
        /*
         * To add payment to payment session $_SESSION['payment']
         * @param string $payment_id as payment type, float $payment_amount amount of payment 
         */
        public function addPaymentToCart($payment_id,$payment_amount)
        {
             $session=Yii::app()->session;
             $arr_session=array();
             
             if(isset($session['payment']))
             {
                 $arr_session=$session['payment'];
                 if(array_key_exists($payment_id, $session['payment']))
                 {
                     $arr_session=$session['payment'];
                     $arr_session[$payment_id]['payment_amount']=$payment_amount;
                     $session['payment']=$arr_session;
                 }
                 else
                 {
                     $arr_session=$session['payment'];
                     $arr_session[$payment_id]=array('payment_id'=>$payment_id,'payment_amount'=>$payment_amount);
                     $session['payment']=$arr_session;
                 }
             }
             else
             {
                 $session['payment']=array($payment_id=>array('payment_id'=>$payment_id,'payment_amount'=>$payment_amount));
                 $arr_session=$session['payment'];
                 $session['payment']=$arr_session;
             }
        }
         
        //Alain Multiple Payments
        public function getAmountDue()
        {
                $amount_due=0;
                $payment_total = $this->get_payments_total();
                $sales_total=$this->get_total();
                $amount_due=to_currency_no_money($sales_total - $payment_total);
                return $amount_due;
        }
        
        
        
             
          
}