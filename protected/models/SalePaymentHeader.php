<?php

/**
 * This is the model class for table "sale_payment_header".
 *
 * The followings are the available columns in table 'sale_payment_header':
 * @property integer $id
 * @property string $amount
 * @property integer $employee_id
 * @property string $date_paid
 *
 * The followings are the available model relations:
 * @property SalePayment[] $salePayments
 * @property Employee $employee
 */
class SalePaymentHeader extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sale_payment_header';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount', 'required'),
			array('employee_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>15),
			array('date_paid', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, amount, employee_id, date_paid', 'safe', 'on'=>'search'),
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
			'salePayments' => array(self::HAS_MANY, 'SalePayment', 'payment_header_id'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'employee_id' => 'Employee',
			'date_paid' => 'Date Paid',
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
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('date_paid',$this->date_paid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalePaymentHeader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
