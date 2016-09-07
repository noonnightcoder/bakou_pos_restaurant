<?php

class ReceivingItemController extends Controller
{
    //public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('RemoveSupplier', 'SetComment', 'DeleteItem', 'AddItem', 'EditItem', 'EditItemPrice', 'Index', 'IndexPara', 'AddPayment', 'CancelRecv', 'CompleteRecv', 'Complete', 'SuspendSale', 'DeletePayment', 'SelectSupplier', 'AddSupplier', 'Receipt', 'SetRecvMode', 'EditReceiving'),
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

    public function actionIndex($trans_mode = 'receive')
    {
        Yii::app()->receivingCart->setMode($trans_mode);
        $item_id = 0;
        
        if (Yii::app()->user->checkAccess('transaction.receive') && Yii::app()->receivingCart->getMode()=='receive') {    
            if (isset($_POST['item_id'])) {
                $item_id = $_POST['item_id'];
                Yii::app()->receivingCart->addItem($item_id);
            }
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('transaction.return') && Yii::app()->receivingCart->getMode()=='return') {
            if (isset($_POST['item_id'])) {
                $item_id = $_POST['item_id'];
                Yii::app()->receivingCart->addItem($item_id);
            }
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('transaction.adjustin') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
            if (isset($_POST['item_id'])) {
                $item_id = $_POST['item_id'];
                Yii::app()->receivingCart->addItem($item_id);
            }
            $this->reload($item_id);    
        } else if (Yii::app()->user->checkAccess('transaction.adjustout') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
            if (isset($_POST['item_id'])) {
                $item_id = $_POST['item_id'];
                Yii::app()->receivingCart->addItem($item_id);
            }
            $this->reload($item_id);    
        } else if (Yii::app()->user->checkAccess('transaction.count') && Yii::app()->receivingCart->getMode()=='physical_count') {
            if (isset($_POST['item_id'])) {
                $item_id = $_POST['item_id'];
                Yii::app()->receivingCart->addItem($item_id);
            }
            $this->reload($item_id);     
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }    
    }

