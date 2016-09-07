<?php

/**
 * This is the model class for table "sale_client_cookie".
 *
 * The followings are the available columns in table 'sale_client_cookie':
 * @property integer $client_id
 * @property integer $item_id
 * @property string $description
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property string $discount_amount
 * @property string $discount_type
 */
class SaleClientCookie extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sale_client_cookie';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, item_id, quantity', 'required'),
			array('client_id, item_id', 'numerical', 'integerOnly'=>true),
			array('quantity, cost_price, unit_price, price', 'numerical'),
			array('discount_amount', 'length', 'max'=>15),
			array('discount_type', 'length', 'max'=>2),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('client_id, item_id, description, quantity, cost_price, unit_price, price, discount_amount, discount_type', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'client_id' => 'Client',
			'item_id' => 'Item',
			'description' => 'Description',
			'quantity' => 'Quantity',
			'cost_price' => 'Cost Price',
			'unit_price' => 'Unit Price',
			'price' => 'Price',
			'discount_amount' => 'Discount Amount',
			'discount_type' => 'Discount Type',
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

		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount_amount',$this->discount_amount,true);
		$criteria->compare('discount_type',$this->discount_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SaleClientCookie the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
