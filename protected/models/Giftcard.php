<?php

/**
 * This is the model class for table "giftcard".
 *
 * The followings are the available columns in table 'giftcard':
 * @property integer $id
 * @property string $giftcard_number
 * @property string $discount_amount
 * @property string $discount_type
 * @property string $status
 * @property integer $client_id
 *
 * The followings are the available model relations:
 * @property Client $client
 */
class Giftcard extends CActiveRecord
{
    public $giftcard_archived;
    public $day; //Day : DD
    public $month; // Month : MM
    public $year; // Year - YYYY
    public $e_day; //Day : DD
    public $e_month; // Month : MM
    public $e_year; // Year - YYYY

    const _active_status='1';
    
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'giftcard';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('giftcard_number, discount_amount', 'required'),
            array('giftcard_number', 'unique'),
			array('client_id, location_id', 'numerical', 'integerOnly'=>true),
			array('giftcard_number', 'length', 'max'=>60),
			array('discount_amount', 'length', 'max'=>15),
			array('discount_type', 'length', 'max'=>2),
			array('status', 'length', 'max'=>1),
            array('start_date, end_date ', 'date', 'format'=>array('yyyy-MM-dd'), 'allowEmpty'=>true),
            array('end_date', 'compare', 'compareAttribute'=>'start_date', 'operator'=>'>=', 'allowEmpty'=>false,
                'message'=>'{attribute} must be greater than {compareValue} '),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, giftcard_number, discount_amount, discount_type, status, client_id', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'giftcard_number' => Yii::t('app','Gift Card Number'),
			'discount_amount' => Yii::t('app','Amount'),
			'discount_type' => Yii::t('app','Discount Type'),
			'status' => Yii::t('app','Status'),
			'client_id' => Yii::t('app','Client'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('giftcard_number',$this->giftcard_number,true);
		$criteria->compare('discount_amount',$this->discount_amount,true);
		$criteria->compare('discount_type',$this->discount_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('client_id',$this->client_id);

        if  ( Yii::app()->user->getState('giftcard_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'giftcard_number LIKE :search OR discount_amount LIKE :search';
            $criteria->params = array(
                ':search' => '%' . $this->giftcard_number . '%',
            );
        } else {
            //$criteria->join = 'LEFT JOIN Location ON Location.id = Giftcard.location_id';
            $criteria->condition = 'status=:active_status AND (giftcard_number LIKE :search OR discount_amount like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->giftcard_number . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('giftcard_PageSize',Yii::app()->params['defaultPageSize']),
            ),
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Giftcard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getGiftcard($name = '')
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = 'SELECT id ,concat_ws(" - discount %",giftcard_number,discount_amount) AS text
                FROM giftcard 
                WHERE giftcard_number= :name
                AND status=:active_status';

        //$name = '%' . $name . '%';
        return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name, ':active_status' => Yii::app()->params['active_status'] ));

    }
        
        /**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
    public function suggest($keyword, $limit = 20)
    {

        $models = $this->findAll(array(
            'condition' => 'giftcard_number like :keyword and status=:active_status',
            'order' => 'giftcard_number',
            'limit' => $limit,
            'params' => array(':keyword' => $keyword, ':active_status' => Yii::app()->params['active_status'])
        ));

        $suggest = array();

        foreach ($models as $model) {
            $suggest[] = array(
                //'label' => $model->giftcard_number . ' - ' . $model->discount_amount,  // label for dropdown list
                'label' => 'Alright, press enter',
                'value' => $model->giftcard_number,  // value for input field
                'id' => $model->id,       // return values from autocomplete
                //'unit_price'=>$model->unit_price,
                //'quantity'=>$model->quantity,
            );
        }

        return $suggest;
    }

    protected function afterFind()
    {
        if ($this->start_date !== null) {
            $start_date = strtotime($this->start_date);
            $this->day = date('d', $start_date);
            $this->month = date('m', $start_date);
            $this->year = date('Y', $start_date);

        }

        if ($this->end_date !== null) {
            $end_date = strtotime($this->end_date);
            $this->e_day = date('d', $end_date);
            $this->e_month = date('m', $end_date);
            $this->e_year = date('Y', $end_date);
        }

        return parent::afterFind();
    }

    public function deleteGiftCard($id)
    {
        Giftcard::model()->updateByPk((int)$id, array('status' => Yii::app()->params['str_zero']));
    }

    public function undodeleteGiftCard($id)
    {
        Giftcard::model()->updateByPk((int)$id, array('status' => Yii::app()->params['str_one']));
    }
}
