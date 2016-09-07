<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $id
 * @property string $name
 * @property string $item_number
 * @property integer $unit_id
 * @property integer $category_id
 * @property integer $supplier_id
 * @property double $cost_price
 * @property double $unit_price
 * @property double $quantity
 * @property double $reorder_level
 * @property string $location
 * @property integer $allow_alt_description
 * @property integer $is_serialized
 * @property string $description
 * @property integer $deleted
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Inventory[] $inventories
 * @property Category $category
 * @property Supplier $supplier
 * @property Sale[] $sales
 * @property integer $topping
 */
class Item extends CActiveRecord
{
    public $inventory;
    public $inv_quantity;
    public $items_add_minus;
    public $inv_comment;
    public $sub_quantity;
    public $unit_id;
    public $image;
    public $promo_price;
    public $promo_start_date;
    public $promo_end_date;
    public $item_archived;

    const _zero = 0;

    private $item_active = '1';
    private $item_inactive = '0';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Item the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, cost_price, unit_price', 'required'),
            array('name, item_number', 'unique'),
            array(
                'category_id, supplier_id, unit_id, allow_alt_description, is_serialized, deleted, topping',
                'numerical',
                'integerOnly' => true
            ),
            array('cost_price, unit_price, quantity, reorder_level, items_add_minus, promo_price', 'numerical'),
            array('name', 'length', 'max' => 50),
            array('item_number', 'length', 'max' => 255),
            array('location', 'length', 'max' => 20),
            array('description, inv_comment, promo_end_date, promo_start_date', 'safe'),
            array('image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true, 'maxSize' => 5 * 1024 * 1024),
            array('item_number', 'default', 'setOnEmpty' => true, 'value' => null),
            array(
                'created_date,modified_date',
                'default',
                'value' => date('Y-m-d H:i:s'),
                'setOnEmpty' => true,
                'on' => 'insert'
            ),
            array('modified_date', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, name, item_number,unit_id, category_id, supplier_id, cost_price, unit_price, quantity, reorder_level, location, allow_alt_description, is_serialized, description, deleted, promo_price',
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
            'inventories' => array(self::HAS_MANY, 'Inventory', 'trans_items'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            //'unit' => array(self::BELONGS_TO, 'ItemUnit', 'unit_id'),
            'sales' => array(self::MANY_MANY, 'Sale', 'sale_item(item_id, sale_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('app', 'Item Name'),
            'item_number' => Yii::t('app', 'Item No'),
            'unit_id' => Yii::t('app', 'Unit'),
            'category_id' => Yii::t('app', 'Category'),
            'supplier_id' => Yii::t('app', 'Supplier'),
            'cost_price' => Yii::t('app', 'Buy Price'),
            'unit_price' => Yii::t('app', 'Price 1'),
            'quantity' => Yii::t('app', 'Quantity'),
            'reorder_level' => Yii::t('app', 'Reorder Level'),
            'location' => Yii::t('app', 'Location'),
            'allow_alt_description' => Yii::t('app', 'Alt Description'),
            'is_serialized' => Yii::t('app', 'Is Serialized'),
            'description' => Yii::t('app', 'Description'),
            'deleted' => Yii::t('app', 'model.item.deleted'),
            'items_add_minus' => Yii::t('app', 'model.item.items_add_minus'),
            'inv_quantity' => Yii::t('app', 'Inv Quantity'),
            'inv_comment' => Yii::t('app', 'Inv Comment'),
            'inventory' => Yii::t('app', 'Inventory'),
            'sub_quantity' => Yii::t('app', 'Sub Quantity'),
            'promo_price' => Yii::t('app', 'Promo Price'),
            'promo_start_date' => Yii::t('app', 'Promo Start'),
            'promo_end_date' => Yii::t('app', 'Promo End'),
            'topping' => Yii::t('app', 'Topping'),
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

        $criteria = new CDbCriteria;

        //$criteria->compare('id',$this->id);

        //$criteria->condition = 'name LIKE :name OR item_number like :name';
        //$criteria->params = array(':name'=>'%' . $this->name .'%', ':item_number'=>$this->name . '%');

        if (Yii::app()->user->getState('archived', Yii::app()->params['defaultArchived']) == 'true') {
            $criteria->condition = 'name LIKE :name OR item_number LIKE :item_number';
            $criteria->params = array(
                ':name' => '%' . $this->name . '%',
                ':item_number' => $this->name . '%'
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name LIKE :name OR item_number like :item_number)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':name' => '%' . $this->name . '%',
                ':item_number' => $this->name . '%'
            );
        }

        $criteria->compare('category_id',$this->category_id);
        $criteria->compare('topping',$this->topping);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array('defaultOrder' => 'item_number')
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function lowStock()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        //$criteria->compare('cost_price',$this->cost_price);
        //$criteria->compare('unit_price',$this->unit_price);
        //$criteria->compare('quantity',$this->quantity);
        //$criteria->compare('reorder_level',$this->reorder_level);
        $criteria->compare('location', $this->location, true);
        //$criteria->compare('allow_alt_description',$this->allow_alt_description);
        //$criteria->compare('is_serialized',$this->is_serialized);
        $criteria->compare('description', $this->description, true);
        //$criteria->compare('deleted',$this->deleted);

        $criteria->condition = "quantity<reorder_level and quantity<>0";

        //$criteria->condition="quantity<>0";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array('defaultOrder' => 'name')
        ));
    }

