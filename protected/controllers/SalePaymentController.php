<?php

class SalePaymentController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'Payment', 'admin','PaymentDetail'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($sale_id, $amount)
    {
        $model = new SalePayment;
        $model->payment_amount = $amount;
        $model->sale_id = $sale_id;
        $model->payment_type = 'Cash';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->user->checkAccess('client.create')) {
            if (isset($_POST['SalePayment'])) {
                $model->attributes = $_POST['SalePayment'];
                if ($model->validate()) {
                    $paid_amount = $_POST['SalePayment']['payment_amount'];
                    $model->date_paid = $_POST['date_paid'];

                    if ($paid_amount <= $amount) { // If paid amount <= amount to paid
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            if ($model->save()) {
                                $sale = Sale::model()->findByPk($sale_id);
                                $sale_amount = SaleAmount::model()->find('sale_id=:sale_id', array(':sale_id' => $sale_id));

                                if (isset($sale_amount)) {
                                    $sale_amount->paid = $sale_amount->paid + $paid_amount;
                                    $sale_amount->balance = $sale_amount->total - ($sale_amount->paid);
                                    $sale_amount->save();
                                } else {
                                    $sale_amount = new SaleAmount;
                                    $sale_amount->sale_id = $model->sale_id;
                                    $sale_amount->sub_total = $sale->sub_total;
                                    $sale_amount->total = $sale->sub_total;
                                    $sale_amount->paid = $model->payment_amount;
                                    $sale_amount->balance = $sale->sub_total - $model->payment_amount;
                                    $sale_amount->save();
                                }

                                $transaction->commit();

                                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                echo CJSON::encode(array(
                                    'status' => 'success',
                                    'div' => "<div class=alert alert-info fade in>Successfully added ! </div>",
                                ));
                                Yii::app()->end();
                            }
                        } catch (Exception $e) {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                        }
                    } else {
                        $model->addError('payment_amount', 'Amoun to paid is only <strong>' . $amount . '</strong>');
                    }
                }
            }
        } else
            throw new CHttpException(403, 'You are not authorized to perform this action');

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                //'jquery.min.js'=>false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_form', array('model' => $model), true, true),
            ));

            Yii::app()->end();
        } else {
            $this->render('create', array('model' => $model));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SalePayment'])) {
            $model->attributes = $_POST['SalePayment'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('SalePayment');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SalePayment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalePayment'])) {
            $model->attributes = $_GET['SalePayment'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SalePayment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SalePayment::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SalePayment $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sale-payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPayment($client_id)
    {
        $model = new SalePayment;
        $total_amount_to_paid = SaleAmount::model()->getAmountToPaid($client_id);
        $model->payment_amount = $total_amount_to_paid;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->user->checkAccess('client.create')) {
            if (isset($_POST['SalePayment'])) {
                $model->attributes = $_POST['SalePayment'];
                if ($model->validate()) {
                    $paid_amount = $_POST['SalePayment']['payment_amount'];
                    $paid_date = $_POST['date_paid'];
                    $note = $_POST['SalePayment']['note'];

                    if ($paid_amount <= $total_amount_to_paid) { // If paid amount <= amount to paid
                        $message = Sale::model()->batchPayment($client_id, $paid_amount, $paid_date, $note);
                        $model->addError('payment_amount', 'Something wrong <strong>' . $message . '</strong>');

                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => "<div class=alert alert-info fade in>Successfully added ! </div>",
                        ));
                        Yii::app()->end();
                    } else {
                        $model->addError('payment_amount', 'Total Amount to paid is only <strong>' . $total_amount_to_paid . '</strong>');
                    }
                }
            }
        } else
            throw new CHttpException(403, 'You are not authorized to perform this action');

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                //'jquery.min.js'=>false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_payment', array('model' => $model), true, true),
            ));

            Yii::app()->end();
        } else {
            $this->render('_payment', array('model' => $model));
        }
    }

    public function actionPaymentDetail($id)
    {
        $model = new SalePayment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalePayment'])) {
            $model->attributes = $_GET['SalePayment'];
        }

        $this->renderPartial('sale_payment', array(
            'model' => $model,'id'=>$id,
        ));
    }

}
