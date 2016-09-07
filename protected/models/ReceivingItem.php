<?php

/**
 * This is the model class for table "receiving_item".
 *
 * The followings are the available columns in table 'receiving_item':
 * @property integer $receive_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property string $discount_type
 */
class ReceivingItem extends CActiveRecord
{
	public $supplier_id;
        public $payment_type;
        public $comment;
        public $payment_amount;
        public $name;
        public $discount;
        public $sub_total;
    
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receiving_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receive_id, item_id', 'required'),
			array('receive_id, item_id, line', 'numerical', 'integerOnly'=>true),
			array('quantity, cost_price, unit_price, price, discount_amount', 'numerical'),
			array('discount_type', 'length', 'max'=>2),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('receive_id, item_id, description, line, quantity, cost_price, unit_price, price, discount_amount, discount_type', 'safe', 'on'=>'search'),
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
                    'receiving' => array(self::BELONGS_TO, 'Receiving', 'receiving_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		/*
                return array(
			'receive_id' => 'Receive',
			'item_id' => 'Item',
			'description' => 'Description',
			'line' => 'Line',
			'quantity' => 'Quantity',
			'cost_price' => 'Cost Price',
			'unit_price' => 'Unit Price',
			'price' => 'Price',
			'discount_amount' => 'Discount Amount',
			'discount_type' => 'Discount Type',
		);
                */
                return array(
			'receive_id' => Yii::t('model','model.receivingitem.receive_id'), //'Sale',
			'item_id' => Yii::t('model','model.receivingitem.item_id'), //'Item',
			'description' => Yii::t('model','model.receivingitem.description'), //'Description',
			'line' => Yii::t('model','model.receivingitem.line'), //'Line',
			'quantity' => Yii::t('model','model.receivingitem.quantity'), //'Quantity',
			'cost_price' => Yii::t('model','model.receivingitem.cost_price'), //'Cost Price',
			'unit_price' => Yii::t('model','model.receivingitem.unit_price'), // 'Unit Price',
			'price' => Yii::t('model','model.receivingitem.price'), //'Price',
			'discount_amount' => Yii::t('model','model.receivingitem.discount_amount'), // 'Discount Amount',
			'discount_type' => Yii::t('model','model.receivingitem.discount_type'),//'Discount Type',
                        'name' => Yii::t('model','model.receivingitem.name'),
                        'payment_type' => Yii::t('model','model.receivingitem.paymentype'),
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
	public function search($receive_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('receive_id',$this->receive_id);
		$criteria->compare('item_id',$this->item_id);
		//$criteria->compare('description',$this->description,true);
		//$criteria->compare('line',$this->line);
		//$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('unit_price',$this->unit_price);
		//$criteria->compare('price',$this->price);
		//$criteria->compare('discount_amount',$this->discount_amount);
		//$criteria->compare('discount_type',$this->discount_type,true);
                
                $criteria->condition="receive_id=:receive_id";
                $criteria->params = array(':receive_id' => $receive_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReceivingItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getReceivingItem($receiving_id)
        {
            $model = ReceivingItem::model()->findAll('receive_id=:receivingId',array(':receivingId'=>$receiving_id));
            return $model;
        } 
}
