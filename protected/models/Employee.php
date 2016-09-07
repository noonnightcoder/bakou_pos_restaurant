<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property string $adddress1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 * @property string $status
 *
 * The followings are the available model relations:
 * @property RbacUser[] $rbacUsers
 * @property Transactions[] $transactions
 */
class Employee extends CActiveRecord
{

    public $login_id;
    public $image;
    public $location_id;
    public $search;
    public $day; //Day : DD
    public $month; // Month : MM
    public $year; // Year - YYYY
    public $employee_archived;

        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name', 'required'),
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>50),
			array('mobile_no', 'length', 'max'=>15),
			array('adddress1, address2', 'length', 'max'=>60),
			array('country_code', 'length', 'max'=>2),
			array('email', 'length', 'max'=>30),
			array('status', 'length', 'max'=>1),
            array('dob ', 'date', 'format'=>array('yyyy-MM-dd'), 'allowEmpty'=>true),
            array('notes, dob, day, month, year', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('first_name, last_name, mobile_no, adddress1, address2, city_id, country_code, email, notes, status', 'safe', 'on'=>'search'),
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
			'rbacUsers' => array(self::HAS_MANY, 'RbacUser', 'employee_id'),
			'transactions' => array(self::HAS_MANY, 'Transactions', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => Yii::t('app', 'First Name'), //'First Name',
            'last_name' => Yii::t('app', 'Last Name'), //'Last Name',
            'mobile_no' => Yii::t('app', 'Mobile No'), //'Mobile No',
            'adddress1' => Yii::t('app', 'Address1'), //'Adddress1',
            'address2' => Yii::t('app', 'Address2'), //Address2',
            'city_id' => Yii::t('app', 'City'), //'City',
            'country_code' => Yii::t('app', 'Country Code'), //'Country Code',
            'email' => Yii::t('app', 'Email'), //'Email',
            'notes' => Yii::t('app', 'Notes'), //'Notes',
            'search' => Yii::t('app', 'Search') . Yii::t('app', 'Employee'),
            'dob' => Yii::t('app','Date of Birth'),
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

        $criteria = new CDbCriteria;

        if  ( Yii::app()->user->getState('employee_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = '(first_name=:search or last_name=:search or concat(first_name,last_name) like :search or concat(last_name,first_name) like :search or mobile_no like :search)';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status and (first_name=:search or last_name=:search or concat(first_name,last_name) like :search or concat(last_name,first_name) like :search or mobile_no like :search) ';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('employee_pageSize',Yii::app()->params['defaultPageSize']),
            ),
            //'sort'=>array( 'defaultOrder'=>'first_name'),
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Employee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function deleteEmployee($id)
    {
        Employee::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status']));
        $user = RbacUser::model()->find('employee_id=:employee_id' , array(':employee_id' => $id));
        $user->status = Yii::app()->params['inactive_status'];
        $user->save();
    }

    public function undodeleteEmployee($id)
    {
        Employee::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status']));
        $user = RbacUser::model()->find('employee_id=:employee_id' , array(':employee_id' => $id));
        $user->status = Yii::app()->params['active_status'];
        $user->save();
    }

    protected function afterFind()
    {
        $dob = strtotime($this->dob);

        $this->day = date('d',$dob);
        $this->month = date('m',$dob);
        $this->year = date('Y',$dob);
        return parent::afterFind();
    }

    public static function itemAlias($type, $code = null)
    {

        $_items = array(
            'day' => array(
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20',
                '21' => '21',
                '22' => '22',
                '23' => '23',
                '24' => '24',
                '25' => '25',
                '26' => '26',
                '27' => '27',
                '28' => '28',
                '29' => '29',
                '30' => '30',
                '31' => '31',
            ),
            'month' => array(
                '01' => Yii::t('app','January'),
                '02' => Yii::t('app','February'),
                '03' => Yii::t('app','March'),
                '04' => Yii::t('app','April'),
                '05' => Yii::t('app','May'),
                '06' => Yii::t('app','June'),
                '07' => Yii::t('app','July'),
                '08' => Yii::t('app','August'),
                '09' => Yii::t('app','September'),
                '10' => Yii::t('app','October'),
                '11' => Yii::t('app','November'),
                '12' => Yii::t('app','December'),
            ),
            'year' => array_combine(range(date("Y"), 1910), range(date("Y"), 1910)),  //http://stackoverflow.com/questions/2807394/php-years-array
        );

        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else {
            return isset($_items[$type]) ? $_items[$type] : false;
        }
    }

    public static function employeeByID($id)
    {
        $model = Employee::model()->findByPk($id);

        return isset($model) ? $model : null;
    }
        
}
