<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $id
 * @property string $company_name
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property string $address1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Supplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Supplier the static model class
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
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, first_name, last_name', 'required'),
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>60),
			array('first_name, last_name, email', 'length', 'max'=>30),
			array('mobile_no', 'length', 'max'=>20),
			array('address1, address2', 'length', 'max'=>50),
			array('country_code', 'length', 'max'=>3),
			array('notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_name, first_name, last_name, mobile_no, address1, address2, city_id, country_code, email, notes', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_name' => Yii::t('model','model.supplier.company_name'), //'Company Name',
			'first_name' => Yii::t('model','model.supplier.first_name'), //'First Name',
			'last_name' => Yii::t('model','model.supplier.last_name'), //'Last Name',
			'mobile_no' =>  Yii::t('model','model.supplier.mobile_no'), //'Mobile No',
			'address1' => Yii::t('model','model.supplier.address1'), //'Address1',
			'address2' => Yii::t('model','model.supplier.address2'), //'Address2',
			'city_id' => Yii::t('model','model.supplier.city_id'), //'City',
			'country_code' => Yii::t('model','model.supplier.country_code'), //'Country Code',
			'email' => Yii::t('model','model.supplier.email'), //'Email',
			'notes' => Yii::t('model','model.supplier.notes') //'Notes',
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('notes',$this->notes,true);
                
                $criteria->order = 'company_name';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function getSupplierInfo()
        {
            return $this->company_name.' - ' .$this->first_name . ' ' . $this->last_name;
        }
        
        public function getSupplier()
        {
            $supplier = Supplier::model()->findAll();
            $list    = CHtml::listData($supplier , 'id', 'SupplierInfo');
            return $list;
        }
        
        public static function select2Supplier($name = '') {

            // Recommended: Secure Way to Write SQL in Yii 
            $sql = 'SELECT id ,concat_ws(" : ",company_name,mobile_no) AS text 
                    FROM supplier 
                    WHERE (company_name LIKE :name or mobile_no like :name)';
            $name = '%' . $name . '%';
            return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));
       
        }
}