<?php

/**
 * This is the model class for table "invoice_payment".
 *
 * The followings are the available columns in table 'invoice_payment':
 * @property integer $id
 * @property integer $invoice_id
 * @property string $invoice_number
 * @property string $date_paid
 * @property string $amount_paid
 * @property string $note
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Invoice $invoice
 */
class InvoicePayment extends CActiveRecord
{
        public $amount;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicePayment the static model class
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
		return 'invoice_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_id, amount_paid', 'required'),
			array('invoice_id', 'numerical', 'integerOnly'=>true),
			array('invoice_number', 'length', 'max'=>50),
			array('amount_paid, give_away', 'length', 'max'=>10),
                        array('give_away, amount_paid', 'type', 'type'=>'float'),
                        //array('give_away', 'match', 'pattern'=>'(/^\d*\.?\d*[0-9]+\d*$)|(^[0-9]+\d*\.\d*$)/'),
			array('date_paid, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invoice_id, invoice_number, date_paid, amount_paid, give_away, note, modified_date', 'safe', 'on'=>'search'),
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
			'invoice_number' => 'Invoice Number',
			'date_paid' => 'Date Paid',
			'amount_paid' => 'Amount Paid',
                        'give_away' => 'Give Away',
			'note' => 'Note',
			'modified_date' => 'Modified Date',
                        'amount'=>'Owe Amount',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($invoice_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('date_paid',$this->date_paid,true);
		$criteria->compare('amount_paid',$this->amount_paid,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('modified_date',$this->modified_date,true);
                
                $criteria->condition = ('invoice_id=:invoiceId');
                $criteria->params = array('invoiceId'=>$invoice_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}