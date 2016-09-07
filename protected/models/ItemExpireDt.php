<?php

/**
 * This is the model class for table "item_expire_dt".
 *
 * The followings are the available columns in table 'item_expire_dt':
 * @property integer $id
 * @property integer $item_expire_id
 * @property integer $trans_id
 * @property string $trans_qty
 * @property string $trans_comment
 * @property string $modified_date
 * @property integer $employee_id
 *
 * The followings are the available model relations:
 * @property ItemExpire $itemExpire
 */
class ItemExpireDt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_expire_dt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_expire_id, trans_id, trans_qty', 'required'),
			array('item_expire_id, trans_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('trans_qty', 'length', 'max'=>15),
			array('trans_comment', 'length', 'max'=>30),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_expire_id, trans_id, trans_qty, trans_comment, modified_date, employee_id', 'safe', 'on'=>'search'),
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
			'itemExpire' => array(self::BELONGS_TO, 'ItemExpire', 'item_expire_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_expire_id' => 'Item Expire',
			'trans_id' => 'Trans',
			'trans_qty' => 'Trans Qty',
			'trans_comment' => 'Trans Comment',
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
		$criteria->compare('item_expire_id',$this->item_expire_id);
		$criteria->compare('trans_id',$this->trans_id);
		$criteria->compare('trans_qty',$this->trans_qty,true);
		$criteria->compare('trans_comment',$this->trans_comment,true);
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
	 * @return ItemExpireDt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
