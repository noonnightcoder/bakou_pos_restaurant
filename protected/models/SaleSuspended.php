<?php

/**
 * This is the model class for table "sale_suspended".
 *
 * The followings are the available columns in table 'sale_suspended':
 * @property integer $id
 * @property string $sale_time
 * @property integer $client_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property SaleSuspendedItem[] $saleSuspendedItems
 */
class SaleSuspended extends CActiveRecord
{
	public $unsuspend;
        public $delete;
        public $client_info;
        //public $client_firstname;
        //public $client_lastname;
        
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaleSuspended the static model class
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
		return 'sale_suspended';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_time', 'required'),
			array('client_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('sub_total', 'numerical'),
			array('payment_type', 'length', 'max'=>255),
			array('comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sale_time, client_id, employee_id, sub_total, payment_type, remark, client_info', 'safe', 'on'=>'search'),
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
			'saleSuspendedItems' => array(self::HAS_MANY, 'SaleSuspendedItem', 'sale_id'),
                        'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
                        'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Suspended Sale ID',
			'sale_time' => 'Sale Time',
			'client_id' => 'Client',
			'employee_id' => 'Employee',
			'sub_total' => 'Sub Total',
			'payment_type' => 'Payment Type',
			'remark' => 'Comment',
                        'unsuspend' => 'Unsuspend',
                        'client_info' => Yii::t('app','Customer Name / Tel No')
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array( 'client' );
                
		//$criteria->compare('id',$this->id);
		//$criteria->compare('sale_time',$this->sale_time,true);
                //$criteria->compare('client_id',$this->client_id);
		//$criteria->compare('employee_id',$this->employee_id);
		//$criteria->compare('sub_total',$this->sub_total);
		//$criteria->compare('payment_type',$this->payment_type,true);
		//$criteria->compare('remark',$this->remark,true);
                $criteria->compare( 'client.first_name', $this->client_info, true, 'OR' );
                $criteria->compare( 'client.last_name', $this->client_info , true, 'OR');
                $criteria->compare( 'client.mobile_no', $this->client_info, true, 'OR' );
                //$criteria->compare( 'client.last_name', $this->client_search, true );
                //$criteria->compare( 'client.mobile_no', $this->client_search, true );
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function saveSale($items,$payments,$customer_id,$employee_id,$sub_total,$comment)
        {
                if(count($items)==0)
			return -1;
                
                $model=new SaleSuspended;
                $payment_types='';
                //$error='';
                
		foreach($payments as $payment_id=>$payment)
		{
			$payment_types=$payment_types.$payment['payment_type'].': '.$payment['payment_amount'].'<br />';
		}
                
                $transaction=$model->dbConnection->beginTransaction();
                try 
                {
                        $model->sale_time = date('Y-m-d H:i:s');
                        $model->client_id = $customer_id;
                        $model->employee_id = $employee_id;
                        $model->payment_type = $payment_types;
                        $model->remark = $comment;
                        $model->sub_total= $sub_total;
                        
                        if ( $model->save() )
                        {    
                            $sale_id=$model->id;
                            
                            // Saving payment items to sale_payment table
                            foreach($payments as $payment)
                            {
                                $sale_payment=new SaleSuspendedPayment;
                                $sale_payment->sale_id=$sale_id;
                                $sale_payment->payment_type=$payment['payment_type'];
                                $sale_payment->payment_amount=$payment['payment_amount'];
                                $sale_payment->save();
                            }
                            
                            // Saving sale item to sale_item table
                            foreach($items as $line=>$item)
                            {
                                $cur_item_info= Item::model()->findbyPk($item['item_id']);
                                
                                $sale_item=new SaleSuspendedItem;
                                
                                if (substr($item['discount'],0,1)=='$')
                                {
                                    $discount_amount=substr($item['discount'],1);
                                    $discount_type='$';
                                }
                                else
                                {
                                    $discount_amount=$item['discount'];
                                    $discount_type='%';
                                }
                             
                                $sale_item->sale_id=$sale_id;
                                $sale_item->item_id=$item['item_id'];
                                $sale_item->line=$line;
                                $sale_item->quantity=$item['quantity'];
                                $sale_item->cost_price=$cur_item_info->cost_price;
                                $sale_item->unit_price=$cur_item_info->unit_price;
                                $sale_item->price=$item['price']; // The exact selling price
                                $sale_item->discount_amount=$discount_amount==null ? 0 : $discount_amount;
                                $sale_item->discount_type=$discount_type;
                                
                                if (!$sale_item->save()) 
                                {   $transaction->rollback();
                                    return -1;
                                }
                            }
                            $transaction->commit();  
                        }
                 }catch (Exception $e)
                 {
                     $transaction->rollback();
                     return -1;
                     //return $e;
                     
                 } 
                
                 return $sale_id;
                                    
        }
        
        public function deleteSale($sale_id)
        {
            $model=new SaleSuspended;
            
            $transaction=$model->dbConnection->beginTransaction();
            try 
            {
                $sale_suspend = SaleSuspended::model()->findbyPk($sale_id);
                $sale_suspend->delete(); // use constraint PK on cascade delete no need to select item & payment table
                $transaction->commit(); 
            }catch (Exception $e)
            {
                return -1;
                $transaction->rollback();
            } 
            
        }
}