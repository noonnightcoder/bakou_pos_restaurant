<?php

/**
 * This is the model class for table "desk".
 *
 * The followings are the available columns in table 'desk':
 * @property integer $id
 * @property string $name
 * @property integer $zone_id
 * @property integer $sort_order
 * @property string $status
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Zone $zone
 */
class Desk extends CActiveRecord
{
    public $list_table;
    public $desk_archived;
    const _active_status = '1';

    private $_active = '1';
    private $_inactive = '0';
        
        
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'desk';
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
			array('zone_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>15),
			array('status', 'length', 'max'=>1),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, zone_id, sort_order', 'safe', 'on'=>'search'),
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
			'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('app','Table Name'),
			'zone_id' => Yii::t('app','Zone Name'),
			'sort_order' => Yii::t('app','Sort Order'),
			'status' => Yii::t('app','Status'),
			'modified_date' => 'Modified Date',
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
	public function search($zone_id = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
        $criteria->with = array('zone');
		//$criteria->compare('zone_id',$this->zone_id);
		//$criteria->compare('sort_order',$this->sort_order);
		//$criteria->compare('status',$this->status,true);
                
        //$criteria->addSearchCondition('zone_id',$zone_id);
        //$criteria->addSearchCondition('zone_id',$zone_id);

        if ($zone_id !== null ) {
            $criteria->condition = 't.zone_id=:zone_id and t.name like :name';
            $criteria->params = array(
                ':zone_id' => $zone_id,
                ':name' => $this->name . '%' );
        }

        if  ( Yii::app()->user->getState('desk_archived', Yii::app()->params['defaultArchived'] ) == 'false' ) {
            $criteria->addSearchCondition('t.status',$this->_active);
        }


        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('desk_PageSize',Yii::app()->params['defaultPageSize']),
            ),
            'sort'=>array( 'defaultOrder'=>'t.sort_order')
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Desk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getTablebyZone($zone_id,$location_id) {
            
            $sql="SELECT DISTINCT d.id,d.name,
                  CASE 
                     WHEN (IFNULL(so.id,0)=0 or so.empty_flag=0) THEN 0
                     ELSE 1
		  END busy_flag
                  FROM desk d LEFT JOIN sale_order so ON so.desk_id=d.id
                                    and so.location_id=:location_id
                                    and so.status=:status
                  WHERE d.zone_id=:zone_id 
                  ORDER BY d.name
                 "; 
            
             $sql="SELECT id,name,occupied busy_flag
                   FROM desk
                   WHERE zone_id=:zone_id
                   AND status=:status
                   ORDER BY name";
            
            $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':zone_id' =>$zone_id,':status'=>$this::_active_status));
            return $result;
        }
        
         public function getTableAll($location_id) {
            
             $sql="SELECT DISTINCT t1.id,t1.`name`,
                        CASE 
                            WHEN (IFNULL(so.id,0)=0 or so.empty_flag=0) THEN 0
                            ELSE 1
                        END busy_flag
                 FROM (
                  SELECT d.id,d.name
                  FROM desk d, zone z 
                  WHERE d.zone_id=z.`id` 
                  AND z.`location_id`=:location_id ) AS t1 LEFT JOIN sale_order so 
                        ON so.desk_id=t1.id 
                        AND so.location_id=:location_id
                        and so.status=1
                 ORDER BY t1.name";
             
            $sql="SELECT d.id,d.name,d.occupied busy_flag
                  FROM desk d INNER JOIN zone z ON z.id=d.zone_id
                            AND z.location_id=:location_id
                  WHERE d.status=:status
                  ORDER BY d.name";
             
            //$result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':location_id' =>(int)$location_id));
            $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':location_id' =>$location_id,':status' =>$this::_active_status));
            return $result;
        }
        
        public static function itemAlias($type,$code=NULL) {
		
            $_items = array(
                     'group' => array(
                             1 => 'Group A',
                             2 => 'Group B',
                             3 => 'Group C',
                             4 => 'Group D',
                             5 => 'Group E',
                     ),
             );

             if (isset($code)) {
                return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
             } else {
                return isset($_items[$type]) ? $_items[$type] : false;
             }
        }
        
        public function getFreeDesk($location_id) {
            $sql="SELECT id,`name`
                  FROM desk
                  WHERE zone_id IN (SELECT id FROM zone WHERE location_id=:location_id)
                  ORDER BY name";
            
            return Yii::app()->db->createCommand($sql)->queryAll(true,array(':location_id' =>$location_id));
        }

        public function getBusyDesk($location_id) {
            $sql="SELECT so.`desk_id`,d.`name` desk_name,so.`group_id`
                FROM sale_order so , desk d
                WHERE so.`desk_id`=d.`id`
                AND so.location_id=:location_id
                AND so.`status`=1
                ORDER BY d.name,so.`group_id`";

            return Yii::app()->db->createCommand($sql)->queryAll(true,array(':location_id' =>$location_id));
        }

        protected function getTableInfo()
        {
            return $this->name;
        }
        
        public function getTable()
        {
            $model = Desk::model()->findAll(array('order'=>'name'));
            $list  = CHtml::listData($model , 'id', 'TableInfo');
            return $list;
        }
        
        public function deleteDesk($id)
        {
            $this->updateByPk((int)$id,array('status'=>$this->_inactive));
        }
        
        public function undodeleteDesk($id)
        {
            $this->updateByPk((int)$id,array('status'=>$this->_active));
        }
       
               
}
