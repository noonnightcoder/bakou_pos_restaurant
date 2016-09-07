<?php

/**
 * This is the model class for table "invoice_item".
 *
 * The followings are the available columns in table 'invoice_item':
 * @property integer $id
 * @property integer $invoice_id
 * @property string $amount
 * @property integer $quantity
 * @property string $work_description
 * @property string $discount
 * @property string $discount_desc
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Invoice $invoice
 */
class InvoiceItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoiceItem the static model class
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
		return 'invoice_item';
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
			array('invoice_id, quantity', 'numerical', 'integerOnly'=>true),
			array('amount, discount', 'length', 'max'=>10),
                        array('amount', 'type', 'type'=>'float'),
			array('discount_desc', 'length', 'max'=>400),
			array('work_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invoice_id, amount, quantity, work_description, discount, discount_desc, modified_date', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'Invoice', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_id' => 'Invoice',
			'amount' => 'Amount',
			'quantity' => 'Quantity',
			'work_description' => 'Work Description',
			'discount' => 'Discount',
			'discount_desc' => 'Discount Desc',
			'modified_date' => 'Modified Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('work_description',$this->work_description,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('discount_desc',$this->discount_desc,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function itemAlias($type,$code=NULL) {
		
            $_items = array(
                     'payment_type' => array(
                             'Cash' => Yii::t('app','form.paymenttype.cash'),
                             'Debt'=> Yii::t('app','form.paymenttype.debt'),
                     ),
             );

             if (isset($code))
                     return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
             else
                     return isset($_items[$type]) ? $_items[$type] : false;
	}
}