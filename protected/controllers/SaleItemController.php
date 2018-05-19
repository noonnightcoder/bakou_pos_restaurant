<?php

class SaleItemController extends Controller
{
    //public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            array(
                'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE'
            ),
        );
    }

    public function actions()
    {
        return array(
            'REST.'=>'ext.starship.RestfullYii.actions.ERestActionProvider',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions'=>array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE'),
                'users'=>array('*'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('RemoveCustomer', 'SetComment', 'DeleteItem', 'AddItem', 'EditItem', 'EditItemPrice', 'Index', 'IndexPara', 'AddPayment', 'CancelSale', 'CompleteSale', 'Complete', 'SuspendSale', 'DeletePayment', 'SelectCustomer', 'AddCustomer', 'Receipt', 'UnsuspendSale', 'EditSale', 'Receipt', 'Suspend', 'ListSuspendedSale', 'SetPriceTier','SetGDiscount','DeleteSale','SetGroup','PrintKitchen','ReceiptKitchen','PrintCustomer','ReceiptCustomer','ChangeTable','SetDisGiftcard','RemoveGiftcard','MergeTable','Add','SetZone','SetTable','PrintCloseSale','AjaxRefresh','AjaxF5Dropdown','KitchenInvoice','ConfirmOrder'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() 
    {
        $this->reload();
    }
    
    public function actionAdd()
    {
        if (!Yii::app()->user->checkAccess('sale.edit')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }   
        
        if (!Yii::app()->request->isPostRequest && !Yii::app()->request->isAjaxRequest ) {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
        
        $data=array();
        $item_id = $_POST['SaleItem']['item_id'];

        if (!Yii::app()->orderingCart->getTableId()) {
            Yii::app()->user->setFlash('warning', Yii::t('app','Please, Select a Table'));
        } else {
            $result_id = Yii::app()->orderingCart->addItem($item_id);
            if ($result_id == 0 )  {
                Yii::app()->user->setFlash('warning', Yii::t('app','Product was not found in the system'));
            }
        }
        $this->reload($data);
    }
    
    public function actionSetZone($zone_id) 
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->orderingCart->clearTableId(); //Clear previous table ID during moving around zone
            Yii::app()->orderingCart->setZoneId($zone_id); 
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    
    public function actionSetTable($table_id) 
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->orderingCart->setTableId($table_id); 
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionIndexPara($item_id,$item_parent_id)
    {
        if (Yii::app()->user->checkAccess('sale.edit')) {
            Yii::app()->orderingCart->addItem($item_id,1,$item_parent_id);
            $this->reload();
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionDeleteItem($item_id,$item_parent_id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->orderingCart->deleteItem($item_id,$item_parent_id);
            if (Yii::app()->request->isAjaxRequest) {
                $this->reload();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }    
    }

    public function actionEditItem($item_id,$item_parent_id)
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            
            $data= array();
            $model = new SaleItem;
            $quantity = isset($_POST['SaleItem']['quantity']) ? $_POST['SaleItem']['quantity'] : null;
            $price =isset($_POST['SaleItem']['price']) ? $_POST['SaleItem']['price'] : null;
            $discount =isset($_POST['SaleItem']['discount']) ? $_POST['SaleItem']['discount'] : null;
   
            $model->quantity=$quantity;
            
            if ($model->validate()) {
                Yii::app()->orderingCart->editItem($item_id, $quantity, $discount, $price, $item_parent_id,Common::getCurLocationID());
            } else {
                $error=CActiveForm::validate($model);
                $errors = explode(":", $error);
                $data['warning']=  str_replace("}","",$errors[1]);
                Yii::app()->user->setFlash('warning',  str_replace("}","",$errors[1]));
            }
            $this->reload($data);
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAddPayment()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $data= array();
            
            // To ensure the current serving table had not been printed or completed by someone else
            $data['items'] = Yii::app()->orderingCart->getCart();
            
            if (count($data['items']) == 0) {
                $data['warning'] = Yii::t('app','The serving table had been printed or changed.');
            } else if ("" == trim($_POST['payment_amount']) ) {
                $data['warning']=Yii::t('app',"Please enter value in payment amount");
            } else {
                $payment_id = $_POST['payment_id'];
                $payment_amount = $_POST['payment_amount'];
                Yii::app()->orderingCart->addPayment($payment_id, $payment_amount);
            }
            $this->reload($data);
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDeletePayment($payment_id)
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            Yii::app()->orderingCart->deletePayment($payment_id);
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionSelectCustomer()
    {
        $customer_id = $_POST['customer_id'];
        Yii::app()->orderingCart->setCustomer($customer_id);

        if (Yii::app()->orderingCart->getSaleCookie() == '1') {
            Yii::app()->orderingCart->saleClientCookie((int) $customer_id);
        }
        //$this->redirect('index');
        $this->reload();
    }

    public function actionRemoveCustomer()
    {
        //Yii::app()->clientScript->scriptMap['*.css'] = false;
        Yii::app()->orderingCart->removeCustomer();
        $this->reload();
    }

    public function actionSetComment()
    {
        Yii::app()->orderingCart->setComment($_POST['comment']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }
    
    public function actionSetGDiscount()
    {
        /*if (!Yii::app()->user->checkAccess('sale.discount')) {
            Yii::app()->user->setFlash('danger', Yii::t('app','You are not authorized to perform this action'));
        }*/

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $giftcard_id = $_POST['SaleItem']['giftcard_id'];
            $model = Giftcard::model()->findByPk($giftcard_id);
            Yii::app()->orderingCart->setGDiscount($model->discount_amount);
            $this->reload();
        }
    }
    
    public function actionSetDisGiftcard()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            
            $giftcard_id = $_POST['SaleItem']['giftcard_id'];
            $data= array();
            
            $data['items'] = Yii::app()->orderingCart->getCart();

            if (count($data['items']) == 0) {
                $data['warning'] = Yii::t('app','The serving table had been printed or changed.');
                Yii::app()->user->setFlash('info', Yii::t('app','The serving table had been printed or changed.'));
            } 
            
            if(Yii::app()->orderingCart->SetDisGiftcard($giftcard_id)==0) {
                Yii::app()->user->setFlash('info', Yii::t('app','Unable to add Gift Card, please review your card number/ expiry date again'));
            }
            
            $this->reload($data);
        }
    }
    
    public function actionRemoveGiftcard()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $data['items'] = Yii::app()->orderingCart->getCart();
            if (count($data['items']) == 0) {
                Yii::app()->user->setFlash('info', Yii::t('app','The serving table had been printed or changed.'));
            }
            Yii::app()->orderingCart->clearDisGiftcard();
            $this->reload();
        }
    }

    public function actionSetPriceTier()
    {
        $price_tier_id = $_POST['price_tier_id'];
        Yii::app()->orderingCart->setPriceTier($price_tier_id);
        Yii::app()->orderingCart->f5ItemPriceTier();
        $this->reload();
    }
    
    public function actionSetGroup()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $group_id = $_POST['group_id'];
            Yii::app()->orderingCart->setGroupId($group_id);
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionCancelSale()
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->orderingCart->clearOrderCart();
            $this->reload();
        }
    }
    
    public function actionPrintKitchen($category_id=0)
    {
        $this->layout = '//layouts/column_receipt';
        
        $data=$this->sessionInfo();
        
        if (count($data['items'])==0) {
            $data['warning'] = Yii::t('app','The serving table had been printed or changed.');
            Yii::app()->user->setFlash('warning', "The serving table had been printed or changed.");
            $this->reload($data);
        } else {

            $data['printer'] = $category_id == 9 ?  Yii::app()->getsetSession->getLocationPrinterFood() :  Yii::app()->getsetSession->getLocationPrinterBeverage() ;

            //$data['sale_id'] = Yii::app()->orderingCart->getSaleId();
            $data['items'] = SaleOrder::model()->getOrderToKitchen($data['sale_id'],$data['location_id'],$category_id);
            //Saving printed item to another table "sale_order_item_print"
            SaleOrder::model()->savePrintedToKitchen($data['sale_id'],$data['location_id'],$category_id,$data['employee_id']);

            if (!empty($data['items'])) {
                Yii::app()->session->close();
                //echo CJSON::encode(array('redirect' => Yii::app()->createUrl('/saleItem/KitchenInvoice/',array('category_id'=>$category_id))));
                $this->render('touchscreen/_receipt_kitchen', $data);
            } else {
                Yii::app()->user->setFlash('warning', "All Item has been printed");
                $this->reload($data);
            }
        }
    }

    public function actionKitchenInvoice($category_id)
    {
        $this->layout = '//layouts/column_receipt';
        $data=$this->sessionInfo();
        $data['printer'] = $category_id == 9 ?  Yii::app()->getsetSession->getLocationPrinterFood() :  Yii::app()->getsetSession->getLocationPrinterBeverage();
        $data['sale_id'] = Yii::app()->orderingCart->getSaleId();
        $this->render('partial/_receipt_kitchen', $data);

    }

    public function actionPrintCustomer()
    {
        $this->layout = '//layouts/column_receipt';
        
        $data=$this->sessionInfo();

        //$data['sale_id'] = Yii::app()->orderingCart->getSaleId();
        SaleOrder::model()->updateSaleOrderTempStatus('0');

        if (count($data['items']) == 0) {
            $data['warning'] = Yii::t('app','The serving table had been printed or changed.');
            Yii::app()->user->setFlash('warning', "The serving table had been printed or changed.");
            $this->reload($data);
        } else {
            Yii::app()->session->close();
            $this->render('partial/_receipt_customer', $data);
        }

    }
    
    public function actionPrintCloseSale()
    {
        $this->layout = '//layouts/column_receipt';
              
        $data['employee_id'] = Common::getEmployeeID();
        $data['location_id'] = Common::getCurLocationID();
        $data['items'] = Sale::model()->cashierDailySale($data['employee_id'],$data['location_id']);
        //$data['totals'] = Sale::model()->cashierDailySaleTotal($data['employee_id'], $data['location_id']);
        $data['transaction_date'] = date('d-M-Y');
       
        if ($data['employee_id']) {
            $employee = Employee::model()->findByPk($data['employee_id']);
            $data['employee'] = $employee->first_name . ' ' . $employee->last_name;
        }
        
        if (count($data['items']) == 0) {
            $data['warning'] = Yii::t('app','There is no sale transaction today.');
            Yii::app()->user->setFlash('warning', Yii::t('app', "There is no sale transaction today."));
            $this->reload($data);
        } else {
            Yii::app()->session->close();
            $this->render('partial/_receipt_close_sale', $data);
        }

    }

    public function actionConfirmOrder()
    {

        $data=$this->sessionInfo();
        SaleOrder::model()->updateSaleOrderTempStatus(Yii::app()->params['str_one']);

        if (count($data['items']) == 0) {
            $data['warning'] = Yii::t('app','The serving table had been printed or changed.');
            Yii::app()->user->setFlash('warning', "The serving table had been printed or changed.");
            $this->reload($data);
        }

        $this->reload();

    }

    public function actionCompleteSale()
    {   
        $this->layout = '//layouts/column_receipt';
        
        $data=$this->sessionInfo();

        $data['sale_id']= SaleOrder::model()->orderSave($data['table_id'],$data['group_id'],$data['payment_total']);
        
        if ($data['sale_id'] == -1) {
            $data['warning']=Yii::t('app','The serving table had been printed or changed.');
            Yii::app()->orderingCart->clearAll();
            $this->reload($data);
        } else {
            Yii::app()->orderingCart->clearAll();
            Yii::app()->session->close(); // very thankful to this forum http://www.yiiframework.com/forum/index.php/topic/30122-cdbhttpsession-and-ccontroller-redirect/
            
            /* Added this step (Update Sale_Order status to 0=completed) at the end of func_save_sale  */
            //SaleOrder::model()->delOrder($data['table_id'], $data['group_id'],Yii::app()->getsetSession->getLocationId());
            
            $this->render('partial/_receipt', $data);
           
        }
    }
 
    public function actionEditSale($sale_id)
    {
        //if(Yii::app()->request->isPostRequest)
        //{
        Yii::app()->orderingCart->clearAll();
        Yii::app()->orderingCart->copyEntireSale($sale_id);
        //Sale::model()->deleteSale($sale_id);
        //$this->reload();
        $this->redirect('index');
        //}
    }

    public function actionReceipt($sale_id)
    {
        $this->layout = '//layouts/column3';

        Yii::app()->orderingCart->clearAll();
        Yii::app()->orderingCart->copyEntireSale($sale_id);

        $data['items'] = Yii::app()->orderingCart->getCart();
        $data['payments'] = Yii::app()->orderingCart->getPayments();
        $data['sub_total'] = Yii::app()->orderingCart->getSubTotal();
        $data['total'] = Yii::app()->orderingCart->getTotal();
        $data['qtytotal'] = Yii::app()->orderingCart->getQuantityTotal();
        $data['amount_change'] = Yii::app()->orderingCart->getAmountDue();
        $data['customer_id'] = Yii::app()->orderingCart->getCustomer();
        $data['comment'] = Yii::app()->orderingCart->getComment();
        $data['employee_id'] = Yii::app()->orderingCart->getEmployee();
        $data['transaction_time'] = Yii::app()->orderingCart->getSaleTime();
        //$data['employee']=ucwords(Yii::app()->session['emp_fullname']);
        $data['sale_id'] = $sale_id;
        $data['usd_2_khr'] = Yii::app()->settings->get('exchange_rate', 'USD2KHR');
        $data['total_khr'] = $data['total'] * $data['usd_2_khr'];
        
        if ($data['customer_id'] != null) {
            $model = Client::model()->findbyPk($data['customer_id']);
            $data['customer'] = $model->first_name . ' ' . $model->last_name;
        }

        $employee = Employee::model()->findByPk($data['employee_id']);
        $data['employee'] = $employee->first_name . ' ' . $employee->last_name;

        if (count($data['items']) == 0) {
            $data['error_message'] = 'Sale Transaction Failed';
        }

        $this->render('_receipt', $data);
        Yii::app()->orderingCart->clearAll();
    }
 
    public function actionDeleteSale($sale_id)
    {
        $result_id=Sale::model()->deleteSale($sale_id, 'Cancel Suspended Sale');
        
        if ($result_id === -1)
        {
           Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'<strong>Oh snap!</strong> Change a few things up and try submitting again.');
        } else {
            Yii::app()->orderingCart->clearAll();
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'<strong>Well done!</strong> Invoice Id ' . $sale_id . 'have been deleted successfully!' );
            $this->redirect('ListSuspendedSale');
        }
        
    }
    
    protected function addOrderMenu($item_id)
    {
        $table_id=Yii::app()->orderingCart->getTableId(); 
        $group_id=Yii::app()->orderingCart->getGroupId(); 
        $employee_id=Yii::app()->session['employeeid'];
        $client_id=1;
        Yii::app()->OrderingCart->addMenu($item_id,$table_id,$group_id,$employee_id,$client_id);
    }
    
    protected function editOrderMenu($item_id)
    {
        $table_id=Yii::app()->orderingCart->getTableId(); 
        $zone_id=Yii::app()->orderingCart->getZoneId(); 
        $employee_id=Yii::app()->session['employeeid'];
        $client_id=1;
        Yii::app()->orderingCart->addMenu($item_id,$table_id,$zone_id,$employee_id,$client_id);
    }
        
    public function actionChangeTable($new_table_id)
    {
        $desk=Desk::model()->findByPk($new_table_id);
        Yii::app()->orderingCart->setZoneId($desk->zone_id);
        $group_id=Yii::app()->orderingCart->changeTable($new_table_id); 
        Yii::app()->orderingCart->setTableId($new_table_id);
        Yii::app()->orderingCart->setGroupId($group_id);
        $this->reload();
    }

    public function actionMergeTable()
    {
        $tables=$_POST['tables'];
        print_r($tables);
        //$desk=Desk::model()->findByPk($new_table_id);
        //$group_id=Yii::app()->orderingCart->changeTable($new_table_id); 
        //Yii::app()->orderingCart->setZoneId($desk->zone_id);
        //Yii::app()->orderingCart->setTableId($new_table_id);
        //Yii::app()->orderingCart->setGroupId($tables);
        $this->reload();
    }
    
    private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';
        
        $model = new SaleItem;

        $data['model'] = $model;
        $data['status'] = 'success';
        
        $data=$this->sessionInfo($data);
        
        if (Yii::app()->settings->get('sale', 'touchScreen') == '1') {
            
            $data['zones'] = Zone::model()->getAllZone(Common::getCurLocationID());
            $data['table_info'] = Desk::model()->findByPk($data['table_id']);
                    
            if ($data['zone_id']==-1) {
                $data['tables'] = Desk::model()->getTableAll(Common::getCurLocationID());
            } else {
                $data['tables'] = Desk::model()->getTablebyZone($data['zone_id'],Common::getCurLocationID());
            }
        }


        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
                'bootstrap.min.js' => false,
                'jquery-ui.min.js' => false,
                'select2.js' => false,  
            );
            
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false; 
            Yii::app()->clientScript->scriptMap['box.css'] = false; 
            $this->renderPartial('index', $data, false, true);
        } else {
            $this->render('index', $data);
        }
    }

    public function actionAjaxRefresh()
    {

        $model = new SaleItem;

        $data['model'] = $model;
        $data['status'] = 'success';

        $data=$this->sessionInfo($data);

        $data['zones'] = Zone::model()->getAllZone(Common::getCurLocationID());
        $data['table_info'] = Desk::model()->findByPk($data['table_id']);

        if ($data['zone_id']==-1) {
            $data['tables'] = Desk::model()->getTableAll(Common::getCurLocationID());
        } else {
            $data['tables'] = Desk::model()->getTablebyZone($data['zone_id'],Common::getCurLocationID());
        }


        $sale_order = new SaleOrder;
        //$new_orders = $sale_order->newOrdering();

        $data_navbar['sale_order'] = $sale_order;
        //$data_navbar['new_orders'] = $new_orders;

        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            //'jquery.js' => false,
            'bootstrap.js' => false,
            //'jquery.min.js' => false,
            'bootstrap.notify.js' => false,
            'bootstrap.bootbox.min.js' => false,
            'bootstrap.min.js' => false,
            'jquery-ui.min.js' => false,
            'select2.js' => false,
        );

        //Yii::app()->clientScript->scriptMap['*.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
        Yii::app()->clientScript->scriptMap['box.css'] = false;

        echo CJSON::encode(array(
            'count_new_order' => $sale_order->countNewOrder(),
            //'div_order_navbar' => $this->renderPartial('touchscreen/_order_navbar', $data_navbar, true, true), // Got stuck if refreshing this drop-down menu always close every time refresh
            'div_order_table' => $this->renderPartial('partial/_left_table', $data, true, true),
            'div_order_menu' => $this->renderPartial('partial/_right_menu', $data, true, true),
            'div_order_status' => $this->renderPartial('partial/_right_status', $data, true, true),
        ));

        //$this->renderPartial('touchscreen/_admin_touchscreen_ajax', $data, false, true);
    }

    public function actionAjaxF5Dropdown()
    {

        $sale_order = new SaleOrder;
        $data_navbar['sale_order'] = $sale_order;

        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => false,
            'bootstrap.js' => false,
            'jquery.min.js' => false,
            'bootstrap.notify.js' => false,
            'bootstrap.bootbox.min.js' => false,
            'bootstrap.min.js' => false,
            'jquery-ui.min.js' => false,
            'select2.js' => false,
        );

        Yii::app()->clientScript->scriptMap['*.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
        Yii::app()->clientScript->scriptMap['box.css'] = false;

        //$new_order_header = $sale_order->countNewOrder() . ' New Orders';

        echo CJSON::encode(array(
            'div_order_navbar' => $this->renderPartial('touchscreen/_order_navbar', $data_navbar, true, true),
        ));

    }

    protected function sessionInfo($data=array())
    {
        /* Define Default Variables Value */
        $data['sale_id'] = null;
        $data['ordering_status'] = null ;
        $data['ordering_msg'] = '';
        $data['ordering_status_icon'] = '';
        $data['ordering_status_span'] = '';
        $data['time_go'] = '';
        $data['count_item'] = 0;
        $data['sub_total'] = 0;
        $data['amount_due'] = 0;
        $data['count_payment'] = 0;
        $data['items'] = array();
        $data['print_categories'] = array();
        $data['payments'] = array();
        $data['giftcard_info'] = null;
        $data['giftcard_id'] = 0;

        $data['location_id'] = Common::getCurLocationID();
        $data['zone_id'] = Common::getZoneID();
        $data['table_id'] = Common::getTableID();
        $data['group_id'] = Common::getGroupID();
        $data['employee_id'] = Common::getEmployeeID();


        if ( isset($data['table_id']) && isset($data['location_id']) ) {

            //$data['sale_id'] = Yii::app()->orderingCart->getSaleId();

            $data['items'] = Yii::app()->orderingCart->getCart();
            $data['payments'] = Yii::app()->orderingCart->getPayments();
            $data['payment_total'] = Yii::app()->orderingCart->getPaymentsTotal();
            $data['count_payment'] = count(Yii::app()->orderingCart->getPayments());


            // Changing to get all sum of (Qty, Sub Total, Total, Discount Amount) at Once storing data in Session level previously gotta execute three times performance improvement
            $data['count_item'] = Yii::app()->orderingCart->getSaleQty();
            $data['sub_total'] = Yii::app()->orderingCart->getSaleSubTotal();
            $data['total'] = Yii::app()->orderingCart->getSaleTotal();
            $data['discount_amount'] = Yii::app()->orderingCart->getSaleDiscount();

            $data['giftcard_id'] = Yii::app()->orderingCart->getDisGiftcard();
            $data['price_tier_id'] = Yii::app()->orderingCart->getPriceTier();

            $data['transaction_time'] = date('h:i:s a');
            $data['transaction_date'] = date('d-M-Y');

            $data['amount_due'] = $data['total'] - $data['payment_total'];

            if ($data['giftcard_id'] > 0) {
                $model = Giftcard::model()->findbyPk($data['giftcard_id']);
                $data['giftcard_info'] = $model->discount_amount . '%';
                Yii::app()->orderingCart->setGDiscount($model->discount_amount);
            }

            /*** Getting Object **/
            $employee = Employee::model()->employeeByID($data['employee_id']);
            $data['table_info'] = Desk::model()->findByPk($data['table_id']);
            $sale_order = SaleOrder::model()->getSaleOrderByDeskId();
            $data['print_categories'] = Category::model()->getPrintCatogory();

            $data['employee'] = $employee;
            $data['sale_order'] = $sale_order;
            $data['employee_name'] = $employee->first_name . ' ' . $employee->last_name;

            if ($sale_order !== null) {
                $data['sale_id'] = $sale_order->id;
                $data['time_go'] = Common::timeAgo($sale_order->sale_time);
                $data['ordering_status'] = $sale_order->temp_status;
                if ($data['ordering_status'] == '1') {
                    $data['ordering_msg'] = Yii::t('app', 'To Print To Kitchen');
                    $data['ordering_status_icon'] = 'fa fa-print icon-animated-bell white';
                    $data['ordering_status_span'] = 'label label-success label-xlg';
                    //$data['desk_icon'] = 'fa fa-print icon-animated-bell bigger-110'; //ace-icon fa fa-ban bigger-110
                } elseif ($data['ordering_status'] == '2') {
                    $data['ordering_msg'] = Yii::t('app', 'Ordering');
                    $data['ordering_status_icon'] = 'fa fa-spinner fa-spin white';
                    $data['ordering_status_span'] = 'label label-warning label-xlg';
                    //$data['desk_icon'] = 'fa fa-print icon-animated-bell bigger-110';
                }
            }
        }

        return $data;
    }

    public function restEvents()
    {
        $this->onRest('req.get.special.render', function($param1) {
            echo CJSON::encode(['param1'=>$param1]);
        });
    }
}
