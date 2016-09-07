<?php

/**
 * This is the model class for table "debt_collector".
 *
 * The followings are the available columns in table 'debt_collector':
 * @property integer $id
 * @property string $fullname
 * @property string $mobile_no
 * @property string $adddress1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 */
class DebtCollector extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DebtCollector the static model class
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
		return 'debt_collector';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fullname', 'required'),
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('fullname', 'length', 'max'=>100),
			array('mobile_no', 'length', 'max'=>15),
			array('adddress1, address2', 'length', 'max'=>60),
			array('country_code', 'length', 'max'=>2),
			array('email', 'length', 'max'=>30),
			array('notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fullname, mobile_no, adddress1, address2, city_id, country_code, email, notes', 'safe', 'on'=>'search'),
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
			'fullname' => 'Fullname',
			'mobile_no' => 'Mobile No',
			'adddress1' => 'Adddress1',
			'address2' => 'Address2',
			'city_id' => 'City',
			'country_code' => 'Country Code',
			'email' => 'Email',
			'notes' => 'Notes',
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
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('adddress1',$this->adddress1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function getConcateDebtorInfo()
        {
            return $this->fullname . '-' . $this->mobile_no;
        }
        
        public function getDebterInfo()
        {
            $debter = DebtCollector::model()->findAll();
            $list    = CHtml::listData($debter , 'id', 'ConcateDebtorInfo');
            return $list;
        }
}