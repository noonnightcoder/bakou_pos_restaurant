<?php

/**
 * This is the model class for table "user_log".
 *
 * The followings are the available columns in table 'user_log':
 * @property string $unique_id
 * @property string $sessoin_id
 * @property integer $user_id
 * @property integer $employee_id
 * @property string $login_time
 * @property string $logout_time
 * @property string $last_action
 * @property integer $status
 * @property string $modified_date
 * @property string $modified_by
 */
class UserLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unique_id, sessoin_id, login_time', 'required'),
			array('user_id, employee_id, status', 'numerical', 'integerOnly'=>true),
			array('unique_id', 'length', 'max'=>15),
			array('sessoin_id', 'length', 'max'=>50),
			array('modified_by', 'length', 'max'=>30),
                        array('modified_date', 'default','value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
                        array('modified_date', 'default','value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' =>'update'),
			array('last_action, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('unique_id, sessoin_id, user_id, employee_id, login_time, logout_time, last_action, status, modified_date, modified_by', 'safe', 'on'=>'search'),
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
			'unique_id' => 'Unique',
			'sessoin_id' => 'Sessoin',
			'user_id' => 'User',
			'employee_id' => 'Employee',
			'login_time' => 'Login Time',
			'logout_time' => 'Logout Time',
			'last_action' => 'Last Action',
			'status' => 'Status',
			'modified_date' => 'Modified Date',
			'modified_by' => 'Modified By',
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
	public function search($employee_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('unique_id',$this->unique_id,true);
		//$criteria->compare('sessoin_id',$this->sessoin_id,true);
		//$criteria->compare('user_id',$this->user_id);
		//$criteria->compare('employee_id',$this->employee_id);
		//$criteria->compare('login_time',$this->login_time,true);
		//$criteria->compare('logout_time',$this->logout_time,true);
		//$criteria->compare('last_action',$this->last_action,true);
		//$criteria->compare('status',$this->status);
		//$criteria->compare('modified_date',$this->modified_date,true);
		//$criteria->compare('modified_by',$this->modified_by,true);
                
                $criteria->condition = 'employee_id=:employee_id and date(login_time)=CURDATE()';
                $criteria->params = array(':employee_id'=>$employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function saveUserLog($unique_id,$session_id,$user_id,$employee_id,$username,$login_time=null,$logout_time=null)
        {
            $model = new UserLog;
            $model->unique_id = $unique_id;
            $model->sessoin_id = $session_id;
            $model->user_id = $user_id;
            $model->employee_id = $employee_id;
            $model->login_time = $login_time;
            $model->logout_time = $logout_time;
            $model->modified_by = $username;
            $model->save();
        }
        
        public function saveUserLogout($unique_id,$logout_time)
        {
            $model = $this->findByPk($unique_id);
            
            if ($model) {
                $model->logout_time = $logout_time;
                $model->status=0;
                $model->save();
            }
        }
}
