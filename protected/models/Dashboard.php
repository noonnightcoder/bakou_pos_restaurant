<?php

class Dashboard extends CFormModel
{

    public function grossSaleAmount($interval=0)
    {
        $sql="SELECT SUM(amount) amount,SUM(lastweek_amount) lastweek_amount, FORMAT((SUM(amount) - SUM(lastweek_amount))/SUM(lastweek_amount)*100,0) diff_percent
                FROM (
                SELECT SUM(t2.sub_total) amount,0 lastweek_amount
                FROM `v_sale_order` t1 JOIN `v_sale_order_tem_sum` t2
                    ON t2.sale_id = t1.id
                WHERE t1.location_id=:location_id
                AND DATE(t1.`sale_time`)= CURDATE() - :interval
                UNION ALL
                SELECT 0 amount,SUM(sub_total) lastweek_amount
                FROM v_sale_order t1
                WHERE location_id=:location_id
                AND DATE(t1.`sale_time`)=CURDATE()-7 - :interval
                AND `status`=0
                ) AS t2";

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':location_id' => Common::getCurLocationID(),
                ':interval' => $interval,
            )
        );
    }

    public function saleInvoice2dVsLW($interval=0)
    {
        $sql = "SELECT SUM(amount) amount,SUM(lastweek_amount) lastweek_amount, FORMAT((SUM(amount) - SUM(lastweek_amount))/SUM(lastweek_amount)*100,0) diff_percent
                FROM (
                 SELECT COUNT(t1.id) amount,0 lastweek_amount
                 FROM v_sale_order t1
                 WHERE location_id=:location_id
                 AND DATE(t1.`sale_time`)=CURDATE()-:interval
                 AND `status`=0
                 UNION ALL
                 SELECT 0 amount, COUNT(t1.id) lastweek_amount
                 FROM v_sale_order t1
                 WHERE location_id=:location_id
                 AND DATE(t1.`sale_time`)=CURDATE()-7-:interval
                 AND `status`=0
                ) AS t";

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':location_id' => Common::getCurLocationID(),
                ':interval' => $interval,
            )
        );
    }

    public function avgInvoice2dVsLW($interval=0)
    {
       $sql="SELECT SUM(amount) amount,SUM(lastweek_amount) lastweek_amount, FORMAT((SUM(amount) - SUM(lastweek_amount))/SUM(lastweek_amount)*100,0) diff_percent
            FROM (
                SELECT SUM(amount)/COUNT(sale_id) amount, 0 lastweek_amount
                FROM (
                SELECT t2.`sale_id`,SUM(t2.`price`*t2.`quantity`) amount
                FROM sale_order t1 JOIN sale_order_item t2 ON t2.`sale_id`=t1.`id`
                WHERE t1.`location_id`=:location_id
                AND DATE(t1.`sale_time`)= CURDATE()-:interval
                GROUP BY t2.`sale_id`
                ) AS t1
                UNION ALL
                SELECT 0 amount,SUM(sub_total)/COUNT(id) lastweek_amount
                FROM sale_order t1
                WHERE t1.`location_id`=:location_id
                AND t1.status=0
                AND DATE(t1.`sale_time`)= CURDATE()-7-:interval
            ) AS t1";

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':location_id' => Common::getCurLocationID(),
                ':interval' => $interval,
            )
        );
    }

    public function ordering($interval=0,$status=1)
    {
        $sql="SELECT COUNT(id) amount,0 lastweek_amount
              FROM sale_order t1
              WHERE location_id=:location_id
              AND `status`=:status
              AND DATE(t1.`sale_time`)= CURDATE()-:interval";

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':location_id' => Common::getCurLocationID(),
                ':interval' => $interval,
                ':status' => $status
            )
        );
    }

    public function saleDailyChart()
    {

        $sql = "SELECT date_format(s.sale_time,'%d/%m/%y') date,sum(sub_total) sub_total,sum(sub_total-discount_amount) total
                FROM v_sale s
                WHERE s.location_id =:location_id
                AND ( s.sale_time BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
                AND s.status=:status
                GROUP BY date_format(s.sale_time,'%d/%m/%y')
                ORDER BY 1";

        return Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':status' => Yii::app()->params['sale_complete_status'],
            ':location_id' => Common::getCurLocationID()
        ));
    }

    public function dashtopProduct()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,COUNT(*) qty,SUM(price*quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id
                     AND s.locatoin_id=:locatoin_id
                     AND sale_time BETWEEN DATE_FORMAT(NOW() ,'%Y') AND NOW()
                     AND s.status=:status
                GROUP BY item_name
                ORDER BY qty DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':location_id' => Common::getCurLocationID(),
            ':status' => Yii::app()->params['sale_complete_status']
        ));

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

    public function dashtopProductbyAmount()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,COUNT(*) qty,SUM(price*quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id
                     AND s.locatoin_id=:locatoin_id
                     AND sale_time BETWEEN DATE_FORMAT(NOW() ,'%Y') AND NOW()
                     AND s.status=:status
                GROUP BY item_name
                ORDER BY amount DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':location_id' => Common::getCurLocationID(),
            ':status' => Yii::app()->params['sale_complete_status']
        ));

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

    public function dashtopFood()
    {
        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                    FROM (
                    SELECT i.name item_name,SUM(si.quantity) qty,SUM(si.quantity*si.price) amount
                    FROM sale s , sale_item si , item i
                    WHERE s.id=si.sale_id
                    AND si.item_id=i.id
                    AND YEAR(s.sale_time) = YEAR(NOW())
                    AND s.status='1'
                    AND category_id=9
                    GROUP BY i.name
                    ORDER BY qty DESC LIMIT 10
                    ) t1, (SELECT @ROW := 0) r
                ";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'pagination' => false,
        ));

        return $dataProvider;
    }

    public function dashtopBeverage()
    {
        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                    FROM (
                    SELECT i.name item_name,SUM(si.quantity) qty,SUM(si.quantity*si.price) amount
                    FROM sale s , sale_item si , item i
                    WHERE s.id=si.sale_id
                    AND si.item_id=i.id
                    AND YEAR(s.sale_time) = YEAR(NOW())
                    AND s.status='1'
                    AND category_id=1
                    GROUP BY i.name
                    ORDER BY qty DESC LIMIT 10
                    ) t1, (SELECT @ROW := 0) r
                ";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'pagination' => false,
        ));

        return $dataProvider;
    }

}
