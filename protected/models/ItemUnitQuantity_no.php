<?php

/**
 * This is the model class for table "item_unit_quantity".
 *
 * The followings are the available columns in table 'item_unit_quantity':
 * @property integer $item_id
 * @property integer $unit_id
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 *
 * The followings are the available model relations:
 * @property Item $item
 * @property ItemUnit $unit
 */
class ItemUnitQuantity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_unit_quantity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, unit_id, quantity', 'required'),
			array('item_id, unit_id', 'numerical', 'integerOnly'=>true),
			array('quantity, cost_price, unit_price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('item_id, unit_id, quantity, cost_price, unit_price', 'safe', 'on'=>'search'),
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
			'unit' => array(self::BELONGS_TO, 'ItemUnit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'item_id' => 'Item',
			'unit_id' => 'Unit',
			'quantity' => 'Quantity',
			'cost_price' => 'Cost Price',
			'unit_price' => 'Unit Price',
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

		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('unit_price',$this->unit_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemUnitQuantity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
