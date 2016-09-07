<?php

/**
 * This is the model class for table "price_tier".
 *
 * The followings are the available columns in table 'price_tier':
 * @property integer $id
 * @property string $tier_name
 * @property string $modified_date
 * @property string $status
 */
class PriceTier extends CActiveRecord
{
    public $pricetier_archived;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'price_tier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tier_name', 'required'),
            array('tier_name', 'unique'),
            array('tier_name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 1),
            array('modified_date', 'safe'),
            // @todo Please remove those attributes that should not be searched.
            array('tier_name, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'tier_name' => Yii::t('app','Name'),
            'modified_date' => 'Modified Date',
            'status' => 'Status',
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

        //$criteria->compare('id',$this->id);
        $criteria->compare('tier_name', $this->tier_name, true);
        //$criteria->compare('deleted',$this->deleted);

        if (Yii::app()->user->getState('pricetier_archived', Yii::app()->params['defaultArchived']) == 'false') {
            $criteria->addSearchCondition('status', Yii::app()->params['active_status']);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pricetier_pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PriceTier the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function deletePriceTier($id)
    {
        PriceTier::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restorePriceTier($id)
    {
        PriceTier::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    protected function getPriceTierInfo()
    {
        return $this->tier_name;
    }

    public function getPriceTier()
    {
        $model = PriceTier::model()->findAll(array(
            'order' => 'id',
            'condition' => 'status=:active_status',
            'params' => array(':active_status' => Yii::app()->params['active_status'])
        ));
        $list = CHtml::listData($model, 'id', 'PriceTierInfo');

        return $list;
    }

    public function getListPriceTier()
    {
        $sql = "SELECT id tier_id,tier_name,null price FROM `price_tier` WHERE status=:active_status ORDER BY id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':active_status' => Yii::app()->params['active_status'] ));

        return $result;
    }

    public function getListPriceTierUpdate($item_id)
    {
        $sql = "SELECT pt.id tier_id,pt.tier_name,price
                  FROM price_tier pt LEFT JOIN item_price_tier ipt ON ipt.`price_tier_id`=pt.id 
                            AND ipt.`item_id`=:item_id
                  WHERE pt.status=:active_status
                  ORDER BY pt.id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id, ':active_status' => Yii::app()->params['active_status']));

        return $result;
    }

    public function checkExists()
    {
        return PriceTier::model()->count('status=:active_status',
            array(':active_status' => Yii::app()->params['active_status']));
    }
}
