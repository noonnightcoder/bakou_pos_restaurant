<?php

/**
 * This is the model class for table "item_price_promo_dt".
 *
 * The followings are the available columns in table 'item_price_promo_dt':
 * @property integer $id
 * @property integer $item_price_promo_id
 * @property integer $item_id
 * @property double $unit_price
 * @property string $start_date
 * @property string $end_date
 * @property string $modified_date
 * @property integer $employee_id
 */
class ItemPricePromoDt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_price_promo_dt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_price_promo_id, item_id, unit_price, start_date, end_date', 'required'),
			array('item_price_promo_id, item_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'numerical'),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_price_promo_id, item_id, unit_price, start_date, end_date, modified_date, employee_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'item_price_promo_id' => 'Item Price Promo',
			'item_id' => 'Item',
			'unit_price' => 'Unit Price',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'modified_date' => 'Modified Date',
			'employee_id' => 'Employee',
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
		$criteria->compare('item_price_promo_id',$this->item_price_promo_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('employee_id',$this->employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPricePromoDt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
