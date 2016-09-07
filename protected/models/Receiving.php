<?php

/**
 * This is the model class for table "receiving".
 *
 * The followings are the available columns in table 'receiving':
 * @property integer $id
 * @property string $receive_time
 * @property integer $supplier_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Receiving extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receiving';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('receive_time', 'required'),
			array('supplier_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('sub_total', 'numerical'),
			array('payment_type', 'length', 'max'=>255),
			array('status', 'length', 'max'=>30),
                        array('receive_time','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
			array('remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, receive_time, supplier_id, employee_id, sub_total, payment_type, status, remark', 'safe', 'on'=>'search'),
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
			'items' => array(self::MANY_MANY, 'Item', 'receiving_item(receive_id, item_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'receive_time' => 'Receive Time',
			'supplier_id' => 'Supplier',
			'employee_id' => 'Employee',
			'sub_total' => 'Sub Total',
			'payment_type' => 'Payment Type',
			'status' => 'Status',
			'remark' => 'Remark',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('receive_time',$this->receive_time,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('sub_total',$this->sub_total);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Receiving the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function saveRevc($items,$payments,$supplier_id,$employee_id,$sub_total,$comment)
        {
                if(count($items)==0) {
                    return -1;
                }        
                        
                $model=new Receiving;
                $payment_types='';
                
		foreach($payments as $payment_id=>$payment)
		{
			$payment_types=$payment_types.$payment['payment_type'].': '.$payment['payment_amount'].'<br />';
		}
                
                $transaction=$model->dbConnection->beginTransaction();
                try 
                {
                        $model->supplier_id = $supplier_id;
                        $model->employee_id = $employee_id;
                        $model->payment_type = $payment_types;
                        $model->remark = $comment;
                        $model->sub_total= $sub_total;
                        $model->status=$this->transactionHeader();
                        
                        if ( $model->save() )
                        {    
                            $receiving_id=$model->id;
                            
                            // Saving payment items to sale_payment table
                            /*
                            foreach($payments as $payment)
                            {
                                $sale_payment=new SalePayment;
                                $sale_payment->sale_id=$sale_id;
                                $sale_payment->payment_type=$payment['payment_type'];
                                $sale_payment->payment_amount=$payment['payment_amount'];
                                $sale_payment->save();
                            }
                             * 
                            */
                            
                            // Saving receiving item to receiving_item table
                            foreach($items as $line=>$item)
                            {
                                $cur_item_info= Item::model()->findbyPk($item['item_id']);
                                $qty_in_stock=$cur_item_info->quantity;
                                
                                $receiving_item=new ReceivingItem;
                                
                                $discount_arr=Common::Discount($item['discount']);
                                
                                $discount_amount=$discount_arr[0];
                                $discount_type=$discount_arr[1];
                                
                                $receiving_item->receive_id=$receiving_id;
                                $receiving_item->item_id=$item['item_id'];
                                $receiving_item->line=$line;
                                $receiving_item->quantity=$item['quantity'];
                                $receiving_item->cost_price=$cur_item_info->cost_price;
                                $receiving_item->unit_price=$cur_item_info->unit_price;
                                $receiving_item->price=$item['price']; // Not used for Receiving Module
                                $receiving_item->discount_amount=$discount_amount==null ? 0 : $discount_amount;
                                $receiving_item->discount_type=$discount_type;
                                
                                $receiving_item->save();
                                
                                $stock_quantity=$this->stockQuantiy($qty_in_stock,$item['quantity']);
                                
                                //Updating stock quantity
                                $cur_item_info->quantity=$stock_quantity[0];
                                $cur_item_info->save();
                                
                                //Ramel Inventory Tracking
                                $inventory=new Inventory;
                                //$qty_recv = $item['quantity'];
                                $sale_remarks=$this->transactionHeader(). ' ' . $receiving_id;
                                $inventory->trans_items=$item['item_id'];
                                $inventory->trans_user=$employee_id;
                                $inventory->trans_comment=$sale_remarks;
                                $inventory->trans_inventory=$stock_quantity[1];
                                $inventory->trans_date=date('Y-m-d H:i:s');
                                $inventory->save();
                                
                                if (!empty ($item['expire_date']))
                                {
                                    $item_expire=ItemExpire::model()->find('item_id=:item_id and expire_date=:expire_date',array(':item_id'=>(int)$item['item_id'],':expire_date'=>$item['expire_date']));
                                    
                                    if (!$item_expire) {
                                       $item_expire=new ItemExpire;
                                       $qty_in_stock=0;
                                    } else {
                                       $qty_in_stock=$item_expire->quantity;
                                    }
                                    
                                    $stock_quantity=$this->stockQuantiy($qty_in_stock,$item['quantity']);
                                    
                                    //Update Item expiry date & quantity
                                    $item_expire->item_id=$item['item_id'];
                                    //$item_expire->receiving_id=$receiving_id;
                                    //$item_expire->employee_id=$employee_id;
                                    $item_expire->expire_date=$item['expire_date'];
                                    $item_expire->quantity=$stock_quantity[0];
                                    $item_expire->save();
                                    
                                    $item_expire_dt=new ItemExpireDt;
                                    $item_expire_dt->item_expire_id=$item_expire->id;
                                    $item_expire_dt->trans_id=$receiving_id;
                                    $item_expire_dt->trans_qty=$stock_quantity[0];
                                    $item_expire_dt->trans_comment=$sale_remarks;
                                    $item_expire_dt->modified_date=date('Y-m-d H:i:s');
                                    $item_expire_dt->employee_id=$employee_id;
                                    $item_expire_dt->save();
                                }
                            }
                            
                            $transaction->commit();  
                        } 
                 }catch (Exception $e)
                 {
                     $transaction->rollback();
                     return -1;
                     //$receiving_id=var_dump($model->getErrors());
                 } 
                 
                //return $receiving_id;
                    
        }
        
        public function deleteReceiving($receiving_id)
        {
            $model=new Receiving;
            
            $transaction=$model->dbConnection->beginTransaction();
            try 
            {
                $receiving = Receiving::model()->findbyPk($receiving_id);
                $receiving->delete(); // use constraint PK on cascade delete no need to select item & payment table
                $transaction->commit(); 
            }catch (Exception $e)
            {
                return -1;
                $transaction->rollback();
            } 
            
        }
        
        public function transactionHeader()
        {
            if (Yii::app()->receivingCart->getMode()==='receive') //+Quantity
            {
                $data['trans_header']='Receive from Supplier';
            } elseif  (Yii::app()->receivingCart->getMode()==='return') //-Quantity
            {
                $data['trans_header']='Return to Supplier';
            } elseif  (Yii::app()->receivingCart->getMode()==='adjustment_in') //+Quantity
            {
                $data['trans_header']='Adjustment In';
            } elseif  (Yii::app()->receivingCart->getMode()==='adjustment_out') // -Quantity
            {
                $data['trans_header']='Adjustment Out';
            }
            elseif  (Yii::app()->receivingCart->getMode()==='physical_count') // Physical count  
            {
                $data['trans_header']='Physical Count';
            }
            return $data['trans_header'];
        }
        
        protected function stockQuantiy($qty_in_stock,$new_quantity)
        {
            if (Yii::app()->receivingCart->getMode()==='receive')
            {
                $quantity=$qty_in_stock+$new_quantity;
                $inv_quantity=$new_quantity;
            } elseif  (Yii::app()->receivingCart->getMode()==='return') //-Quantity
            {
                $quantity=$qty_in_stock-$new_quantity;
                $inv_quantity=-$new_quantity;
            } elseif  (Yii::app()->receivingCart->getMode()==='adjustment_in') //+Quantity
            {
                $quantity=$qty_in_stock+$new_quantity;
                $inv_quantity=$new_quantity;
            } elseif  (Yii::app()->receivingCart->getMode()==='adjustment_out') // -Quantity
            {
                $quantity=$qty_in_stock-$new_quantity;
                $inv_quantity=-$new_quantity;
            } elseif  (Yii::app()->receivingCart->getMode()==='physical_count') // Input Quantity
            {
                $quantity=$new_quantity;
                $inv_quantity=$new_quantity-$qty_in_stock;
            }
            return array($quantity, $inv_quantity);
        }
}
