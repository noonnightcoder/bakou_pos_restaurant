<?php

/**
 * This is the model class for table "sale_amount".
 *
 * The followings are the available columns in table 'sale_amount':
 * @property integer $id
 * @property integer $sale_id
 * @property string $sub_total
 * @property string $tax_total
 * @property string $total
 * @property string $paid
 * @property string $balance
 *
 * The followings are the available model relations:
 * @property Sale $sale
 */
class SaleAmount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sale_amount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_id', 'required'),
			array('sale_id', 'numerical', 'integerOnly'=>true),
			array('sub_total, tax_total, total, paid, balance', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sale_id, sub_total, tax_total, total, paid, balance', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'sale_id' => 'Sale',
			'sub_total' => 'Sub Total',
			'tax_total' => 'Tax Total',
			'total' => 'Total',
			'paid' => 'Paid',
			'balance' => 'Balance',
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
		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('sub_total',$this->sub_total,true);
		$criteria->compare('tax_total',$this->tax_total,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('paid',$this->paid,true);
		$criteria->compare('balance',$this->balance,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SaleAmount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getAmountToPaid($client_id)
        {
            $sql="SELECT sum(balance) amount
                        FROM (
                        SELECT s.id sale_id,s.`sale_time`,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.`sale_id`=s.`id` AND sa.balance>0
                                        INNER JOIN `client` c ON c.`id`=s.`client_id`
                                            AND c.id=:client_id
                        ) AS t"; 

            $result=Yii::app()->db->createCommand($sql)->queryAll(true,array(':client_id'=>(int)$client_id));
             
            foreach($result as $record) {
                $amount = $record['amount'];
            }
            
            return $amount;
        }
}
