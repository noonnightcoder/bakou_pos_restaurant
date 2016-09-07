<?php

/**
 * This is the model class for table "price_tier_zone".
 *
 * The followings are the available columns in table 'price_tier_zone':
 * @property integer $zone_id
 * @property integer $price_tier_id
 */
class PriceTierZone extends CActiveRecord
{
	public $zone_name;  
    
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price_tier_zone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zone_id, price_tier_id', 'required'),
			array('zone_id, price_tier_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('zone_id, price_tier_id', 'safe', 'on'=>'search'),
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
			'zone_id' => 'Zone',
			'price_tier_id' => 'Price Tier',
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

		$criteria->compare('zone_id',$this->zone_id);
		$criteria->compare('price_tier_id',$this->price_tier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PriceTierZone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
