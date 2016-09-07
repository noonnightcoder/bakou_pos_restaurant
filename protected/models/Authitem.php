<?php

/**
 * This is the model class for table "authitem".
 *
 * The followings are the available columns in table 'authitem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Authassignment[] $authassignments
 * @property Authitemchild[] $authitemchildren
 * @property Authitemchild[] $authitemchildren1
 */
class Authitem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Authitem the static model class
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
		return 'AuthItem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description, bizrule, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
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
			'authassignments' => array(self::HAS_MANY, 'Authassignment', 'itemname'),
			'authitemchildren' => array(self::HAS_MANY, 'Authitemchild', 'parent'),
			'authitemchildren1' => array(self::HAS_MANY, 'Authitemchild', 'child'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Name',
			'type' => 'Type',
			'description' => 'Description',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function getAuthItemName()
        {
            return '<span class="lbl">'. Yii::t('app',$this->description) . '</span>'; //Adding this to support ACE style need to revamp if YiiStrap Checbox support attribure class
        }
        
        public function getAuthItemClient($match='client')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match",         // no quotes around :match
                'params'    => array(':match' => "$match%"),
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemItem($match='item')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemSale($match='sale')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemReceiving($match='transaction')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",  // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemReport($match='report')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemEmployee($match='employee')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemStore($match='store')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%")  // Aha! Wildcards go here
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
            
        public function getAuthItemZone($match='zone')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemBranch($match='branch')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemGiftcard($match='giftcard')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),  // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        public function getAuthItemPricetier($match='pricetier')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"), // Aha! Wildcards go here
                'order'    => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        
        public function getAuthItemPayment($match='payment')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%")  // Aha! Wildcards go here
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
         
        public function getAuthItemSetting($match='setting')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%")  // Aha! Wildcards go here
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
         public function getAuthItemInvoice($match='invoice')
        {
            $match = addcslashes($match, '%_'); // escape LIKE's special characters
            
            $q = new CDbCriteria( array(
                'condition' => "name LIKE :match and type=0",         // no quotes around :match
                'params'    => array(':match' => "$match%"),
                'order'     => "sort_order",
            ) );
            
            $model = Authitem::model()->findAll($q);
            $list    = CHtml::listData($model , 'name','AuthItemName');
            return $list;
        }
        
        
}