<?php

class InvoiceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('create','update','admin','delete','Report','toggle','ReportAjax'),
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
        /* Create only one invoice table no invoice item one invoice one item
	public function actionCreate()
	{
		$model=new Invoice;
                $mod_invoice_item=new InvoiceItem;
                
                //setting default value
                $model->date_issued=date('Y-m-d');
                $mod_invoice_item->discount=0;
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Invoice'],$_POST['InvoiceItem']))
		{
			$model->attributes=$_POST['Invoice'];
                        $mod_invoice_item->attributes=$_POST['InvoiceItem'];
                          
                         // validate BOTH $a and $b
                        $valid=$model->validate();
                        $valid=$mod_invoice_item->validate() && $valid;
                        
			if($valid) 
                        {
                            $transaction=$model->dbConnection->beginTransaction(); 
                            try
                            {
                                if ($model->save())
                                {
                                    $mod_invoice_item->invoice_id=$model->id;
                                    if ($mod_invoice_item->save())
                                    {
                                        $transaction->commit(); 
                                        //$this->redirect('admin');
                                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                        echo CJSON::encode(array(
                                            'status'=>'success',
                                            'div'=>"<div class=alert alert-info fade in> Successfully added ! </div>",
                                            ));
                                        Yii::app()->end();
                                    }
                                }
                            }catch(Exception $e)
                            {
                                $transaction->rollback();
                                print_r($e);
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
                        'div' => $this->renderPartial( '_form', array('model' => $model,'mod_invoice_item'=>$mod_invoice_item),true,true),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('create',array('model' => $model,'mod_invoice_item'=>$mod_invoice_item)); 
                }
	}
         * 
        */

        public function actionCreate()
	{
		$model=new Invoice;
                
                //setting default value
                $model->date_issued=date('Y-m-d');
            
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Invoice']))
		{
			$model->attributes=$_POST['Invoice'];
                       
                        if ($model->validate())
                        {    
                            $transaction=$model->dbConnection->beginTransaction(); 
                            try
                            {
                                if ($model->save())
                                {  
                                    $transaction->commit(); 
                                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                    echo CJSON::encode(array(
                                        'status'=>'success',
                                        'div'=>"<div class=alert alert-info fade in> Successfully added ! </div>",
                                        ));
                                    Yii::app()->end();

                                }
                            }catch(Exception $e)
                            {
                                $transaction->rollback();
                                print_r($e);
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
                        'bootstrap.min.js'=>false,
                        'bootstrap.bootbox.min.js'=>false,
                        //'jquery-ui-min.js'=>false,
                    );
                      
                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model,),true,true),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('create',array('model' => $model,)); 
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

		if(isset($_POST['Invoice']))
		{
			$model->attributes=$_POST['Invoice'];
			if ($model->validate())
                        {    
                            $transaction=$model->dbConnection->beginTransaction(); 
                            try
                            {
                                if ($model->save())
                                {  
                                    $transaction->commit(); 
                                    //$this->redirect('admin');
                                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                    echo CJSON::encode(array(
                                        'status'=>'success',
                                        'div'=>"<div class=alert alert-info fade in> Successfully updated ! </div>",
                                        ));
                                    Yii::app()->end();

                                }
                            }catch(Exception $e)
                            {
                                $transaction->rollback();
                                print_r($e);
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
                    $this->render('create',array('model' => $model,)); 
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
		$dataProvider=new CActiveDataProvider('Invoice');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Invoice']))
			$model->attributes=$_GET['Invoice'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Invoice::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        protected function gridDebterColumn($data,$row)
        {
            $debter_client= DebterClientRef::model()->find('client_id=:clientID', array(':clientID'=>$data->client_id));
            
            if ($debter_client)
            {
                $debter= DebtCollector::model()->find('id=:debterID',array(':debterID'=>$debter_client->debter_id));
                print_r($debter->fullname);
            }
            else
            {
                print_r('N/A');
            }
        } 
        
        protected function gridAmountColumn($data,$row)
        {
            $criteria = new CDbCriteria;
            $criteria->select='SUM(Amount) as amount';
            $criteria->condition='invoice_id= :invoiceId';
            $criteria->params=array(':invoiceId'=>$data->id);
            $product = InvoiceItem::model()->find($criteria);

            print_r($product->amount);  
        } 
        
        protected function gridDiscountColumn($data,$row)
        {
            $criteria = new CDbCriteria;
            $criteria->select='SUM(discount) as discount';
            $criteria->condition='invoice_id= :invoiceId';
            $criteria->params=array(':invoiceId'=>$data->id);
            $product = InvoiceItem::model()->find($criteria);
            
            if ($product)
                print_r($product->discount);  
            else
                print_r(0);
        } 
        
        protected function gridGiveAwayColumn($data,$row)
        {
            $criteria = new CDbCriteria;
            $criteria->select='SUM(give_away) as give_away';
            $criteria->condition='invoice_id= :invoiceId';
            $criteria->params=array(':invoiceId'=>$data->id);
            $invoice_payment = InvoicePayment::model()->find($criteria);
      
            print_r(Yii::app()->numberFormatter->formatDecimal($invoice_payment->give_away));  
          
        } 
        
        protected function gridPaymentColumn($data,$row)
        {
            $criteria = new CDbCriteria;
            $criteria->select='SUM(amount_paid) as amount_paid';
            $criteria->condition='invoice_id= :invoiceId';
            $criteria->params=array(':invoiceId'=>$data->id);
            $invoice_payment = InvoicePayment::model()->find($criteria);

            print_r(Yii::app()->numberFormatter->formatDecimal($invoice_payment->amount_paid));
        } 
        
        protected function gridOutstandingColumn($data,$row)
        {
            
            $outstanding = Invoice::model()->getOutstanding($data->id);
            
            foreach($outstanding as $data) 
            {
                $outstanding_balance=$data['outstanding_balance'];
                
            }
            print_r(Yii::app()->numberFormatter->formatDecimal($outstanding_balance));  
        }
        
        /**
	 * Manages all models.
	 */
	public function actionReport()
	{
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
                
		if(isset($_GET['Invoice']))
                {
			$model->attributes=$_GET['Invoice'];
                        $from_date=$_GET['Invoice']['from_date'];
                        $to_date=$_GET['Invoice']['to_date'];
                }
                else
                {
                     $from_date=date('Y-m-01');
                     $to_date=date('Y-m-d');
                }

                 $model->from_date=$from_date;
                 $model->to_date=$to_date;
                
                if(Yii::app()->request->isAjaxRequest)
                {
                     echo CJSON::encode( array(
                        'status' => 'success',
                        'div' => $this->renderPartial( '_report_ajax', array('model' => $model),true,false),
                    ));
                }else
                {
                    $this->render('_report',array(
                            'model'=>$model,
                    ));
                }
	}
        
        /**
	 * Manages all models.
	 */
	public function actionReportAjax()
	{
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
                
		if(isset($_GET['Invoice']))
                {
			$model->attributes=$_GET['Invoice'];
                        $from_date=$_GET['Invoice']['from_date'];
                        $to_date=$_GET['Invoice']['to_date'];
                }
                else
                {
                     $from_date=date('Y-m-d');
                     $to_dat=date('Y-m-d');
                }

                 $model->from_date=$from_date;
                 $model->to_date=$to_date;
                
                if(Yii::app()->request->isAjaxRequest)
                {
                     echo CJSON::encode( array(
                        'status' => 'success',
                        'div' => $this->renderPartial( '_report_ajax', array('model' => $model),true,false),
                    ));
                }else
                {
                    $this->render('_report',array(
                            'model'=>$model,
                    ));
                }
	}
        
        public function actionToggle()
        {
            $r = Yii::app()->getRequest();
            
            if($r->getParam('id'))
            {
                    $id=(int)$r->getParam('id');
                    //$flag=$r->getParam('attribute');
                   
                    $model=$this->loadModel($id);
                    
                    $flag=$model->flag;
                       
                    if($flag==0)
                    {
                        $model->flag=1;
                    }
                    elseif ($flag==1)
                    {
                        $model->flag=0;
                    }
                   
                    $transaction=$model->dbConnection->beginTransaction(); 
                    try
                    {
                        if ($model->save())
                        {  
                            $transaction->commit(); 
                            Yii::app()->end();

                        }
                    }catch(Exception $e)
                    {
                        $transaction->rollback();
                        print_r($e);
                    } 
                    
                    Yii::app()->end();
            }
       }
}
