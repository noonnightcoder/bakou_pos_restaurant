<?php

/**
 * This is the model class for table "exchange_rate".
 *
 * The followings are the available columns in table 'exchange_rate':
 * @property string $base_currency
 * @property string $to_currency
 * @property double $base_cur_val
 * @property double $to_cur_val
 */
class ExchangeRate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exchange_rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('base_currency, to_currency, base_cur_val, to_cur_val', 'required'),
			array('base_cur_val, to_cur_val', 'numerical'),
			array('base_currency, to_currency', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('base_currency, to_currency, base_cur_val, to_cur_val', 'safe', 'on'=>'search'),
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
			'base_currency' => 'Base Currency',
			'to_currency' => 'To Currency',
			'base_cur_val' => 'Base Cur Val',
			'to_cur_val' => 'To Cur Val',
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

		$criteria->compare('base_currency',$this->base_currency,true);
		$criteria->compare('to_currency',$this->to_currency,true);
		$criteria->compare('base_cur_val',$this->base_cur_val);
		$criteria->compare('to_cur_val',$this->to_cur_val);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExchangeRate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
