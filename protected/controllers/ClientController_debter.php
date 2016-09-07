<?php

class ClientController extends Controller
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
				'actions'=>array('create','update','GetClient','AddCustomer'),
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
	public function actionCreate()
	{
		$model=new Client;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->validate())
                        {
                            if($model->save())
                            {
                                /*
                                if (!empty($_POST['Client']['debter_id'])) 
                                {           
                                   $debter_id=$_POST['Client']['debter_id'];
                                   $mod_debter_ref=new DebterClientRef;
                                   $mod_debter_ref->client_id=$model->id;
                                   $mod_debter_ref->debter_id=(int)$debter_id;
                                   $mod_debter_ref->save();
                                } 
                                 * 
                                */
                                
                                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                echo CJSON::encode(array(
                                   'status'=>'success',
                                   'div'=>"<div class=alert alert-info fade in>Successfully added ! </div>",
                                   ));
                                Yii::app()->end();
                            }
                        }
		}

		if(Yii::app()->request->isAjaxRequest)
                {
                    Yii::app()->clientScript->scriptMap['*.js'] = false;

                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model),true),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('create',array('model' => $model)); 
                }
	}
        
        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddCustomer()
	{
		$model=new Client;

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->validate())
                        {
                            if($model->save())
                            {
                                if (!empty($_POST['Client']['debter_id'])) 
                                {           
                                   $debter_id=$_POST['Client']['debter_id'];
  
                                   $mod_debter_ref=new DebterClientRef;
                                   $mod_debter_ref->client_id=$model->id;
                                   $mod_debter_ref->debter_id=(int)$debter_id;
                                   $mod_debter_ref->save();
                                } 
                                
                                Yii::app()->shoppingCart->setCustomer($model->id);
                                $this->redirect(array('saleitem/index'));
                                //Yii::app()->end();
                                //$saleitem=Yii::app()->createController('saleitem');//returns array containing controller instance and action index.
                                //$saleitem=$saleitem[0]; //get the controller instance.
                                //$saleitem->reload(); //use a public method.
                                //Yii::app()->end();
                                
                                /*
                                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                echo CJSON::encode(array(
                                   'status'=>'success',
                                   'div'=>"<div class=alert alert-info fade in>Successfully added ! </div>",
                                   ));
                                Yii::app()->end();
                                 * 
                                */
                            }
                        }
		}

		if(Yii::app()->request->isAjaxRequest)
                {
                    Yii::app()->clientScript->scriptMap['*.js'] = false;

                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,true),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('_form',array('model' => $model)); 
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
                $debter= DebterClientRef::model()->find('client_id=:clientId', array(':clientId'=>$model->id));
                if ($debter)
                    $model->debter_id=$debter->debter_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->validate())
                        { 
                            if($model->save())
                            {
                                 if (!empty($_POST['Client']['debter_id'])) 
                                 {           
                                    $debter_id=$_POST['Client']['debter_id'];
                                    $criteria=new CDbCriteria;
                                    $criteria->condition='client_id=:clientId';
                                    $criteria->params=array(':clientId'=>$model->id);
                                    DebterClientRef::model()->deleteAll($criteria);

                                    $mod_debter_ref=new DebterClientRef;
                                    $mod_debter_ref->client_id=$model->id;
                                    $mod_debter_ref->debter_id=(int)$debter_id;
                                    $mod_debter_ref->save();
                                 }
                                
                                 Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                 echo CJSON::encode(array(
                                    'status'=>'success',
                                    'div'=>"<div class=alert alert-info fade in>Successfully added ! </div>",
                                    ));
                                 Yii::app()->end();
                            }
                        }
		}

		if(Yii::app()->request->isAjaxRequest)
                {
                    //Yii::app()->clientScript->scriptMap['*.js'] = false;
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
                    $this->render('_form',array('model' => $model)); 
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
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Client('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

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
		$model=Client::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /** Lookup Client for autocomplete 
         * 
         * @throws CHttpException
         */
        public function actionGetClient() { 
            if (isset($_GET['term'])) {
                 $term = trim($_GET['term']);
                 $ret['results'] = Client::getClient($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
                 echo CJSON::encode($ret);
                 Yii::app()->end();

            }
        }
}
