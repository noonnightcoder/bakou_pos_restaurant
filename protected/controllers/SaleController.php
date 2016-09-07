<?php

class SaleController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'Invoice', 'ViewInvoice'),
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
    public function actionCreate()
    {
        $model = new Sale;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sale'])) {
            $model->attributes = $_POST['Sale'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
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

        if (isset($_POST['Sale'])) {
            $model->attributes = $_POST['Sale'];

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => "<div class=alert alert-info fade in>Successfully added ! </div>",
                    ));
                    Yii::app()->end();
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            //Yii::app()->clientScript->scriptMap['*.js'] = false;

            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_form', array('model' => $model), true, true),
            ));

            Yii::app()->end();
        } else {
            $this->render('update', array('model' => $model));
        }
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
            //$this->loadModel($id)->delete();
            $remark = $_POST['remark'];
            $result_id=Sale::model()->deleteSale($id, $remark);

            if ($result_id === -1)
            {
                echo CJSON::encode(array(
                        'status'=>'failed',
                        'message'=>'<div class="alert in alert-block fade alert-error">Transaction Failed !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
                    ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                        //'div_receipt'=>$this->createUrl('/report')
                ));
                Yii::app()->end();
            }    

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Sale');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Sale('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sale']))
            $model->attributes = $_GET['Sale'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Sale::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sale-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function gridPaidAmount($data, $row)
    {
        $model = SaleAmount::model()->find('sale_id=:sale_id', array(':sale_id' => $data->id));
        $amount = isset($model) ? $model->total : $data->sub_total;
        echo $amount;
    }

    public function gridPaymentStatus($data, $row)
    {
        if ($data["status"] == "1") {
            echo '<span class="btn btn-small btn-success"><s>' . 'Paid All' . '</s></span>';
        } elseif ($data["status"] == "0") {
            echo '<span class="btn btn-small btn-danger">' . 'No Payment' . '</span>';
        } else {
            echo '<span class="btn btn-small btn-warning">' . 'Paid Some' . '</s>';
        }
    }
    
    public function gridPaymentBtn($data, $row)
    {
        if ($data["status"] === "1") {
            echo CHtml::link(Yii::t('app','Payment'),"#", array("class"=>"btn btn-info btn-small disabled"));
        } else {
           echo CHtml::link(Yii::t('app','Payment'), Yii::app()->createUrl("SalePayment/create", array("sale_id"=>$data["sale_id"],"amount"=>$data["amount_to_paid"])), array("class"=>"btn btn-info btn-small update-dialog-open-link"));
        } 
    }

    /**
     * Manages all models.
     */
    public function actionInvoice($client_id=0)
    {
        $model = new Sale;
        //$model->unsetAttributes();  // clear any default values
        if (!empty($_GET['Sale']['sale_id']))
        {
            $search_text=$_GET['Sale']['sale_id'];
        } else {
            $search_text='0';
        }

        if (!empty($_GET['Sale']['sale_id'])) {
            $model->sale_id = $_GET['Sale']['sale_id'];
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('sale_invoice_ajax', array('model' => $model, 'client_id' => $client_id,'search_text'=>$search_text), true, true),
            ));
        } else {
            $this->render('sale_invoice', array('model' => $model, 'client_id' => $client_id,'search_text'=>$search_text));
        }
    }

    /**
     * Manages all models.
     */
    public function actionViewInvoice($client_id)
    {
        $model = new Sale;
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sale']))
            $model->attributes = $_GET['Sale'];
      
        if (!empty($_GET['Sale']['sale_id']))
        {
            $search_text=$_GET['Report']['sale_id'];
        } else {
            $search_text='0';
        }

        $this->render('_invoices', array(
            'model' => $model, 'client_id' => $client_id,'search_text'=>$search_text,
        ));
    }

    public function gridDatePaidColumn($data, $row)
    {
        echo Sale::model()->datePaid($data['sale_id']);
    }

    public function gridNoteColumn($data, $row)
    {
        echo Sale::model()->paymentNote($data['sale_id']);
    }

}
