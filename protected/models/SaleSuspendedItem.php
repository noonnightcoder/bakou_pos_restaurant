<?php

/**
 * This is the model class for table "sale_suspended_item".
 *
 * The followings are the available columns in table 'sale_suspended_item':
 * @property integer $sale_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property integer $discount_percent
 *
 * The followings are the available model relations:
 * @property Item $item
 * @property SaleSuspended $sale
 */
class SaleSuspendedItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaleSuspendedItem the static model class
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
		return 'sale_suspended_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_id, item_id', 'required'),
			array('sale_id, item_id, line', 'numerical', 'integerOnly'=>true),
			array('quantity, cost_price, unit_price, price, discount_amount', 'numerical'),
			array('description', 'safe'),
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
			'sale' => array(self::BELONGS_TO, 'SaleSuspended', 'sale_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sale_id' => 'Sale',
			'item_id' => 'Item',
			'description' => 'Description',
			'line' => 'Line',
			'quantity' => 'Quantity',
			'cost_price' => 'Cost Price',
			'unit_price' => 'Unit Price',
			'price' => 'Price',
			'discount_amount' => 'Discount Amount',
			'discount_type' => 'Discount Tyoe',
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

		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('line',$this->line);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount_amount',$this->discount_amount);
		$criteria->compare('discount_type',$this->discount_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getSaleItem($sale_id)
        {
            $model = SaleSuspendedItem::model()->findAll('sale_id=:saleId',array(':saleId'=>$sale_id));
            return $model;
        } 
}