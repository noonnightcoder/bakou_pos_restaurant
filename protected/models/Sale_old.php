<?php

/**
 * This is the model class for table "sale".
 *
 * The followings are the available columns in table 'sale':
 * @property integer $id
 * @property string $sale_time
 * @property integer $customer_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 * @property double $discount_amount
 * @property integer $discount_percent
 *
 * The followings are the available model relations:
 * @property SaleItem[] $saleItems
 */
class Sale extends CActiveRecord
{

    public $search;
    public $amount;
    public $quantity;
    public $from_date;
    public $to_date;
    public $balance;
    public $data_paid;
    public $note;
    public $sale_id;

    // To do: to remove using params in main config file instead
    const sale_cancel_status = '0';
    const sale_complete_status = '1';
    const sale_suspend_status = '2';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Sale the static model class
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
            //array('sale_time', 'required'),
            array('client_id, employee_id', 'numerical', 'integerOnly' => true),
            array('sub_total, discount_amount', 'numerical'),
            array('status', 'length', 'max' => 25),
            array('payment_type', 'length', 'max' => 255),
            array('sale_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('remark, sale_time, discount_type', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sale_time, client_id, employee_id, sub_total, payment_type,status, remark, discount_amount, discount_type', 'safe', 'on' => 'search'),
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
            'saleItems' => array(self::HAS_MANY, 'SaleItem', 'sale_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
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
            'client_id' => 'Customer name',
            'employee_id' => 'Employee',
            'sub_total' => 'Amount',
            'payment_type' => 'Payment Type',
            'status' => 'Status',
            'remark' => 'Remark',
            'discount_amount' => Yii::t('model','model.saleitem.discount_amount'), // 'Discount Amount',
            'discount_type' => Yii::t('model','model.saleitem.discount_type'),//'Discount Type',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('sale_time', $this->sale_time, true);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('sub_total', $this->sub_total);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('status', $this->status, true);
       // $criteria->compare('remark', $this->remark, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function saveSale($in_sale_id, $items, $payments, $payment_received, $customer_id, $employee_id, $sub_total, $comment, $status = self::sale_complete_status, $discount_amount=0,$zone_id,$table_id)
    {
        if (count($items) == 0) {
            return -1;
        }

        if ($in_sale_id) {
            $model = Sale::model()->findByPk((int)$in_sale_id);
        } else {
            $model = new Sale;
        }

        $payment_types = '';

        foreach ($payments as $payment_id => $payment) {
            $payment_types = $payment_types . $payment['payment_type'] . ': ' . $payment['payment_amount'] . '<br />';
        }

        $transaction = Yii::app()->db->beginTransaction();
        try {

            //Saving existing Sale Item to Inventory table and removing it out
            if ($in_sale_id) {

                $trans_date = date('Y-m-d H:i:s');

                $sql = "INSERT INTO inventory(trans_items,trans_user,trans_date,trans_comment,trans_inventory)
                        SELECT si.item_id,:employee_id trans_user,:trans_date trans_date,:trans_comment trans_comment,si.quantity
                        FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id and s.id=:sale_id
                        ";

                $command = Yii::app()->db->createCommand($sql);

                $trans_comment = 'Change Sale ' . $in_sale_id;
                $command->bindParam(":trans_date", $trans_date);
                $command->bindParam(":trans_comment", $trans_comment, PDO::PARAM_STR);
                $command->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
                $command->bindParam(":sale_id", $in_sale_id, PDO::PARAM_INT);

                $command->execute();

                $sql1 = "UPDATE item t1 
                            INNER JOIN sale_item t2 
                                 ON t1.id = t2.item_id
                     SET t1.quantity = t1.quantity+t2.quantity
                     WHERE t2.sale_id=:sale_id";

                $command1 = Yii::app()->db->createCommand($sql1);
                $command1->bindParam(":sale_id", $in_sale_id, PDO::PARAM_INT);
                $command1->execute();

                $sql2 = "delete from sale_item where sale_id=:sale_id";
                $command2 = Yii::app()->db->createCommand($sql2);
                $command2->bindParam(":sale_id", $in_sale_id, PDO::PARAM_INT);
                $command2->execute();
            }

            //$model->sale_time = date('Y-m-d H:i:s');
            $model->client_id = $customer_id;
            $model->employee_id = $employee_id;
            $model->payment_type = $payment_types;
            $model->remark = $comment;
            $model->sub_total = $sub_total;
            $model->status = $status;
            $model->discount_amount = $discount_amount;
            $model->discount_type = '%'; //To do : consider to support discount in USD as well for next version

            if ($model->save()) {
                $sale_id = $model->id;
                $date_paid = date('Y-m-d H:i:s');

                // Saving Sale Payment
                $this->saveSalePayment($sale_id, $payments, $payment_received, $date_paid);

                $this->saveSaleItem($items, $sale_id, $employee_id);
                
                $this->saveSaleTable($sale_id,$zone_id,$table_id);

                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollback();
            return -1;
            //$sale_id = $e; //Uncomment here for debuggin purpose
        }
        //return $sale_id;
    }
    
    protected function saveSaleTable($sale_id,$zone_id,$table_id) {
        $sale_table = new SaleTable;
        $sale_table->sale_id=$sale_id;
        $sale_table->zone_id=$zone_id;
        $sale_table->table_id=$table_id;
        $sale_table->save();
    }    

    protected function saveSalePayment($sale_id, $payments, $payment_received, $date_paid)
    {
        if ($payment_received > 0) {
            // Saving payment items to sale_payment table
            foreach ($payments as $payment) {
                $sale_payment = new SalePayment;
                $sale_payment->sale_id = $sale_id;
                $sale_payment->payment_type = $payment['payment_type'];
                $sale_payment->payment_amount = $payment['payment_amount'];
                $sale_payment->date_paid = $date_paid;
                $sale_payment->save();
            }
        }
    }

    // Saving into Sale_Item table for each item purchased
    protected function saveSaleItem($items, $sale_id, $employee_id)
    {
        // Saving sale item to sale_item table
        foreach ($items as $line => $item) {
            $cur_item_info = Item::model()->findbyPk($item['item_id']);
            $qty_in_stock = $cur_item_info->quantity;

            if (substr($item['discount'], 0, 1) == '$') {
                $discount_amount = substr($item['discount'], 1);
                $discount_type = '$';
            } else {
                $discount_amount = $item['discount'];
                $discount_type = '%';
            }

            $sale_item = new SaleItem;

            $sale_item->sale_id = $sale_id;
            $sale_item->item_id = $item['item_id'];
            $sale_item->line = $line;
            $sale_item->quantity = $item['quantity'];
            $sale_item->cost_price = $cur_item_info->cost_price;
            $sale_item->unit_price = $cur_item_info->unit_price;
            $sale_item->price = $item['price']; // The exact selling price
            $sale_item->discount_amount = $discount_amount == null ? 0 : $discount_amount;
            $sale_item->discount_type = $discount_type;

            $sale_item->save();

            //Updating stock quantity
            $cur_item_info->quantity = $qty_in_stock - $item['quantity'];
            $cur_item_info->save();
            
            //Ramel Inventory Tracking
            $inventory = new Inventory;
            $qty_buy = -$item['quantity'];
            $sale_remarks = 'POS ' . $sale_id;
            $inventory->trans_items = $item['item_id'];
            $inventory->trans_user = $employee_id;
            $inventory->trans_comment = $sale_remarks;
            $inventory->trans_inventory = $qty_buy;
            $inventory->trans_date = date('Y-m-d H:i:s');
            $inventory->save();
            
            // Update quantity in expiry table
            $this->updateStockExpire($item['item_id'], $item['quantity'], $sale_id);
        }
    }
    
    public function updateStockExpire($item_id, $quantity, $sale_id)
    {
        $sql = "SELECT `id`,`item_id`,`expire_date`,`quantity`
                FROM `item_expire`
                WHERE item_id=:item_id
                AND quantity>0
                ORDER BY expire_date";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id));
        if ($result) {

            foreach ($result as $record) {
                $item_expire = ItemExpire::model()->find('id=:id', array(':id' => $record["id"]));
                if ($quantity <= $record["quantity"]) {
                    $item_expire->quantity = $item_expire->quantity - $quantity;
                    $item_expire->save();
                    $item_expire_dt = new ItemExpireDt;
                    $item_expire_dt->item_expire_id=$item_expire->id;
                    $item_expire_dt->trans_id=$sale_id;
                    $item_expire_dt->trans_qty=-$quantity;
                    $item_expire_dt->trans_comment='POS ' . $sale_id;
                    $item_expire_dt->modified_date=date('Y-m-d H:s:i');
                    $item_expire_dt->save();
                    break;
                } else {
                    $deducted_qty=$item_expire->quantity;
                    $item_expire->quantity = $item_expire->quantity - $deducted_qty;
                    $item_expire->save();

                    $item_expire_dt = new ItemExpireDt;
                    $item_expire_dt->item_expire_id=$item_expire->id;
                    $item_expire_dt->trans_id=$sale_id;
                    $item_expire_dt->trans_qty=-$quantity;
                    $item_expire_dt->trans_comment='POS ' . $sale_id;
                    $item_expire_dt->modified_date=date('Y-m-d H:s:i');
                    $item_expire_dt->save();
                    $quantity = $quantity - $deducted_qty;
                }
            }
        }
    }

    public function saveSaleCookie($items, $customer_id, $employee_id, $comment)
    {
        if (count($items) == 0 && !isset($customer_id)) {
            return -1;
        }

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $query = "delete from sale_client_cookie where client_id=:client_id";
            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":client_id", $customer_id, PDO::PARAM_INT);
            $command->execute();

            // Saving sale item to sale_item table
            foreach ($items as $line => $item) {

                if (substr($item['discount'], 0, 1) == '$') {
                    $discount_amount = substr($item['discount'], 1);
                    $discount_type = '$';
                } else {
                    $discount_amount = $item['discount'];
                    $discount_type = '%';
                }

                $cur_item_info = Item::model()->findbyPk($item['item_id']);

                //Saving frequency buy items for client
                $sale_client_cookie = new SaleClientCookie;
                $sale_client_cookie->client_id = $customer_id;
                $sale_client_cookie->item_id = $item['item_id'];
                $sale_client_cookie->quantity = $item['quantity'];
                $sale_client_cookie->cost_price = $cur_item_info->cost_price;
                $sale_client_cookie->unit_price = $cur_item_info->unit_price;
                $sale_client_cookie->price = $item['price']; // The exact selling price
                $sale_client_cookie->discount_amount = $discount_amount == null ? 0 : $discount_amount;
                $sale_client_cookie->discount_type = $discount_type;
                $sale_client_cookie->save();
            }
            $transaction->commit();
        } catch (Exception $e) {
            //$sale_id=$e; //Uncomment here for debuggin purpose
            $transaction->rollback();
            return -1;
        }
        //return $sale_id;
    }

