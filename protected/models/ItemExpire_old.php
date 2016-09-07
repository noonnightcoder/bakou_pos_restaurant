<?php

/**
 * This is the model class for table "item_expire".
 *
 * The followings are the available columns in table 'item_expire':
 * @property integer $id
 * @property integer $item_id
 * @property integer $receiving_id
 * @property string $mfd_date
 * @property string $expire_date
 * @property string $modified_date
 * @property integer $employee_id
 * @property string $quantity
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Item $item
 * @property Receiving $receiving
 */
class ItemExpire extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_expire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, receiving_id, expire_date', 'required'),
			array('item_id, receiving_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('quantity', 'length', 'max'=>15),
			array('mfd_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, receiving_id, mfd_date, expire_date, modified_date, employee_id, quantity', 'safe', 'on'=>'search'),
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
			'receiving' => array(self::BELONGS_TO, 'Receiving', 'receiving_id'),
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
			'receiving_id' => 'Receiving',
			'mfd_date' => 'Mfd Date',
			'expire_date' => 'Expire Date',
			'modified_date' => 'Modified Date',
			'employee_id' => 'Employee',
			'quantity' => 'Quantity',
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
		$criteria->compare('receiving_id',$this->receiving_id);
		$criteria->compare('mfd_date',$this->mfd_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('quantity',$this->quantity,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemExpire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function getItemExpDateInfo()
        {
            return $this->expire_date;
        }
        
        public function getItemExpDate($item_id)
        {
            $model = ItemExpire::model()->findAll('item_id=:item_id and quantity>0 order by expire_date',array(':item_id'=>(int)$item_id));
            $list = CHtml::listData($model , 'expire_date', 'ItemExpDateInfo');
            return $list;
        }
        
}
