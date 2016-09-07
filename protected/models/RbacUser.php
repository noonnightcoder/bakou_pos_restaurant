<?php

/**
 * This is the model class for table "rbac_user".
 *
 * The followings are the available columns in table 'rbac_user':
 * @property integer $id
 * @property string $user_name
 * @property integer $group_id
 * @property integer $employee_id
 * @property string $user_password
 * @property integer $deleted
 * @property integer $status
 * @property string $date_entered
 * @property string $modified_date
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property RbacGroup $group
 */
class RbacUser extends CActiveRecord
{
	// holds the password confirmation word
        public $PasswordConfirm;
        public $PasswordOld;
        
        //will hold the encrypted password for update actions.
        public $Password;
        public $ResetPassword;
        
        public $customers;
        public $items;
        public $sales;
        public $employees;
        public $store;
        public $suppliers;
        public $receivings;
        public $reports;
        public $payments;
        public $zones;
        public $branches;
        public $giftcards;
        public $pricetiers;
        public $invoices;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RbacUser the static model class
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
		return 'rbac_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_name', 'required'),
            array('Password', 'required', 'on' => 'insert'),
            array('user_name', 'unique'),
            array('PasswordConfirm', 'compare', 'compareAttribute' => 'Password'),
            //'message'=>"Passwords don't match"),
            array('group_id, employee_id, deleted, status, created_by', 'numerical', 'integerOnly' => true),
            array('user_name', 'length', 'max' => 60),
            array('user_password', 'length', 'max' => 128),
            array('date_entered, modified_date, PasswordOld, Password, ResetPassword', 'safe'),
            array(
                'date_entered',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => 'insert'
            ),
            array(
                'modified_date',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => 'insert'
            ),
            array(
                'modified_date',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => 'update'
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, user_name, group_id, employee_id, user_password, deleted,PasswordOld, ResetPassword, status, date_entered, modified_date, created_by',
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
			'group' => array(self::BELONGS_TO, 'RbacGroup', 'group_id'),
                        //'categories' => array(self::MANY_MANY, 'Category', 'post_category(post_id, category_id)','index'=>'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_name' => Yii::t('model','model.rbacuser.user_name'),
			'group_id' => 'Group',
			'employee_id' => 'Employee',
			'user_password' => 'User Password',
			'deleted' => 'Deleted',
			'status' => 'User Status',
			'date_entered' => 'Date Entered',
			'modified_date' => 'Modified Date',
			'created_by' => 'Created By',
                        'PasswordConfirm'=> Yii::t('model','model.rbacuser.PasswordConfirm'),
                        'Password'=> Yii::t('model','model.rbacuser.Password'),
                        'PasswordOld'=>Yii::t('model','model.rbacuser.PasswordOld'),
                        'items'=>Yii::t('app','Items'),
                        'sales'=>Yii::t('app','Sales'),
                        'employees'=>Yii::t('app','Employees'),
                        'customers'=>Yii::t('app','Customers'),
                        'suppliers'=>Yii::t('app','Suppliers'),
                        'store'=>Yii::t('app','Store'),
                        'receivings'=>Yii::t('app','Receivings'),
                        'reports'=>Yii::t('app','Reports'),
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
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('user_password',$this->user_password,true);
		//$criteria->compare('deleted',$this->deleted);
		$criteria->compare('status',$this->status);
		//$criteria->compare('date_entered',$this->date_entered,true);
		//$criteria->compare('modified_date',$this->modified_date,true);
		//$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function beforeSave()
        {
            $ph=new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
            
            //add the password hash if it's a new record
            if ($this->getIsNewRecord())
            {
                //creates the password hash from the plaintext password
                $this->user_password = $ph->hashPassword($this->Password);                         
            }       
            else if (!empty($this->Password) && !empty($this->PasswordConfirm) && ($this->Password===$this->PasswordConfirm) ) 
            //if it's not a new password, save the password only if it not empty and the two passwords match
            {
                $this->user_password = $ph->hashPassword($this->Password);
            }
            
            //$this->items = implode(', ', $this->items);
            
            return parent::beforeSave();
        }
        
}