    public function deleteSale($sale_id, $remark)
    {

        $transaction = Yii::app()->db->beginTransaction();
        try {
            //-- Update stock level back
            $sql = "UPDATE item t1
                        INNER JOIN sale_item t2 
                             ON t1.id = t2.item_id
                SET t1.quantity = t1.`quantity`+t2.`quantity`
                WHERE t2.sale_id = :sale_id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":sale_id", $sale_id, PDO::PARAM_INT);
            $command->execute();
            
            $canel_status=self::sale_cancel_status;

            // --update sale status to be deactivated
            $sql1 = "UPDATE sale SET STATUS=:sale_status, REMARK=:remark WHERE  id=:sale_id";
            $command1 = Yii::app()->db->createCommand($sql1);
            $command1->bindParam(":sale_status", $cancel_status, PDO::PARAM_STR);
            $command1->bindParam(":remark", $remark, PDO::PARAM_STR);
            $command1->bindParam(":sale_id", $sale_id, PDO::PARAM_INT);
            $command1->execute();

            /*
              $sql2="DELETE FROM sale_payment WHERE sale_id=:sale_id";
              $command2= Yii::app()->db->createCommand($sql2);
              $command2->bindParam(":sale_id", $sale_id, PDO::PARAM_INT);
              $command2->execute();
             * 
             */
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return -1;
        }

