<?php

/**
 * This is the model class for table "item_price_promo".
 *
 * The followings are the available columns in table 'item_price_promo':
 * @property integer $id
 * @property integer $item_id
 * @property double $unit_price
 * @property string $start_date
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property Item $item
 */
class ItemPricePromo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_price_promo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unit_price, start_date, end_date', 'required'),
			array('item_id', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'numerical'),
            array('start_date, end_date','date','format' => array('dd/MM/yyyy','d/MM/yyyy')),
            array('end_date','compare','compareAttribute'=>'start_date','operator' => '>','message' => '{attribute} must be greater than "{compareValue}"'),
			array('start_date, end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('item_id, unit_price, start_date, end_date', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'unit_price' => 'Promotion Price',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
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
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPricePromo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave()
    {
        if ($this->start_date<> '' && $this->end_date <> '') {
            $start_date = DateTime::createFromFormat('d/m/Y',$this->start_date);
            $this->start_date = $start_date->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d/m/Y',$this->end_date);
            $this->end_date = $end_date->format('Y-m-d');
            parent::beforeSave();
            return true;
        }
    }

    protected function afterFind()
    {
        $start_date = DateTime::createFromFormat('Y-m-d H:i:s',$this->start_date);
        $this->start_date = $start_date->format('d/m/Y');
        $end_date = DateTime::createFromFormat('Y-m-d H:i:s',$this->end_date);
        $this->end_date = $end_date->format('d/m/Y');
        parent::afterFind();
        return true;
    }

    public function itemPricePromoByItemID($item_id)
    {
        $model = ItemPricePromo::model()->find('item_id=:item_id', array(':item_id' => (int) $item_id));
        if (!$model) {
            $model = new ItemPricePromo;
        }
        return $model;
    }
}
