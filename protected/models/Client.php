<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property string $address1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 * @property string $status 
 *
 * The followings are the available model relations:
 * @property Invoice[] $invoices
 */
class Client extends CActiveRecord
{
        public $debter_id;
        public $balance;

        const _client_active = 1;
        const _client_inactive = 0; 
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active      record class name.
	 * @return Client the static model class
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
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobile_no, first_name,last_name','required'),
                        array('city_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>60  ),
			array('mobile_no', 'length', 'max'=>15),
			array('address1, address2', 'length', 'max'=>60),
			array('country_code', 'length', 'max'=>2),
			array('email', 'length', 'max'=>30),
			array('notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name,last_name, mobile_no, address1, address2, city_id, country_code, email, notes, debter_id', 'safe', 'on'=>'search'),
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
			'invoices' => array(self::HAS_MANY, 'Invoice', 'client_id'),
                        'account'=>array(self::HAS_ONE, 'Account', 'client_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => Yii::t('model','model.client.first_name'),
                        'last_name' => Yii::t('model','model.client.last_name'),
			'mobile_no' => Yii::t('model','model.client.mobile'),
			'address1' => Yii::t('model','model.client.address1'),
			'address2' => Yii::t('model','model.client.address2'),
			'city_id' => Yii::t('model','model.client.city'),
			'country_code' => Yii::t('model','model.client.countrycode'),
			'email' => Yii::t('model','model.client.email'),
			'notes' => Yii::t('model','model.client.notes'),
                        'debter_id' => 'Debt Collector',
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

		//$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		//$criteria->compare('city_id',$this->city_id);
		//$criteria->compare('country_code',$this->country_code,true);
		//$criteria->compare('email',$this->email,true);
		//$criteria->compare('notes',$this->notes,true);
                $criteria->condition="status=:status";
                $criteria->params = array(':status' => $this::_client_active);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         /*
         * Look up subordinate(s)
         */
        public static function getClient($name = '') {

            // Recommended: Secure Way to Write SQL in Yii 
            $sql = 'SELECT id ,concat_ws(" : ",concat_ws("  ",first_name,last_name),mobile_no) AS text 
                    FROM client 
                    WHERE (first_name LIKE :name or last_name like :name or mobile_no like :name)
                    AND status=:active_status';
            
            $name = '%' . $name . '%';
            return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name,':active_status'=>'1'));
       
        }
        
        protected function getCustomerInfo()
        {
            return $this->first_name . ' - ' . $this->last_name;
        }
        
        public function getCustomer()
        {
            $model = Client::model()->findAll();
            $list  = CHtml::listData($model , 'id', 'CustomerInfo');
            return $list;
        }
        
        public function removeCustomer($cust_id)
        {
            Client::model()->updateByPk((int)$cust_id,array('status'=>$this::_client_inactive));
        }
}