        //2nd Way using store procedure in mysql database
        //$sql = "CALL pro_cancelsale(:sale_id,:remark)";
        //return Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => $sale_id, ':remark' => $remark));
    }

    public static function itemAlias($type, $code = NULL)
    {

        $_items = array(
            'register_mode' => array(
                'Sale' => 'Sale',
                'Return' => 'Return',
            ),
        );

        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function saleInvoice($client_id = 0, $search_text)
    {

        if ($client_id == 0) {
            $sql = "SELECT CASE 
                                WHEN paid=0 THEN 'not yet paid'
                                WHEN (amount-paid)=0 THEN 'fully paid'
                                ELSE 'paid some'
                            END status,
                            sale_id,sale_time,client_id,employee_id,amount,(amount-paid) amount_to_paid,paid,balance
                        FROM (
                        SELECT s.id sale_id,date_format(s.sale_time,'%d-%m-%Y %H:%i') sale_time,s.employee_id,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s LEFT JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                                        LEFT JOIN `client` c ON c.`id`=s.`client_id`
                        WHERE s.status IS NULL                
                        ) AS t 
                       WHERE paid=0 and balance>0";

            if ($search_text === '0') {
                $sql = "SELECT
                        CASE 
                            WHEN paid=0 THEN '0' --'not yet paid'
                            WHEN (amount-paid)<=0 THEN '1' --'fully paid'
                            ELSE '2' --'paid some'
                        END status,
                        sale_id,sale_time,client_id,employee_id,amount,(amount-paid) amount_to_paid,paid
                    FROM (
                    SELECT s.id sale_id,DATE_FORMAT(s.sale_time,'%d-%m-%Y %H:%i') sale_time,s.employee_id,CONCAT_WS(' ',first_name,last_name) client_id,
                            IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid
                    FROM sale s LEFT JOIN (SELECT sale_id,SUM(payment_amount) paid FROM sale_payment GROUP BY sale_id) sa ON sa.`sale_id`=s.`id`
                                    LEFT JOIN `client` c ON c.`id`=s.`client_id`              
                    ) AS inv
                    Order by sale_time";
                $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);
            } else {
                $sql = "SELECT
                        CASE 
                            WHEN paid=0 THEN '0' --'not yet paid'
                            WHEN (amount-paid)<=0 THEN '1' --'fully paid'
                            ELSE '2' --'paid some'
                        END status,
                        sale_id,sale_time,client_id,employee_id,amount,(amount-paid) amount_to_paid,paid
                    FROM (
                    SELECT s.id sale_id,DATE_FORMAT(s.sale_time,'%d-%m-%Y %H:%i') sale_time,s.employee_id,CONCAT_WS(' ',first_name,last_name) client_id,
                            IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid
                    FROM sale s LEFT JOIN (SELECT sale_id,SUM(payment_amount) paid FROM sale_payment GROUP BY sale_id) sa ON sa.`sale_id`=s.`id`
                                    LEFT JOIN `client` c ON c.`id`=s.`client_id`
                    WHERE s.id=:search_text
                    ) AS inv
                    UNION ALL
                    SElECT status,sale_id,sale_time,client_id,employee_id,amount,(amount-paid) amount_to_paid,paid
                    FROM (
                        SELECT
                            CASE 
                                WHEN paid=0 THEN '0' --'not yet paid'
                                WHEN (amount-paid)<=0 THEN '1' --'fully paid'
                                ELSE '2' --'paid some'
                            END status,
                            sale_id,sale_time,client_id,employee_id,amount,(amount-paid) amount_to_paid,paid
                        FROM (
                        SELECT s.id sale_id,DATE_FORMAT(s.sale_time,'%d-%m-%Y %H:%i') sale_time,s.employee_id,CONCAT_WS(' ',first_name,last_name) client_id,
                                IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid
                        FROM sale s LEFT JOIN (SELECT sale_id,SUM(payment_amount) paid FROM sale_payment GROUP BY sale_id) sa ON sa.`sale_id`=s.`id`
                                        LEFT JOIN `client` c ON c.`id`=s.`client_id`
                        ) AS inv
                    ) as T
                    WHERE client_id like :client_name
                    ";

                $client_name = '%' . $search_text . '%';
                $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(":search_text" => $search_text, ':client_name' => $client_name));
            }
        } elseif (isset($this->sale_id)) {
            $sql = "SELECT
                            CASE 
                                WHEN paid=0 THEN 'not yet paid'
                                WHEN (amount-paid)=0 THEN 'fully paid'
                                ELSE 'paid some'
                            END status,
                            sale_id,sale_time,client_id,amount,(amount-paid) amount_to_paid,paid,balance
                        FROM (
                        SELECT s.id sale_id,date_format(s.sale_time,'%d-%m-%Y %H:%i') sale_time,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                                        INNER JOIN `client` c ON c.`id`=s.`client_id`
                                            AND c.id=:client_id     
                        WHERE s.id=:sale_id
                        AND s.status IS NULL
                        ) AS t
                        WHERE balance<>0
                        ORDER BY sale_time";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => (int) $client_id, ':sale_id' => (int) $this->sale_id));
        } else {
            $sql = "SELECT
                            CASE 
                                WHEN paid=0 THEN 'not yet paid'
                                WHEN (amount-paid)=0 THEN 'fully paid'
                                ELSE 'paid some'
                            END status,
                            sale_id,sale_time,client_id,amount,(amount-paid) amount_to_paid,paid,balance
                        FROM (
                        SELECT s.id sale_id,date_format(s.sale_time,'%d-%m-%Y %H:%i') sale_time,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                                        INNER JOIN `client` c ON c.`id`=s.`client_id`
                                            AND c.id=:client_id     
                        WHERE s.status IS NULL                    
                        ) AS t
                        WHERE balance<>0
                        ORDER BY sale_time";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => (int) $client_id));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function Invoice($client_id = 0)
    {

        if ($client_id == 0) {
            $sql = "SELECT
                            CASE 
                                WHEN paid=0 THEN 'not yet paid'
                                WHEN (amount-paid)=0 THEN 'fully paid'
                                ELSE 'paid some'
                            END status,
                            sale_id,sale_time,client_id,amount,(amount-paid) amount_to_paid,paid,balance
                        FROM (
                        SELECT s.id sale_id,date_format(s.sale_time,'%d-%m-%Y %H:%i') sale_time,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s LEFT JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                                        LEFT JOIN `client` c ON c.`id`=s.`client_id`
                        WHERE s.status IS NULL                
                        ) AS t 
                        ";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);
        } else {
            $sql = "SELECT
                            CASE 
                                WHEN paid=0 THEN 'not yet paid'
                                WHEN (amount-paid)=0 THEN 'fully paid'
                                ELSE 'paid some'
                            END status,
                            sale_id,sale_time,client_id,amount,(amount-paid) amount_to_paid,paid,balance
                        FROM (
                        SELECT s.id sale_id,date_format(s.sale_time,'%d-%m-%Y %H:%i') sale_time,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                                        INNER JOIN `client` c ON c.`id`=s.`client_id`
                                            AND c.id=:client_id
                        WHERE s.status IS NULL
                        ) AS t
                        ORDER BY sale_time";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => (int) $client_id));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function amountToPaid($sale_id)
    {
        $sql = "SELECT (amount-paid) amount_to_paid
                    FROM (
                    SELECT IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid
                    FROM sale s LEFT JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                    WHERE id=:sale_id   
                    AND s.status IS NULL
                    ) AS t";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => (int) $sale_id));

        foreach ($result as $record) {
            $amount = $record['amount_to_paid'];
        }

        return $amount;
    }

    public function currentBalance($client_id)
    {
        if (isset($this->sale_id)) {
            $sql = "SELECT SUM(IFNULL(balance,0)) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.sale_id=s.id
                        WHERE s.id=:sale_id 
                        and client_id=:client_id
                        AND s.status IS NULL
                        ";
            $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => (int) $this->sale_id, ':client_id' => (int) $client_id));
        } else {

            $sql = "SELECT SUM(IFNULL(balance,0)) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.sale_id=s.id
                        WHERE client_id=:client_id
                        AND s.status IS NULL
                        ";
            $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => (int) $client_id));

            $sql = "SELECT SUM(IFNULL(balance,0)) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.sale_id=s.id
                        WHERE s.id=:sale_id 
                        and client_id=:client_id
                        AND s.status IS NULL
                        ";
            $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => (int) $this->sale_id, ':client_id' => (int) $client_id));
        }

        foreach ($result as $record) {
            $amount = $record['balance'];
        }

        return $amount;
    }

    public function clientBalance($client_id)
    {
        $sql = "SELECT sum(balance) amount
                        FROM (
                        SELECT s.id sale_id,s.`sale_time`,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                        FROM sale s INNER JOIN sale_amount sa ON sa.`sale_id`=s.`id`
                                        INNER JOIN `client` c ON c.`id`=s.`client_id`
                                            AND c.id=:client_id
                        WHERE s.status IS NULL                     
                        ) AS t";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => $client_id));

        foreach ($result as $record) {
            $amount = $record['amount'];
        }

        return $amount;
    }

    public function batchPayment($client_id, $paid_amount, $paid_date, $note)
    {
        $sql = "SELECT sale_id,(amount-paid) amount_to_paid
                    FROM (
                    SELECT s.id sale_id,s.`sale_time`,CONCAT_WS(' ',first_name,last_name) client_id,IFNULL(s.`sub_total`,0) amount,IFNULL(sa.`paid`,0) paid,IFNULL(sa.`balance`,0) balance
                    FROM sale s INNER JOIN sale_amount sa ON sa.`sale_id`=s.`id` AND balance>0
                                    INNER JOIN `client` c ON c.`id`=s.`client_id`
                                            AND c.id=:client_id
                    WHERE s.status IS NULL                        
                    ) AS t
                    GROUP BY sale_id
                    ORDER BY sale_time";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => $client_id));

        foreach ($result as $record) {
            $sale_amount = SaleAmount::model()->find('sale_id=:sale_id', array(':sale_id' => $record["sale_id"]));
            $transaction = Yii::app()->db->beginTransaction();
            try {

                if ($paid_amount <= $record["amount_to_paid"]) {
                    $payment_amount = $paid_amount;
                    $sale_amount->paid = $sale_amount->paid + $paid_amount;
                    $sale_amount->balance = $sale_amount->total - ($sale_amount->paid);
                    $sale_amount->save();

                    $sale_payment = new SalePayment;
                    $sale_payment->sale_id = $record["sale_id"];
                    $sale_payment->payment_type = 'Cash';
                    $sale_payment->payment_amount = $payment_amount;
                    $sale_payment->date_paid = $paid_date;
                    $sale_payment->note = $note;
                    $sale_payment->save();

                    $transaction->commit();
                    break;
                } else {
                    $sale_amount->paid = $sale_amount->paid + $record["amount_to_paid"];
                    $sale_amount->balance = $sale_amount->total - ($sale_amount->paid);
                    $sale_amount->save();
                    $paid_amount = $paid_amount - $record["amount_to_paid"];
                    $payment_amount = $record["amount_to_paid"];

                    $sale_payment = new SalePayment;
                    $sale_payment->sale_id = $record["sale_id"];
                    $sale_payment->payment_type = 'Cash';
                    $sale_payment->payment_amount = $payment_amount;
                    $sale_payment->date_paid = $paid_date;
                    $sale_payment->note = $note;
                    $sale_payment->save();
                    $transaction->commit();
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return $e->getMessage();
            }
        }
    }

    public function datePaid($sale_id)
    {

        $sql = "SELECT date_format(t1.date_paid,'%d-%m-%Y %H:%i') date_paid
                  FROM sale_payment t1 INNER JOIN (
                            SELECT MAX(date_paid) date_paid FROM sale_payment WHERE sale_id=:sale_id) t2
                           ON t1.`date_paid`=t2.date_paid
                  WHERE sale_id=:sale_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => $sale_id));

        if ($result) {
            foreach ($result as $record) {
                $string = $record['date_paid'];
            }
            return $string;
        } else {
            return 'N/A';
        }
    }

    public function paymentNote($sale_id)
    {

        $sql = "SELECT t1.`note`
                  FROM sale_payment t1 INNER JOIN (
                            SELECT MAX(date_paid) date_paid FROM sale_payment WHERE sale_id=:sale_id) t2
                           ON t1.`date_paid`=t2.date_paid
                  WHERE sale_id=:sale_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => $sale_id));

        if ($result) {
            foreach ($result as $record) {
                $string = $record['note'];
            }
            return $string;
        } else {
            return 'N/A';
        }
    }

    public function ListSuspendSale()
    {

        $sql = "SELECT s.id sale_id,
                            (SELECT CONCAT_WS(' ',first_name,last_name) FROM `client` c WHERE c.id=s.client_id) client_id,
                            DATE_FORMAT(s.sale_time,'%d-%m-%Y %H:%i') sale_time,st.items,remark
                    FROM sale s INNER JOIN (SELECT si.sale_id, GROUP_CONCAT(i.name) items
                                            FROM sale_item si INNER JOIN item i ON i.id=si.item_id 
                                            GROUP BY si.sale_id
                                            ) st ON st.sale_id=s.id
                  WHERE status='2'                           
                 ";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    /* List all Same Item by Sale ID */

    public function getSaleItem($sale_id)
    {
        $model = SaleItem::model()->findAll('sale_id=:saleId', array(':saleId' => $sale_id));
        return $model;
    }

}