    public function actionIndexPara($item_id)
    {
        if (Yii::app()->user->checkAccess('transaction.receive') && Yii::app()->receivingCart->getMode()=='receive') {
            //$recv_mode = Yii::app()->receivingCart->getMode();
            //$quantity = $recv_mode=="receive" ? 1:1; // Change as immongo we will place minus or plus when saving to database
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('transaction.return') && Yii::app()->receivingCart->getMode()=='return') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('transaction.adjustin') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('transaction.adjustout') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);  
        } else if (Yii::app()->user->checkAccess('transaction.count') && Yii::app()->receivingCart->getMode()=='physical_count') { 
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }    
    }

    public function actionDeleteItem($item_id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->receivingCart->deleteItem($item_id);

            if (Yii::app()->request->isAjaxRequest) {
                $this->reload();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }    
    }

    public function actionEditItem()
    {
        /* // Batch form submit but ajaxSubmit work only once or page refresh gotta to check this for next version
          if(isset($_POST['SaleItem'][$item_id]))
          {
          $quantity=$_POST['SaleItem'][$item_id]['quantity'];
          $discount=$_POST['SaleItem'][$item_id]['discount'];
          $price=$_POST['SaleItem'][$item_id]['price'];
          //$description=$_POST['SaleItem'][$item_id]['description'];
          $description='test';

          Yii::app()->receivingCart->editItem($item_id,$quantity,$discount,$price,$description);
          $this->reload();
          }
         * 
         */

        if (Yii::app()->request->isPostRequest) {

            $item_id = $_POST['item_id'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $discount = $_POST['discount'];
            $expire_date = $_POST['expireDate'];
            $description = 'test';

            Yii::app()->receivingCart->editItem($item_id, $quantity, $discount, $price, $description, $expire_date);
            $this->reload($item_id);
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAddPayment()
    {
        if (Yii::app()->request->isPostRequest) {
            if (Yii::app()->request->isAjaxRequest) {
                $payment_id = $_POST['payment_id'];
                $payment_amount = $_POST['payment_amount'];
                //$this->addPaymentToCart($payment_id, $payment_amount);
                Yii::app()->receivingCart->addPayment($payment_id, $payment_amount);
                $this->reload();
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePayment($payment_id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->receivingCart->deletePayment($payment_id);
            $this->reload();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionSelectSupplier()
    {
        $supplier_id = $_POST['supplier_id'];
        Yii::app()->receivingCart->setSupplier($supplier_id);
        $this->reload();
    }

    public function actionRemoveSupplier()
    {
        //Yii::app()->clientScript->scriptMap['*.css'] = false;
        Yii::app()->receivingCart->removeSupplier();
        $this->reload();
    }

    public function actionSetComment()
    {
        Yii::app()->receivingCart->setComment($_POST['comment']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }

    public function actionSetRecvMode()
    {
        Yii::app()->receivingCart->setMode($_POST['recv_mode']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }

    private function reload($item_id = 0)
    {
        $model = new ReceivingItem;

        $data['model'] = $model;
        $data['mode'] = Yii::app()->receivingCart->getMode();
        $data['status'] = 'success';
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['payment_total'] = Yii::app()->receivingCart->getPaymentsTotal();
        $data['count_item'] = Yii::app()->receivingCart->getQuantityTotal();
        $data['count_payment'] = count(Yii::app()->receivingCart->getPayments());
        //$data['sub_total']=Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['amount_due'] = Yii::app()->receivingCart->getAmountDue();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $supplier_id = Yii::app()->receivingCart->getSupplier();
        //$data['n_item_expire']=ItemExpir::model()->count('item_id=:item_id and quantity>0',array('item_id'=>(int)$item_id));
        
        $model->comment = $data['comment'];

        $data['trans_header'] = Receiving::model()->transactionHeader();
        
        if ($supplier_id != null) {
            $model = Supplier::model()->findbyPk($supplier_id);
            $data['supplier'] = $model->company_name;
            $data['supplier_mobile_no'] = $model->mobile_no;
        }

        /* Does not check the stock for receiving
        if(Yii::app()->receivingCart->outofStock($item_id))
        {
            $data['warning']='Warning, Desired Quantity is Insufficient. You can still process the sale, but check your inventory!';
        }
         * 
         */

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
                'bootstrap.min.js' => false,
                //'bootstrap-datepicker.js'=>false,
                //'EModalDlg.js'=>false,
            );

            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            $data['div_gridcart'] = $this->renderPartial('ajax_gridcart', $data, true, true);
            //$data['div_totalcart']=$this->renderPartial('ajax_totalcart', $data,true, false);
            // $data['div_paymentcart']=$this->renderPartial('ajax_payment', $data,true, false);
            $data['div_taskcart'] = $this->renderPartial('ajax_task', $data, true, false);
            $data['div_suppliercart'] = $this->renderPartial('ajax_supplier', $data, true, true);
            echo CJSON::encode($data);
            Yii::app()->end();
        } else {
            $this->render('admin', $data);
        }
    }

    public function actionCancelRecv()
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->receivingCart->clearAll();
            $this->reload();
        }
    }

    public function actionCompleteRecv()
    {
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['sub_total'] = Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['transaction_time'] = date('m/d/Y h:i:s a');
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);

        //Save transaction to db
        $data['receiving_id'] = 'RECV ' . Receiving::model()->saveRevc($data['items'], $data['payments'], $data['supplier_id'], $data['employee_id'], $data['sub_total'], $data['comment']);

        /* Uncomment here for debugging purpose */
        /*
          echo CJSON::encode(array(
          'status'=>'failed',
          'message'=>'<div class="alert in alert-block fade alert-error">Transaction Failed !<a class="close" data-dismiss="alert" href="#">&times;</a></div>'. $data['receiving_id'],
          ));

          exit;
         * 
         */

        if ($data['receiving_id'] == 'RECV -1') {
            echo CJSON::encode(array(
                'status' => 'failed',
                'message' => '<div class="alert in alert-block fade alert-error">Transaction Failed !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
            ));
        } else {
            //$receiving_id=(int)str_replace('RECV','', $data['receiving_id']);
            $trans_mode = Yii::app()->receivingCart->getMode();
            Yii::app()->receivingCart->clearAll();
            echo CJSON::encode(array(
                'status' => 'success',
                'div_receipt' => $this->createUrl('/receivingItem/index?trans_mode=' . $trans_mode)
            ));
        }
    }

    public function actionComplete($receiving_id)
    {
        $this->layout = '//layouts/column1';

        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['sub_total'] = Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['qtytotal'] = Yii::app()->receivingCart->getQuantityTotal();
        $data['amount_change'] = Yii::app()->receivingCart->getAmountDue();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['transaction_time'] = date('m/d/Y h:i:s a');
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);
        $data['receiving_id'] = $receiving_id;
       
        if ($data['supplier_id'] != null) {
            $model = Supplier::model()->findbyPk($data['supplier_id']);
            $data['supplier'] = $model->company_name . - $model->mobile_no;
        }

        if (count($data['items']) == 0) {
            $data['error_message'] = 'Receiving Transaction Failed';
        }

        $this->render('_receipt', $data);
        Yii::app()->receivingCart->clearAll();
    }

    public function actionSuspendSale()
    {
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['sub_total'] = Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['transaction_time'] = date('m/d/Y h:i:s a');
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);

        //Save transaction to db
        $data['sale_id'] = 'POS ' . SaleSuspended::model()->saveSale($data['items'], $data['payments'], $data['supplier_id'], $data['employee_id'], $data['sub_total'], $data['comment']);

        if ($data['sale_id'] == 'POS -1') {
            echo CJSON::encode(array(
                'status' => 'failed',
                'message' => '<div class="alert in alert-block fade alert-error">Transaction Failed.. !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
            ));
        } else {
            Yii::app()->receivingCart->clearAll();
            $this->reload();
        }
    }

    public function actionUnsuspendSale($sale_id)
    {
        Yii::app()->receivingCart->clearAll();
        Yii::app()->receivingCart->copyEntireSuspendSale($sale_id);
        SaleSuspended::model()->deleteSale($sale_id);
        //$this->reload();
        $this->redirect('index');

        /*
          $sale_id = $this->input->post('suspended_sale_id');
          $this->sale_lib->clear_all();
          $this->sale_lib->copy_entire_suspended_sale($sale_id);
          $this->Sale_suspended->delete($sale_id);
          $this->_reload();
         * 
         */
    }

    public function actionEditReceiving($receiving_id)
    {
        //if(Yii::app()->request->isPostRequest)
        //{
        Yii::app()->receivingCart->clearAll();
        Yii::app()->receivingCart->copyEntireReceiving($receiving_id);
        Receiving::model()->deleteReceiving($receiving_id);
        //$this->reload();
        $this->redirect('index');
        //}
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sale-item-form') {
            echo CActiveForm::validateTabular($model);
            Yii::app()->end();
        }
    }

}
