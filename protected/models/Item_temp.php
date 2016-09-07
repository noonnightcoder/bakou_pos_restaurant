<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $id
 * @property string $name
 * @property string $item_number
 * @property integer $category_id
 * @property integer $supplier_id
 * @property double $cost_price
 * @property double $unit_price
 * @property double $quantity
 * @property double $reorder_level
 * @property string $location
 * @property integer $allow_alt_description
 * @property integer $is_serialized
 * @property string $description
 * @property integer $deleted
 * @property string $created_date
 * @property string $modified_date
 * @property integer $topping
 *
 * The followings are the available model relations:
 * @property ItemPricePromo[] $itemPricePromos
 */
class Item extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, quantity', 'required'),
			array('category_id, supplier_id, allow_alt_description, is_serialized, deleted, topping', 'numerical', 'integerOnly'=>true),
			array('cost_price, unit_price, quantity, reorder_level', 'numerical'),
			array('name', 'length', 'max'=>50),
			array('item_number', 'length', 'max'=>255),
			array('location', 'length', 'max'=>20),
			array('description, created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, item_number, category_id, supplier_id, cost_price, unit_price, quantity, reorder_level, location, allow_alt_description, is_serialized, description, deleted, created_date, modified_date, topping', 'safe', 'on'=>'search'),
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
			'itemPricePromos' => array(self::HAS_MANY, 'ItemPricePromo', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'item_number' => 'Item Number',
			'category_id' => 'Category',
			'supplier_id' => 'Supplier',
			'cost_price' => 'Cost Price',
			'unit_price' => 'Unit Price',
			'quantity' => 'Quantity',
			'reorder_level' => 'Reorder Level',
			'location' => 'Location',
			'allow_alt_description' => 'Allow Alt Description',
			'is_serialized' => 'Is Serialized',
			'description' => 'Description',
			'deleted' => 'Deleted',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
			'topping' => 'Topping',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('item_number',$this->item_number,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('reorder_level',$this->reorder_level);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('allow_alt_description',$this->allow_alt_description);
		$criteria->compare('is_serialized',$this->is_serialized);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('topping',$this->topping);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Item the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
