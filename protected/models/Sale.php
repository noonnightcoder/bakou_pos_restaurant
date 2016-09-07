<?php

/**
 * This is the model class for table "sale".
 *
 * The followings are the available columns in table 'sale':
 * @property integer $id
 * @property string $sale_time
 * @property integer $client_id
 * @property integer $desk_id
 * @property integer $zone_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 * @property string $discount_amount
 * @property string $discount_type
 *
 * The followings are the available model relations:
 * @property Desk $desk
 * @property Zone $zone
 * @property SaleItem[] $saleItems
 * @property SaleTable[] $saleTables
 */
class Sale extends CActiveRecord
{

    // To do: to remove using params in main config file instead
    private $sale_cancel_status = '0';
    private $sale_complete_status = '1';
    private $sale_suspend_status = '2';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sale';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sale_time', 'required'),
            array('client_id, desk_id, zone_id, employee_id', 'numerical', 'integerOnly' => true),
            array('sub_total', 'numerical'),
            array('payment_type', 'length', 'max' => 255),
            array('status', 'length', 'max' => 20),
            array('discount_amount', 'length', 'max' => 15),
            array('discount_type', 'length', 'max' => 2),
            array('remark', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sale_time, client_id, desk_id, zone_id, employee_id, sub_total, payment_type, status, remark, discount_amount, discount_type', 'safe', 'on' => 'search'),
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
            'desk' => array(self::BELONGS_TO, 'Desk', 'desk_id'),
            'zone' => array(self::BELONGS_TO, 'Zone', 'zone_id'),
            'saleItems' => array(self::HAS_MANY, 'SaleItem', 'sale_id'),
            'saleTables' => array(self::HAS_MANY, 'SaleTable', 'sale_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'sale_time' => 'Sale Time',
            'client_id' => 'Client',
            'desk_id' => 'Desk',
            'zone_id' => 'Zone',
            'employee_id' => 'Employee',
            'sub_total' => 'Sub Total',
            'payment_type' => 'Payment Type',
            'status' => 'Status',
            'remark' => 'Remark',
            'discount_amount' => 'Discount Amount',
            'discount_type' => 'Discount Type',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('sale_time', $this->sale_time, true);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('desk_id', $this->desk_id);
        $criteria->compare('zone_id', $this->zone_id);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('sub_total', $this->sub_total);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('discount_amount', $this->discount_amount, true);
        $criteria->compare('discount_type', $this->discount_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sale the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
       
    public function saveSale($desk_id,$group_id,$location_id,$payment_total,$employee_id)
    {
        $sql="SELECT func_save_sale(:desk_id,:group_id,:location_id,:payment_total,:employee_id) sale_id";
        $result=Yii::app()->db->createCommand($sql)->queryAll(true, array(
                        ':desk_id'=>$desk_id,
                        ':group_id'=>$group_id,
                        ':location_id'=>$location_id,
                        ':payment_total'=>$payment_total,
                        ':employee_id'=>$employee_id
                    )
                );
        
        foreach ($result as $record) {
            $sale_id = $record['sale_id'];
        }
        
        return $sale_id;
       
    }
    
    public function cashierDailySale($employee_id,$location_id)
    {
        $sql="SELECT name,SUM(quantity) quantity,SUM(price) price,SUM(quantity*price) total
            FROM (
            SELECT `name`,category_id,SUM(quantity) quantity,SUM(price) price,SUM(quantity*price) total
            FROM v_sale_cart
            WHERE DATE(sale_time)=CURDATE()
            AND employee_id=:employee_id
            AND location_id=:location_id
            AND status=:status
            GROUP BY `name`,category_id
            ORDER BY quantity,category_id
            ) as t1
            GROUP BY name 
            WITH ROLLUP";
        
         $sql="SELECT IFNULL(`name`,'Total Food & Beverage') `name`,
               total_flag,quantity,price,total
             FROM (
                SELECT 
                   IFNULL(vs.`name`,concat('Total ',c.name)) `name`,
                   IFNULL(vs.`name`,'1') total_flag,
                   -- c.`name` caetory_name,
                   SUM(quantity) quantity,SUM(price) price,SUM(quantity*price) total
               FROM v_sale_cart vs LEFT JOIN category c ON c.id=vs.category_id
               WHERE DATE(sale_time)=CURDATE()
               AND employee_id=:employee_id
               AND location_id=:location_id
               AND status=:status
               GROUP BY c.`name`,vs.`name`
               WITH ROLLUP
            ) as t";
           
        return Yii::app()->db->createCommand($sql)->queryAll(true,array(
                ':employee_id' => $employee_id,
                ':location_id' => $location_id,
                ':status' => $this->sale_complete_status)
        );        
    }
    
    public function cashierDailySaleTotal($employee_id,$location_id)
    {
            $sub_total=0;
            $total=0;
            $discount_amount=0;
            
            $sql="SELECT SUM(sub_total) sub_total,
                    SUM(sub_total*discount_amount/100) discount_amount,
                    SUM(sub_total)-SUM(sub_total*discount_amount/100) total
              FROM sale
              WHERE DATE(sale_time)=CURDATE()
              AND employee_id=:employee_id
              AND location_id=:location_id
              AND status=:status";
            
            $result=Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':employee_id' => $employee_id,
                    ':location_id' => $location_id,
                    ':status' => $this->sale_complete_status
                    )
             );
            
            if ($result) {
                foreach ($result as $record) {
                    $sub_total = $record['sub_total'];
                    $discount_amount = $record['discount_amount'];
                    $total = $record['total'];
                }
            } 
            
            return array($sub_total, $total, $discount_amount);
    }
   

}
