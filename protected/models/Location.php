<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $id
 * @property string $name
 * @property string $name_kh
 * @property string $loc_code
 * @property string $address
 * @property string $address1
 * @property string $address2
 * @property string $phone
 * @property string $phone1
 * @property string $wifi_password
 * @property string $email
 * @property string $printer_food
 * @property string $printer_beverage
 * @property string $printer_receipt
 * @property decimal $vat
 *
 * The followings are the available model relations:
 * @property EmployeeLocation[] $employeeLocations
 * @property Zone[] $zones
 */
class Location extends CActiveRecord
{
	public $location_archived;

    private $_active = '1';
    private $_inactive = '0';
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name, name_kh, address, address1, address2', 'length', 'max' => 200),
            array('printer_food, printer_beverage, printer_receipt', 'length', 'max' => 100),
            array('loc_code', 'length', 'max' => 10),
            array('phone, phone1', 'length', 'max' => 20),
            array('wifi_password, email', 'length', 'max' => 30),
            array('vat', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'name, name_kh, loc_code, address, address1, address2, phone, phone1, wifi_password, email, printer_food, printer_beverage, printer_receipt, vat',
                'safe',
                'on' => 'search'
            ),
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
			'employeeLocations' => array(self::HAS_MANY, 'EmployeeLocation', 'location_id'),
			'zones' => array(self::HAS_MANY, 'Zone', 'location_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('app','Name'),
            'name_kh' => Yii::t('app','Name Kh'),
            'loc_code' => Yii::t('app','Location Code'),
            'address' => Yii::t('app','Address'),
            'address1' => Yii::t('app','Address1'),
            'address2' => Yii::t('app','Address2'),
            'phone' => Yii::t('app','Phone'),
            'phone1' => Yii::t('app','Phone1'),
            'wifi_password' => Yii::t('app','Wifi Password'),
            'email' => Yii::t('app','Email'),
            'printer_food' => Yii::t('app','Food Printer Name'),
            'printer_beverage' => Yii::t('app','Beverage Printer Name'),
            'printer_receipt' => Yii::t('app','Receipt Printer Name'),
            'status' => Yii::t('app','Status'),
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

		/*$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_kh',$this->name_kh,true);
		$criteria->compare('loc_code',$this->loc_code,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('wifi_password',$this->wifi_password,true);
		$criteria->compare('email',$this->email,true);*/

        if  ( Yii::app()->user->getState('location_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'name LIKE :name OR phone LIKE :name';
            $criteria->params = array(
                ':name' => '%' . $this->name . '%',
                ':phone' => $this->name . '%'
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name LIKE :name OR phone like :name)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':name' => '%' . $this->name . '%',
                ':phone' => $this->name . '%'
            );
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('location_PageSize',Yii::app()->params['defaultPageSize']),
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function getLocationInfo()
    {
        //return $this->name . ' ( ' . $this->phone . ' , ' . $this->phone1  . ' )';
        return $this->name; //. ' ( ' . $this->phone . ' )';
    }

    public function getLocation()
    {
        $model = Location::model()->findAll();
        $list = CHtml::listData($model, 'id', 'LocationInfo');
        return $list;
    }


    public function deleteLocation($id)
    {
        $this->updateByPk((int)$id, array('status' => $this->_inactive));
    }

    public function undodeleteLocation($id)
    {
        $this->updateByPk((int)$id, array('status' => $this->_active));
    }
       
}
