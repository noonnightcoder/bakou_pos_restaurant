<?php

/**
 * This is the model class for table "item_price".
 *
 * The followings are the available columns in table 'item_price':
 * @property integer $id
 * @property integer $item_id
 * @property integer $employee_id
 * @property double $old_price
 * @property double $new_price
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Item $item
 */
class ItemPrice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, employee_id, old_price, new_price', 'required'),
			array('item_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('old_price, new_price', 'numerical'),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, employee_id, old_price, new_price, modified_date', 'safe', 'on'=>'search'),
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
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
			'employee_id' => 'Employee',
			'old_price' => 'Old Price',
			'new_price' => 'New Price',
			'modified_date' => 'Modified Date',
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
	public function search($item_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('old_price',$this->old_price);
		$criteria->compare('new_price',$this->new_price);
		$criteria->compare('modified_date',$this->modified_date,true);
                
                $criteria->condition="item_id=:item_id";
                $criteria->params = array(':item_id' => $item_id);
                $criteria->order = 'modified_date desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPrice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
