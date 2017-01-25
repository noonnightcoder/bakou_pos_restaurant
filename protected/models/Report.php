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
 *
 * The followings are the available model relations:
 * @property SaleItem[] $saleItems
 */
class Report extends CFormModel
{

    public $search;
    public $amount;
    public $quantity;
    public $from_date;
    public $to_date;
    public $sale_id;
    public $receive_id;
    public $employee_id;
    public $search_id;
    public $category_id;
    public $location_id;

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
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('sale_time', 'required'),
            array('client_id, employee_id, location_id', 'numerical', 'integerOnly' => true),
            array('sub_total', 'numerical'),
            array('status', 'length', 'max' => 25),
            array('payment_type', 'length', 'max' => 255),
            array(
                'sale_time',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => true,
                'on' => 'insert'
            ),
            array('remark, sale_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, sale_time, client_id, employee_id, location_id, sub_total, payment_type,status, remark',
                'safe',
                'on' => 'search'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'date' => Yii::t('app', 'date'),
        );
    }

    public function saleInvoice()
    {
        if ($this->search_id !== '') {

            $sql = "SELECT sale_id,sale_time,employee_name,employee_id,client_id,location_name_kh,
                      0 quantity,sub_total,discount_amount,vat_amount,total,status,status_f,desk_name,deleted_at
                    FROM v_sale_meta
                    WHERE (sale_id=:search_id AND location_id=:location_id )
                    -- OR (c_first_name like :first_name OR c_last_name like :last_name OR client_name like :full_name )
                    ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                    //':first_name' => '%' . $this->search_id . '%',
                    //':last_name' => '%' . $this->search_id . '%',
                    //':full_name' => '%' . $this->search_id . '%',
                    ':location_id' => $this->location_id
                )
            );

        } else {

            $sql = "SELECT sale_id,sale_time,employee_name,employee_id,client_id,location_name_kh,
                      0 quantity,sub_total,discount_amount,vat_amount,total,status,status_f,desk_name,deleted_at
                    FROM v_sale_meta
                    WHERE location_id=:location_id
                    AND sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                    AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                    ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':from_date' => $this->from_date,
                ':to_date' => $this->to_date,
                ':location_id' => $this->location_id //Common::getCurLocationID(),
            ));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider;
    }

    public function saleInvoiceDetail()
    {
        $sql= "SELECT sale_id,item_id,name,quantity,price,description,sub_total,deleted_at
               FROM v_sale_item
               WHERE sale_id=:sale_id
               AND location_id=:location_id";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => $this->sale_id, ':location_id' => Common::getCurLocationID()));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDaily()
    {
        if ($this->location_id =='') {
            $sql = "SELECT DATE_FORMAT(s.sale_time,'%d-%m-%Y') date_report,SUM(s.sub_total) sub_total,
                    SUM(s.discount_amount) discount_amount,
	                SUM(s.sub_total-s.discount_amount) total,SUM(sm.quantity) quantity
                  FROM v_sale s, v_sale_item_sum sm
                  WHERE s.id=sm.sale_id
                  AND s.location_id=sm.location_id
                  AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
                  AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                  AND s.status=:status
                  GROUP BY date_format(s.sale_time,'%d-%m-%Y')
                  WITH ROLLUP";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':from_date' => $this->from_date,
                ':to_date' => $this->to_date,
                ':status' => Yii::app()->params['sale_complete_status']
            ));
        } else {
            $sql = "SELECT DATE_FORMAT(s.sale_time,'%d-%m-%Y') date_report,SUM(s.sub_total) sub_total,
                    SUM(s.discount_amount) discount_amount,
	                SUM(s.sub_total-s.discount_amount) total,SUM(sm.quantity) quantity
                  FROM v_sale s, v_sale_item_sum sm
                  WHERE s.id=sm.sale_id
                  AND s.location_id=sm.location_id
                  AND s.location_Id=:location_id
                  AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
                  AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                  AND s.status=:status
                  GROUP BY date_format(s.sale_time,'%d-%m-%Y')
                  WITH ROLLUP";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':from_date' => $this->from_date,
                ':to_date' => $this->to_date,
                ':status' => Yii::app()->params['sale_complete_status'],
                ':location_id' => $this->location_id
            ));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'date_report',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleItemSummary()
    {

        $sql = "SELECT i.name item_name,CONCAT_WS(' - ',:from_date, :to_date) date_report,sub_total,t1.quantity
            FROM (
            SELECT sm.item_id,
                   -- MIN(DATE_FORMAT(s.sale_time,'%d-%m-%Y')) from_date, MAX(DATE_FORMAT(s.sale_time,'%d-%m-%Y')) to_date,
                   SUM(sm.quantity) quantity,SUM(sm.price*quantity) sub_total
            FROM v_sale s , sale_item sm
            WHERE s.id=sm.sale_id
            AND s.location_id=sm.location_id
            AND s.sale_time>=str_to_date(:from_date,'%d-%m-%Y')  
            AND s.sale_time<date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY) 
            AND s.status=:status
            GROUP BY sm.item_id
            ) t1 JOIN item i ON i.id=t1.item_id";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':from_date' => $this->from_date,
            ':to_date' => $this->to_date,
            ':status' => Yii::app()->params['sale_complete_status']
        ));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'item_name',
            'sort' => array(
                'attributes' => array(
                    'date_report',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function userLogSummary()
    {
        $sql = "SELECT ul.`employee_id`,
                UCASE(CONCAT(e.`first_name`,' ',e.`last_name`)) fullname,
                DATE_FORMAT(`login_time`,'%d-%m-%Y') date_log,
                COUNT(*) nlog
            FROM `user_log` ul , employee e
            WHERE ul.`employee_id`=e.`id`
            AND ul.login_time>=str_to_date(:from_date,'%d-%m-%Y')  
            AND ul.login_time<date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
            GROUP BY ul.`employee_id`,CONCAT(e.`first_name`,' ',e.`last_name`),DATE_FORMAT(`login_time`,'%d-%m-%Y')";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':from_date' => $this->from_date,
            ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'employee_id',
            'sort' => array(
                'attributes' => array(
                    'date_log',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    /*
    public function receiveInvoice()
    {

        if (isset($this->receive_id)) {

            $sql = "SELECT s.id,
                    DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i') receive_time,
                    SUM(sub_total) sub_total,SUM(quantity) quantity,`status`,remark,
                    (SELECT CONCAT_WS(' ',first_name,last_name) FROM employee e WHERE e.id=s.employee_id) employee_id
               FROM v_receiving s , v_receiving_item_sum si 
               WHERE si.`receive_id`=s.id 
               AND s.id=:receive_id
               GROUP BY s.id,DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i'),`status`,remark
               ";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':receive_id' => $this->receive_id));
        } else {

            $sql = "SELECT s.id,
                    DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i') receive_time,
                    SUM(sub_total) sub_total,SUM(quantity) quantity,`status`,remark,
                    (SELECT CONCAT_WS(' ',first_name,last_name) FROM employee e WHERE e.id=s.employee_id) employee_id
               FROM v_receiving s , v_receiving_item_sum si 
               WHERE si.`receive_id`=s.id 
               AND s.receive_time>=str_to_date(:from_date,'%d-%m-%Y') 
               AND s.receive_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               GROUP BY s.id,DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i'),`status`,remark
               ";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,
                array(':from_date' => $this->from_date, ':to_date' => $this->to_date));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'receive_time',
                    'sub_total',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function topProduct()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,sum(si.quantity) qty,SUM(price*quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id
                     AND sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                     AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                     AND IFNULL(s.status,'1')='1'
                GROUP BY item_name
                ORDER BY qty DESC LIMIT 5
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleHourly()
    {
        $sql = "SELECT DATE_FORMAT(s.`sale_time`,'%H') hours,sum(quantity) qty,
                  sum(case 
                    when si.discount_type='%' then (quantity*price-(quantity*price*si.discount_amount)/100) 
                    else (quantity*price)-si.discount_amount
                  end) amount  
                  FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id AND IFNULL(s.status,'1')='1'
                            AND DATE_FORMAT(sale_time,'%d-%m-%Y')=str_to_date(:to_date,'%d-%m-%Y')
                  GROUP BY DATE_FORMAT(s.`sale_time`,'%H')";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'hours',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleHourlyTotalAmount()
    {
        $sql = "SELECT sum(case 
                                when si.discount_type='%' then (quantity*price-(quantity*price*si.discount_amount)/100) 
                                else (quantity*price)-si.discount_amount
                         end) amount
                  FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id AND IFNULL(s.status,'1')='1'
                  AND DATE_FORMAT(sale_time,'%d-%m-%Y')=str_to_date(:to_date,'%d-%m-%Y')
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':to_date' => $this->to_date));

        foreach ($result as $record) {
            $amount = $record['amount'];
        }

        return $amount;
    }

    public function saleHourlyTotalQty()
    {
        $sql = "SELECT sum(quantity) qty
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id  AND IFNULL(s.status,'1')='1'
                AND DATE_FORMAT(sale_time,'%d-%m-%Y')=str_to_date(:to_date,'%d-%m-%Y')";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':to_date' => $this->to_date));

        foreach ($result as $record) {
            $qty = $record['qty'];
        }

        return $qty;
    }

    public function saleSummary()
    {

        $sql = "SELECT COUNT(id) no_of_invoice,SUM(sm.quantity) quantity,SUM(s.sub_total) sub_total,SUM(s.discount_amount) discount_amount,SUM(s.sub_total-s.discount_amount) total
                FROM v_sale s , v_sale_item_sum sm
                WHERE s.id=sm.sale_id	
                AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
                AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':from_date' => $this->from_date,
            ':to_date' => $this->to_date,
            ':status' => Yii::app()->params['sale_complete_status']
        ));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'no_of_invoice',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDailyProfit()
    {

        $sql = "SELECT date_report,sub_total,profit,format((profit/sub_total)*100,2) margin
              FROM (
                SELECT DATE_FORMAT(s.`sale_time`,'%d-%m-%Y') date_report,
                  SUM(s.sub_total) sub_total,SUM(sm.profit) profit
                FROM v_sale s , v_sale_item_sum sm
                WHERE s.id=sm.sale_id 
                AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
                AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status
                GROUP BY DATE_FORMAT(s.`sale_time`,'%d-%m-%Y')
             ) as t";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':from_date' => $this->from_date,
            ':to_date' => $this->to_date,
            ':status' => Yii::app()->params['_active_status']
        ));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'date_report',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDailyProfitTotals()
    {
        $sub_total = 0;
        $total = 0;
        $profit = 0;

        $sql = "SELECT SUM(s.sub_total) sub_total,SUM(s.sub_total-s.discount_amount) total,SUM(sm.profit) profit
               FROM v_sale s , v_sale_item_sum sm
               WHERE s.id=sm.sale_id 
               AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
               AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND s.status=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':from_date' => $this->from_date,
            ':to_date' => $this->to_date,
            ':status' => Yii::app()->params['_active_status']
        ));

        foreach ($result as $record) {
            $sub_total = $record['sub_total'];
            $total = $record['total'];
            $profit = $record['profit'];
        }

        return array($sub_total, $total, $profit);
    }

    public function saleMonthlyProfit()
    {
        $sql = "SELECT DATE_FORMAT(s.`sale_time`,'%m-%Y') date_report,
	       SUM(s.sub_total) sub_total,SUM(sm.profit) profit,
               SUM(format((profit/sub_total)*100,2)) margin
            FROM v_sale s , v_sale_item_sum sm
            WHERE s.id=sm.sale_id 
            -- AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
            -- AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
            AND s.status=:status
            GROUP BY DATE_FORMAT(s.`sale_time`,'%m-%Y')";


        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':status' => Yii::app()->params['_active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'date_report',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleMonthlyProfitTotals()
    {
        $sql = "SELECT SUM(s.sub_total) sub_total,SUM(s.sub_total-s.discount_amount) total,SUM(sm.profit) profit,SUM(format((profit/sub_total)*100,2))  margin
               FROM v_sale s , v_sale_item_sum sm
               WHERE s.id=sm.sale_id 
               AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
               AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND s.status=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':status' => Yii::app()->params['_active_status']));

        foreach ($result as $record) {
            $sub_total = $record['sub_total'];
            $total = $record['total'];
            $profit = $record['profit'];
            $margin = $record['margin'];
        }

        return array($sub_total, $total, $profit, $margin);
    }

    public function payment()
    {

        $sql = "SELECT payment_type,COUNT(*) quantity,SUM(payment_amount) amount
                FROM sale_payment	
                WHERE sale_id IN (SELECT id FROM sale  WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY))
                GROUP BY payment_type";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'payment_type',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function paymentTotalAmount()
    {
        $sql = "SELECT SUM(payment_amount) amount
                  FROM sale_payment	
                  WHERE sale_id IN (SELECT id FROM sale  WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                  AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY))
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        foreach ($result as $record) {
            $amount = $record['amount'];
        }

        return $amount;
    }

    public function paymentTotalQty()
    {
        $sql = "SELECT COUNT(*) qty
                  FROM sale_payment	
                  WHERE sale_id IN (SELECT id FROM sale  WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                  AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY))
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        foreach ($result as $record) {
            $qty = $record['qty'];
        }

        return $qty;
    }

    public function inventory($filter)
    {
        switch ($filter) {
            case 'all':
                $condition = '';
                break;
            case 'low':
                $condition = 'WHERE IFNULL(reorder_level,0)>quantity';
                break;
            case 'outstock':
                $condition = 'WHERE quantity=0';
                break;
            case 'onstock':
                $condition = 'WHERE quantity>0';
                break;
            case 'negative':
                $condition = 'WHERE quantity<0';
                break;
        }

        $sql = "SELECT id,name,
                        (select company_name from supplier s where s.id=i.supplier_id) supplier,
                        unit_price,quantity,cost_price,reorder_level
               FROM item i 
               $condition 
               ORDER BY name";

        $sql = "SELECT id,name,quantity,cost_price,unit_price,reorder_level,GROUP_CONCAT(DISTINCT t2.company_name) supplier
            FROM item t1 LEFT JOIN (
                    SELECT `supplier_id`,`item_id`,s.`company_name`,s.`first_name`,s.`last_name`
                    FROM (
                    SELECT r.`supplier_id`,ri.`item_id`
                    FROM `receiving` r JOIN `receiving_item` ri ON ri.`receive_id`=r.id
                    WHERE r.`supplier_id` IS NOT NULL ) t1 JOIN supplier s ON s.id=t1.supplier_id
                    ) t2 ON t2.item_id=t1.id
            $condition         
            GROUP BY id,NAME,quantity,cost_price,reorder_level";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'quantity',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function itemExpiry($filter)
    {

        $sql = "SELECT receiving_id,received,name,quantity,month_expire,n_month_expire
                  FROM (
                    SELECT ie.`receiving_id`,
                            (SELECT receive_time FROM receiving r WHERE r.id=ie.receiving_id) received,
                            i.`name`,
                            i.`quantity`,
                            ie.`expire_date`,EXTRACT(YEAR_MONTH  FROM ie.expire_date) month_expire,
                            PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM ie.expire_date),EXTRACT(YEAR_MONTH FROM CURRENT_DATE())) n_month_expire
                     FROM `item_expire` ie  INNER JOIN item i ON ie.`item_id`=i.`id`
                     where ie.expire_date>='2013-01-01'
                    ) AS t1
                 WHERE n_month_expire<=:month_to_expire
                 ORDER BY name";

        $sql = "SELECT name,quantity,expire_date,n_month_expire
                  FROM (
                    SELECT i.`name`,
                            i.`quantity`,
                            DATE_FORMAT(ie.`expire_date`,'%d-%m-%Y') expire_date,
                            PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM ie.expire_date),EXTRACT(YEAR_MONTH FROM CURRENT_DATE())) n_month_expire
                     FROM `item_expire` ie  INNER JOIN item i ON ie.`item_id`=i.`id`
                    ) AS t1
                 WHERE n_month_expire<=:month_to_expire
                 ORDER BY name";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $filter));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'name',
            'sort' => array(
                'attributes' => array(
                    'name',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function itemExpiryCount($moth_to_expire)
    {
        $sql = "SELECT count(*) nitem,ifnull(sum(quantity),0) qty
                  FROM (
                    SELECT ie.`receiving_id`,
                            (SELECT receive_time FROM receiving r WHERE r.id=ie.receiving_id) received,
                            i.`name`,
                            i.`quantity`,
                            ie.`expire_date`,EXTRACT(YEAR_MONTH  FROM ie.expire_date) month_expire,
                            PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM ie.expire_date),EXTRACT(YEAR_MONTH FROM CURRENT_DATE())) n_month_expire
                     FROM `item_expire` ie  INNER JOIN item i ON ie.`item_id`=i.`id`
                    ) AS t1
                 WHERE n_month_expire=:month_to_expire";
        //GROUP BY month_expire,n_month_expire";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $moth_to_expire));

        foreach ($result as $record) {
            $result = array($record['nitem'], $record['qty']);
        }

        return $result;
    }

    public function itemAsset()
    {
        $sql = "SELECT SUM(quantity) total_qty,SUM(cost_price*quantity) total_amount
                  FROM item
                  WHERE quantity>0";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'total_qty',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function itemInactive($filter)
    {

        if ($filter == 1) {
            $con = 'between 3 and 6';
        } elseif ($filter == 2) {
            $con = 'between 7 and 12';
        } elseif ($filter == 3) {
            $con = '>=12';
        }

        $sql = "SELECT PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM CURRENT_DATE()),EXTRACT(YEAR_MONTH FROM sale_time)) month_diff,
                    sale_time,item_id,name,description,quantity
                 FROM (
                 SELECT s.sale_time,si.item_id,it.name,it.description,it.quantity
                 FROM sale s INNER JOIN sale_item si ON si.`sale_id`=s.id 
                         INNER JOIN item it ON it.id=si.item_id        
                 UNION ALL
                 SELECT created_date sale_tie,id item_id,`name`,description,quantity
                 FROM item
                 WHERE id NOT IN (SELECT DISTINCT item_id FROM sale_item)
                 ) t1
                 WHERE PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM CURRENT_DATE()),EXTRACT(YEAR_MONTH FROM sale_time)) $con
                 ORDER BY NAME";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $filter));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'month_diff',
            'sort' => array(
                'attributes' => array(
                    'name',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    */


}
