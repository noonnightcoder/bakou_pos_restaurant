<?php

/**
 * This is the model class for table "item_price_tier".
 *
 * The followings are the available columns in table 'item_price_tier':
 * @property integer $id
 * @property integer $item_id
 * @property integer $price_tier_id
 * @property double $price
 *
 * The followings are the available model relations:
 * @property PriceTier $priceTier
 * @property Item $item
 */
class ItemPriceTier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_price_tier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, price_tier_id', 'required'),
			array('item_id, price_tier_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, price_tier_id, price', 'safe', 'on'=>'search'),
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
			'priceTier' => array(self::BELONGS_TO, 'PriceTier', 'price_tier_id'),
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'price_tier_id' => 'Price Tier',
			'price' => 'Price',
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
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('price_tier_id',$this->price_tier_id);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPriceTier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function deleteItemPriceTier($item_id)
        {
            $sql="delete from item_price_tier where item_id=:item_id";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":item_id", $item_id, PDO::PARAM_INT);
            $command->execute();
        }
        
}
