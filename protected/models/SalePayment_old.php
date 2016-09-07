<?php

/**
 * This is the model class for table "sale_payment".
 *
 * The followings are the available columns in table 'sale_payment':
 * @property integer $sale_id
 * @property string $payment_type
 * @property double $payment_amount
 *
 * The followings are the available model relations:
 * @property Sale $sale
 */
class SalePayment extends CActiveRecord
{
	public $from_date;
        public $to_date;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SalePayment the static model class
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
		return 'sale_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_id, payment_type, payment_amount', 'required'),
			array('sale_id', 'numerical', 'integerOnly'=>true),
			array('payment_amount', 'numerical'),
			array('payment_type', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sale_id, payment_type, payment_amount', 'safe', 'on'=>'search'),
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
			'sale' => array(self::BELONGS_TO, 'Sale', 'sale_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sale_id' => 'Sale',
			'payment_type' => 'Payment Type',
			'payment_amount' => 'Payment Amount',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sale_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('payment_amount',$this->payment_amount);
                 $criteria->condition="sale_id=:sale_id";
                $criteria->params = array(':sale_id' => $sale_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}