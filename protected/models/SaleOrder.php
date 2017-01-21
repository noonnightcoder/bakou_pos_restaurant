<?php

/**
 * This is the model class for table "sale_order".
 *
 * The followings are the available columns in table 'sale_order':
 * @property integer $id
 * @property string $sale_time
 * @property integer $client_id
 * @property integer $desk_id
 * @property integer $zone_id
 * @property integer $group_id
 * @property integer $employee_id
 * @property integer $location_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 * @property string $discount_amount
 * @property string $discount_type
 * @property integer $giftcard_id
 * @property integer $empty_flag
 */
class SaleOrder extends CActiveRecord
{
    private $active_status = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sale_order';
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
            array(
                'client_id, desk_id, zone_id, group_id, employee_id, location_id, giftcard_id, empty_flag',
                'numerical',
                'integerOnly' => true
            ),
            array('sub_total', 'numerical'),
            array('payment_type', 'length', 'max' => 255),
            array('status', 'length', 'max' => 20),
            array('discount_amount', 'length', 'max' => 15),
            array('discount_type', 'length', 'max' => 2),
            array('remark', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, sale_time, client_id, desk_id, zone_id, group_id, employee_id, location_id, sub_total, payment_type, status, remark, discount_amount, discount_type, giftcard_id, empty_flag',
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
        return array();
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
            'group_id' => 'Group',
            'employee_id' => 'Employee',
            'location_id' => 'Location',
            'sub_total' => 'Sub Total',
            'payment_type' => 'Payment Type',
            'status' => 'Status',
            'remark' => 'Remark',
            'discount_amount' => 'Discount Amount',
            'discount_type' => 'Discount Type',
            'giftcard_id' => 'Giftcard',
            'empty_flag' => 'Empty Flag',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SaleOrder the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    //public function getOrderCart($desk_id, $group_id, $location_id)
    public function getOrderCart($sale_id, $location_id)
    {
        $sql = "SELECT item_number,item_id,`name`,quantity,price,discount_amount discount,
                total,client_id,desk_id,zone_id,employee_id,qty_in_stock,topping,item_parent_id,category_id
                FROM v_order_cart
                WHERE sale_id=:sale_id
                AND location_id=:location_id
                AND status=:status
                AND deleted_at is null
                ORDER BY path,modified_date desc";
                //ORDER BY IF(item_parent_id=0, item_id, item_parent_id), item_parent_id!=0, item_id DESC";
                //ORDER BY path,modified_date desc";

        return Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':sale_id' => $sale_id,
                ':location_id' => $location_id,
                ':status' => Yii::app()->params['num_one']
            )
        );
    }

    public function getOrderToKitchen($sale_id, $location_id, $category_id)
    {
        $sql = "SELECT t1.item_number,t1.item_id,t1.`name`,(t1.quantity-IFNULL(t2.`quantity`,0)) quantity,
                t1.price,t1.discount_amount discount,t1.total,t1.client_id,t1.desk_id,t1.zone_id,t1.employee_id,t1.qty_in_stock,t1.topping,t1.item_parent_id
                FROM v_order_cart t1 LEFT JOIN
                        (SELECT t2.sale_id,t2.item_id,t2.item_parent_id ,t2.quantity
                         FROM sale_order_item_print t2 , item t3
                         WHERE t3.id=t2.item_id
                         AND t3.category_id=:category_id
                        ) t2
                    ON t2.sale_id=t1.`sale_id`
                    AND t2.item_id=t1.item_id
                    AND t2.item_parent_id=t1.item_parent_id
                WHERE t1.sale_id=:sale_id and t1.location_id=:location_id
                AND t1.status=:status
                AND (t1.quantity-IFNULL(t2.quantity,0)) > 0
                AND t1.category_id=:category_id
                ORDER BY t1.path,t1.modified_date";

            return Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':sale_id' => $sale_id,
                ':location_id' => $location_id,
                ':category_id' => $category_id,
                ':status' => Yii::app()->params['num_one']
            )
        );
    }

    public function getOrderCartTopping($desk_id, $group_id, $location_id)
    {
        $sql = "SELECT item_id,`name`,quantity,price,discount_amount discount,total,
                client_id,desk_id,zone_id,employee_id,qty_in_stock
                FROM v_order_cart
                WHERE desk_id=:desk_id AND group_id=:group_id and location=:location_id
                AND status=:status
                AND topping=1
                ORDER BY modified_date desc";


        return Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':desk_id' => (int)$desk_id,
            ':group_id' => $group_id,
            ':location_id' => $location_id,
            ':status' => Yii::app()->params['num_one']
        ));
    }

    //public function getAllTotal($desk_id, $group_id, $location_id)
    public function getAllTotal($sale_id, $location_id)
    {
        $quantity = 0;
        $sub_total = 0;
        $total = 0;
        $discount_amount = 0;

        /* Get Sale ID by Desk ID every time we focus on that table */
        $sql = "SELECT s.id sale_id,SUM(so.quantity) quantity,SUM(so.total) sub_total,sum(total) - sum(total)*global_discount total,sum(total)*global_discount discount_amount
                FROM v_sale_order s JOIN v_sale_order_tem_sum so ON so.sale_id = s.id
                WHERE s.id=:sale_id
                AND s.location_id=:location_id
                AND s.status=:status
                GROUP BY s.id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':sale_id' => $sale_id,
            ':location_id' => $location_id,
            ':status' => Yii::app()->params['num_one']
        ));
        if ($result) {
            foreach ($result as $record) {
                $quantity = $record['quantity'];
                $sub_total = $record['sub_total'];
                $total = $record['total'];
                $discount_amount = $record['discount_amount'];
            }
        }

        return array($quantity, $sub_total, $total, $discount_amount);
    }

    public function orderAdd($item_id, $table_id, $group_id, $client_id, $employee_id, $quantity, $price_tier_id, $item_parent_id, $location_id)
    {

        $sql = "SELECT func_order_add(:item_id,:item_number,:desk_id,:group_id,:client_id,:employee_id,:quantity,:price_tier_id,:item_parent_id,:location_id) item_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':item_id' => $item_id,
                ':item_number' => $item_id,
                ':desk_id' => $table_id,
                ':group_id' => $group_id,
                ':client_id' => $client_id,
                ':employee_id' => $employee_id,
                ':quantity' => $quantity,
                ':price_tier_id' => $price_tier_id,
                ':item_parent_id' => $item_parent_id,
                ':location_id' => $location_id
            )
        );

        foreach ($result as $record) {
            $id = $record['item_id'];
        }

        return $id;
    }

    public function orderEdit($sale_id, $item_id, $quantity, $price, $discount, $item_parent_id)
    {
        //$sql = "CALL proc_edit_menu_order(:desk_id,:group_id,:item_id,:quantity,:price,:discount,:item_parent_id,:location_id)";
        $sql = "SELECT func_order_edit(:sale_id,:item_id,:quantity,:price,:discount,:item_parent_id,:location_id,:employee_id) result_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':sale_id' => $sale_id,
                ':item_id' => $item_id,
                ':quantity' => $quantity,
                ':price' => $price,
                ':discount' => $discount,
                ':item_parent_id' => $item_parent_id,
                ':location_id' => Common::getCurLocationID(),
                ':employee_id' => Common::getEmployeeID()
            )
        );

        foreach ($result as $record) {
            $result_id = $record['result_id'];
        }

        return $result_id;
    }

    public function orderDel($item_id, $item_parent_id, $table_id, $group_id)
    {
        //$sql = "CALL proc_del_item_cart(:item_id,:item_parent_id,:desk_id,:group_id,:location_id)";
        $sql = "SELECT func_order_del(:item_id,:item_parent_id,:desk_id,:group_id, :location_id, :employee_id) result_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':item_id' => $item_id,
                ':item_parent_id' => $item_parent_id,
                ':desk_id' => $table_id,
                ':group_id' => $group_id,
                ':location_id' => Common::getCurLocationID(),
                ':employee_id' => Common::getEmployeeID()
            )
        );

        foreach ($result as $record) {
            $result_id = $record['result_id'];
        }

        return $result_id;
    }

    public function orderSave($desk_id,$group_id,$payment_total)
    {
        $sql="SELECT func_order_save(:desk_id,:group_id,:location_id,:payment_total,:employee_id) sale_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':desk_id' => $desk_id,
                ':group_id' => $group_id,
                ':location_id' => Common::getCurLocationID(),
                ':payment_total' => $payment_total,
                ':employee_id' => Common::getEmployeeID()
            )
        );

        foreach ($result as $record) {
            $sale_id = $record['sale_id'];
        }

        return $sale_id;

    }

    public function cancelOrderMenu($desk_id, $group_id, $location_id)
    {
        $sql = "delete from sale_order where desk_id=:desk_id and group_id=:group_id and location_id=:location_id ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":desk_id", $desk_id, PDO::PARAM_INT);
        $command->bindParam(":group_id", $group_id, PDO::PARAM_INT);
        $command->bindParam(":location_id", $location_id, PDO::PARAM_INT);
        $command->execute();
    }

    public function changeTable($desk_id, $new_desk_id, $group_id, $location_id, $price_tier_id, $employee_id)
    {
        $sql = "SELECT func_change_table(:desk_id,:new_desk_id,:group_id,:location_id,:price_tier_id,:employee_id) group_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':desk_id' => $desk_id,
                ':new_desk_id' => $new_desk_id,
                ':group_id' => $group_id,
                ':location_id' => $location_id,
                ':price_tier_id' => $price_tier_id,
                ':employee_id' => $employee_id
            )
        );

        foreach ($result as $record) {
            $group_id = $record['group_id'];
        }

        return $group_id;
    }

    public function savePrintedToKitchen($sale_id, $location_id, $category_id,$employee_id)
    {
        $sql = "select func_save_pkitchen(:sale_id,:location_id,:category_id,:employee_id) result_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':sale_id' => $sale_id,
                ':location_id' => $location_id,
                ':category_id' => $category_id,
                ':employee_id' => $employee_id
            )
        );

        foreach ($result as $record) {
            $id = $record['result_id'];
        }

        return $id;
    }

    /*
    public function delOrder($desk_id, $group_id, $location_id)
    {
        $sql = "CALL proc_del_sale_order(:desk_id,:group_id,:location_id)";
        Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':desk_id' => $desk_id,
                ':group_id' => $group_id,
                ':location_id' => $location_id
            )
        );
    }
    */

    public function setDisGiftcard($sale_id, $location_id,$giftcard_id)
    {

        /*
        $model = Giftcard::model()->findByPk($giftcard_id);

        if (!$model) {
            $model = Giftcard::model()->find('giftcard_number=:giftcard_number',
                array(':giftcard_number' => $giftcard_id));
        }

        if (!$model) {
            return false;
        }

        $discount_amount = $model->discount_amount;
        $giftcard_id = $model->id;

        $sql = "update sale_order
                set giftcard_id=:giftcard_id,discount_amount=:discount_amount
                where desk_id=:desk_id and group_id=:group_id and location_id=:location_id
                and status=:status";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":desk_id", $desk_id, PDO::PARAM_INT);
        $command->bindParam(":group_id", $group_id, PDO::PARAM_INT);
        $command->bindParam(":location_id", $location_id, PDO::PARAM_INT);
        $command->bindParam(":giftcard_id", $giftcard_id, PDO::PARAM_INT);
        $command->bindParam(":discount_amount", $discount_amount);
        $command->bindParam(":status", Yii::app()->params['num_one']);
        $command->execute();

        return true;
        */

        $sql = "SELECT func_set_giftcard(:sale_id,:location_id,:giftcard_id) result_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':sale_id' => $sale_id,
                ':location_id' => $location_id,
                ':giftcard_id' => $giftcard_id
            )
        );

        foreach ($result as $record) {
            $result_id = $record['result_id'];
        }

        return $result_id;

    }

    public function clearDisGiftcard($sale_id, $location_id)
    {
        /*$sql = "update sale_order
                set giftcard_id=null,discount_amount=null
                  where desk_id=:desk_id and group_id=:group_id
                  and location_id=:location_id
                  and status=:status";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":desk_id", $desk_id, PDO::PARAM_INT);
        $command->bindParam(":group_id", $group_id, PDO::PARAM_INT);
        $command->bindParam(":location_id", $location_id, PDO::PARAM_INT);
        $command->bindParam(":status", Yii::app()->params['num_one']);
        $command->execute();*/

        $sql = "SELECT func_clear_giftcard(:sale_id,:location_id) result_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(
                ':sale_id' => $sale_id,
                ':location_id' => $location_id,
            )
        );

        foreach ($result as $record) {
            $result_id = $record['result_id'];
        }

        return $result_id;
    }

    public function getDisGiftcard($desk_id, $group_id, $location_id)
    {
        $sql = "SELECT giftcard_id
                FROM sale_order
                WHERE desk_id=:desk_id AND group_id=:group_id
                AND location_id=:location_id
                and status=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':desk_id' => $desk_id,
            ':group_id' => $group_id,
            ':location_id' => $location_id,
            ':status' => Yii::app()->params['num_one']
        ));

        if ($result) {
            foreach ($result as $record) {
                $giftcard_id = $record['giftcard_id'];
            }
        } else {
            $giftcard_id = 0;
        }

        return $giftcard_id;
    }

    public function countNewOrder()
    {
        $sql = "SELECT COUNT(*) count_order
                FROM sale_order
                WHERE location_id = :location_id
                and sale_time >= CURDATE()
                AND `status`=:status
                AND temp_status <> :str_zero
                AND employee_id <> :employee_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':location_id' => Yii::app()->getsetSession->getLocationId(),
            ':status' => Yii::app()->params['num_one'],
            ':str_zero' => Yii::app()->params['str_zero'],
            ':employee_id' => Yii::app()->session['employeeid']
        ));

        if ($result) {
            foreach ($result as $record) {
                $count_order = $record['count_order'];
            }
        } else {
            $count_order = 0;
        }

        return $count_order;
    }

    public function newOrdering()
    {
        $sql="SELECT so.desk_id,d.`name` desk_name, concat(hour(so.sale_time), ':',minute(so.sale_time)) sale_time
                FROM sale_order so JOIN desk d ON d.id = so.desk_id
                WHERE so.location_id = :location_id
                AND so.sale_time >= CURDATE()
                AND so.`status`=:status
                AND temp_status <> :str_zero
                AND employee_id <> :employee_id
                ORDER BY so.sale_time desc";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':location_id' => Common::getCurLocationID(),
            ':status' => Yii::app()->params['num_one'],
            ':str_zero' => Yii::app()->params['str_zero'],
            ':employee_id' => Common::getEmployeeID()
        ));

        return $result;
    }

    /*
    public function getSaleOrderByDeskId()
    {
        $sale_order = SaleOrder::model()->find('desk_id=:desk_id and group_id=:group_id and location_id=:location_id and status=:status',
            array(
                ':desk_id' => Yii::app()->orderingCart->getTableId(),
                ':group_id' => Yii::app()->orderingCart->getGroupId(),
                ':location_id' => Yii::app()->getsetSession->getLocationId(),
                ':status' => Yii::app()->params['num_one']
            ));

        return isset($sale_order) ? $sale_order : null;
    }
    */

    public function getSaleOrderById($sale_id,$location_id)
    {
        $sale_order = SaleOrder::model()->find('id=:sale_id and location_id=:location_id and status=:status',
            array(
                ':sale_id' => $sale_id,
                ':location_id' => $location_id,
                ':status' => Yii::app()->params['num_one']
            ));

        return isset($sale_order) ? $sale_order : null;
    }

    public function updateSaleOrderTempStatus($status)
    {
        $model = $this->getSaleOrderByDeskId();
        if ($model !== null) {
            $model->temp_status = $status;
            $model->save();
        }
    }

}