    // Item out of stock or zero stock
    public function outStock()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        //$criteria->compare('cost_price',$this->cost_price);
        //$criteria->compare('unit_price',$this->unit_price);
        //$criteria->compare('quantity',$this->quantity);
        //$criteria->compare('reorder_level',$this->reorder_level);
        $criteria->compare('location', $this->location, true);
        //$criteria->compare('allow_alt_description',$this->allow_alt_description);
        //$criteria->compare('is_serialized',$this->is_serialized);
        $criteria->compare('description', $this->description, true);
        //$criteria->compare('deleted',$this->deleted);

        $criteria->condition = "quantity=0";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array('defaultOrder' => 'name')
        ));
    }

    public function topping($category_id)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('category_id', $this->category_id);

        $criteria->condition = "topping=1";
        $criteria->addSearchCondition('category_id', $category_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array('defaultOrder' => 'name')
        ));
    }


    /*
     * Looking up Item Select2 where topping=0
     */
    public static function getItem($name = '', $price_tier_id)
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = 'SELECT id ,concat_ws(" - ",item_number,concat_ws(" : ",name,unit_price)) AS text
                    FROM item 
                    WHERE name LIKE :item_name
                    AND topping=0
                    UNION ALL
                    SELECT id ,concat_ws(" - ",item_number,concat_ws(" : ",name,unit_price)) AS text
                    FROM item
                    WHERE item_number=:item_number
                    AND topping=0';

        $sql = "SELECT id,concat_ws(' - ',item_number,text) as text
                  FROM (
                  SELECT i.id,
                        concat_ws(' : ',i.name,
                        CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
                            ELSE i.`unit_price`
                        END ) as text,item_number
                  FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
                    AND ipt.`price_tier_id`=:price_tier_id
                  WHERE i.name LIKE :item_name
                  AND topping=0
                  UNION ALL
                  SELECT i.id,
                        concat_ws(' : ',i.name,
                        CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
                            ELSE i.`unit_price`
                        END ) as text,item_number
                  FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
                    AND ipt.`price_tier_id`=:price_tier_id  
                  WHERE i.item_number like :item_number
                  AND topping=0
                  ) as t1";

        $item_name = '%' . $name . '%';
        //$item_number = $name;
        $item_number = '%' . $name . '%';

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':item_name' => $item_name, ':item_number' => $item_number, ':price_tier_id' => $price_tier_id));
    }

    public function getItemInfo($item_id)
    {
        $model = Item::model()->findByPk((int)$item_id);

        return $model;
    }

    public function costHistory($item_id)
    {
        $sql = "SELECT
                    r.`id`,
                    r.`receive_time`,
                    IFNULL((SELECT company_name FROM supplier s WHERE s.id=r.`supplier_id`),'N/A') supplier_id,
                    r.`employee_id`,
                    r.`remark`,
                    ri.`cost_price`,
                    ri.`quantity`
                  FROM `receiving` r INNER JOIN receiving_item ri ON r.id=ri.`receive_id`
                                                  AND ri.`item_id`=:item_id
                  ORDER BY r.receive_time";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'id',
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));

        return $dataProvider; // Return as array object
    }

    public function avgCost($item_id)
    {
        $sql = "SELECT AVG(cost_price) avg_cost FROM `receiving_item` WHERE item_id=:item_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => (int)$item_id));

        foreach ($result as $record) {
            $cost = $record['avg_cost'];
        }

        return $cost;
    }

    public function avgPrice($item_id)
    {
        $sql = "SELECT AVG(new_price) avg_cost FROM `item_price` WHERE item_id=:item_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => (int)$item_id));

        foreach ($result as $record) {
            $cost = $record['avg_cost'];
        }

        return $cost;
    }

    protected function afterFind()
    {

        $this->cost_price = round($this->cost_price, Yii::app()->shoppingCart->getDecimalPlace());
        $this->unit_price = round($this->unit_price, Yii::app()->shoppingCart->getDecimalPlace());

        parent::afterFind(); //To raise the event
    }

    public function getItemPriceTier($item_id, $price_tier_id)
    {
        $sql = "SELECT i.`id`,i.`name`,i.`item_number`,
                    CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
                        ELSE i.`unit_price`
                    END unit_price,
                    i.`description`
            FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
                    AND ipt.`price_tier_id`=:price_tier_id
            WHERE i.id=:item_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':item_id' => (int)$item_id, ':price_tier_id' => $price_tier_id));

        return $result;
    }

    public function itemTopping()
    {

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('supplier_id', $this->supplier_id);

        //$criteria->with = array( 'category' );
        //$criteria->compare( 'category.name', $this->category_search, true );

        $criteria->condition = "quantity=0";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array('defaultOrder' => 'name')
        ));
    }

    /**
     * Suggests a list of existing values matching the specified keyword.
     * @param string the keyword to be matched
     * @param integer maximum number of names to be returned
     * @return array list of matching lastnames
     */
    public function suggest($keyword, $limit = 20)
    {

        $sql = "SELECT id,concat_ws(' - ',item_number,text) as text,name
                    FROM (
                    SELECT i.id,
                          concat_ws(' : ',i.name,
                          CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
                              ELSE i.`unit_price`
                          END ) as text,item_number,i.name
                    FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
                      AND ipt.`price_tier_id`=:price_tier_id
                    WHERE i.name LIKE :item_name
                    AND topping=:zero
                    UNION ALL
                    SELECT i.id,
                          concat_ws(' : ',i.name,
                          CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
                              ELSE i.`unit_price`
                          END ) as text,item_number,i.name
                    FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
                      AND ipt.`price_tier_id`=:price_tier_id  
                    WHERE i.item_number like :item_number
                    AND topping=:zero
                    ) as t1";

        $item_name = $keyword . '%';
        $item_number = $keyword . '%';

        $models = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':item_name' => $item_name,
            ':item_number' => $item_number,
            ':price_tier_id' => Yii::app()->orderingCart->getPriceTier(),
            'zero' => $this::_zero
        ));

        $suggest = array();

        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['text'],
                'value' => $model['name'],  // value for input field
                'id' => $model['id'],       // return values from autocomplete
                //'unit_price'=>$model['id'],
                //'quantity'=>$model['id'],
            );
        }

        return $suggest;
    }

    public function deleteItem($item_id)
    {
        Item::model()->updateByPk((int)$item_id, array('status' => Yii::app()->params['inactive_status']));
    }

    public function undodeleteItem($item_id)
    {
        Item::model()->updateByPk((int)$item_id, array('status' => Yii::app()->params['active_status']));
    }

    public static function itemAlias($type, $code = null)
    {

        $_items = array(
            'item_type' => array(
                0 => 'Main-Menu',
                1 => 'Topping',
            ),
        );

        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else {
            return isset($_items[$type]) ? $_items[$type] : false;
        }
    }


}