<?php

class InvoicePaymentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($invoice_id,$invoice_number,$amount)
	{
                //$this->layout = '//layouts/print';
                //$model=$this->loadModel($invoice_id);
                $model=InvoicePayment::model()->find('invoice_id=:invoiceID', array(':invoiceID'=>$invoice_id));
               
                if ($model===null)
                {
                    $model=new InvoicePayment;
                    $model->invoice_id=$invoice_id;
                    $model->invoice_number=$invoice_number;
                    $model->date_paid=date('Y-m-d');
                }
                
                $model->amount=$amount;
                

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InvoicePayment']))
		{
                    $model->attributes=$_POST['InvoicePayment'];
                    if ($model->save())
                    {
                        if(Yii::app()->request->isAjaxRequest)
                        {
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo CJSON::encode(array(
                                'status'=>'success',
                                'div'=>"<div class=alert alert-info fade in> Successfully added ! </div>",
                                ));
                            Yii::app()->end();
                        }
                        else
                        {
                             $this->redirect(array('invoice/admin'));
                        }

                    }
		}

		if(Yii::app()->request->isAjaxRequest)
                {
                    $cs=Yii::app()->clientScript;
                    $cs->scriptMap=array(
                        'jquery.js'=>false,
                        'bootstrap.js'=>false,
                        'jquery.min.js'=>false,
                        'bootstrap.notify.js'=>false,
                        'bootstrap.bootbox.min.js'=>false,
                    );
                    
                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,true),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('create',array('model' => $model)); 
                }
	}
        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InvoicePayment']))
		{
			$model->attributes=$_POST['InvoicePayment'];
			if ($model->save())
                        {
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo CJSON::encode(array(
                                'status'=>'success',
                                'div'=>"<div class=alert alert-info fade in> Successfully added ! </div>",
                                ));
                            Yii::app()->end();

                        }
		}

		if(Yii::app()->request->isAjaxRequest)
                {
                    $cs=Yii::app()->clientScript;
                    $cs->scriptMap=array(
                        'jquery.js'=>false,
                        'bootstrap.js'=>false,
                        'jquery.min.js'=>false,
                        'bootstrap.notify.js'=>false,
                        'bootstrap.bootbox.min.js'=>false,
                    );
                    
                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,true),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('update',array('model' => $model)); 
                }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('InvoicePayment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($invoice_id,$invoice_number)
	{
		$model=new InvoicePayment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InvoicePayment']))
			$model->attributes=$_GET['InvoicePayment'];

		$this->render('admin',array(
			'model'=>$model,
                        'invoice_id'=>$invoice_id,
                        'invoice_number'=>$invoice_number,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=InvoicePayment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-payment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
