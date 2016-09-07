<?php

class DeskController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','undodelete','admin','ChangeDesk','MergeDesk'),
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
	public function actionCreate($zone_id=0)
	{
		$model=new Desk;
                $model->zone_id=$zone_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                if (Yii::app()->user->checkAccess('zone.create'))
                {
                    if(isset($_POST['Desk']))
                    {
                            $model->attributes=$_POST['Desk'];
                            if($model->validate())
                            {
                                $transaction=Yii::app()->db->beginTransaction();
                                try 
                                {
                                    if($model->save())
                                    { 
                                        $transaction->commit();
                                        
                                        if ($zone_id==0) {
                                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                            echo CJSON::encode(array(
                                               'status'=>'success',
                                               'div'=>"<div class=alert alert-info fade in>Successfully added ! </div>",
                                               ));
                                            Yii::app()->end();
                                        } elseif (Yii::app()->request->isAjaxRequest) {
                                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                            echo CJSON::encode(array(
                                                'status'=>'success',
                                                'div'=>"<div class=alert alert-info fade in> Successfully added ! </div>" . $model->name,
                                                ));
                                            Yii::app()->end();
                                        } else {
                                            Yii::app()->user->setFlash('success', '<strong>Well done!</strong> Table '. $model->name . ' successfully saved.');
                                            $this->redirect(array('zone/admin'));
                                        }
                                    }
                                }catch (Exception $e)
                                {
                                   $transaction->rollback();
                                } 
                                
                            }
                    }
                }
                else {
                    throw new CHttpException(403, 'You are not authorized to perform this action');
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
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,false),
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
                if (Yii::app()->user->checkAccess('zone.update'))
                {
                    if(isset($_POST['Desk']))
                    {
                            $model->attributes=$_POST['Desk'];
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
                }
                else {
                    throw new CHttpException(403, 'You are not authorized to perform this action');
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
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,false),
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
            if (Yii::app()->user->checkAccess('zone.delete')) {
                if (Yii::app()->request->isPostRequest) {
                    // we only allow deletion via POST request
                    //$this->loadModel($id)->delete();
                    Desk::model()->deleteDesk($id);

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if (!isset($_GET['ajax'])) {
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                    }
		} else {
                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
            } else {
                throw new CHttpException(403, 'You are not authorized to perform this action');
            }
	}
        
        public function actionUndoDelete($id)
	{
            if (Yii::app()->user->checkAccess('zone.delete')) {
                if (Yii::app()->request->isPostRequest) {
                    // we only allow deletion via POST request
                    //$this->loadModel($id)->delete();
                    Desk::model()->undodeleteDesk($id);

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if (!isset($_GET['ajax'])) {
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                    }
		} else {
                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
            } else {
                throw new CHttpException(403, 'You are not authorized to perform this action');
            }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Desk');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
    public function actionAdmin($zone_id = null)
    {
        if (Yii::app()->user->checkAccess('zone.index') || Yii::app()->user->checkAccess('zone.update') || Yii::app()->user->checkAccess('zone.create')) {
            $model = new Desk('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Desk'])) {
                $model->attributes = $_GET['Desk'];
            }

            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('desk_PageSize', (int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }

            if (isset($_GET['DeskArchived'])) {
                Yii::app()->user->setState('desk_archived',$_GET['DeskArchived']);
                unset($_GET['DeskArchived']);
            }

            $model->desk_archived = Yii::app()->user->getState('desk_archived', Yii::app()->params['defaultArchived'] );

            $this->render('admin', array(
                'model' => $model,
                'zone_id' => $zone_id
            ));
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Desk the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Desk::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Desk $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='desk-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionChangeDesk($location_id)
        {
            $model = new Desk;
            $tables = Desk::model()->getFreeDesk($location_id);
            $table_info = Desk::model()->findByPk(Yii::app()->orderingCart->getTableId());
         
            if (Yii::app()->request->isAjaxRequest) {
                //Yii::app()->clientScript->scriptMap['*.js'] = false;
                $cs = Yii::app()->clientScript;
                $cs->scriptMap = array(
                    'jquery.js' => false,
                    'bootstrap.min.js' => false,
                    'jquery.min.js' => false,
                    'bootstrap.notify.js' => false,
                    'bootstrap.bootbox.min.js' => false,
                );
                Yii::app()->clientScript->scriptMap['*.css'] = false;
                
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_change_desk', array('tables' => $tables,'table_info'=>$table_info), true, true),
                ));

                Yii::app()->end();
            } else {
                $this->render('_change_desk', array('tables' => $tables,'table_info'=>$table_info));
            }
        }
        
        public function actionMergeDesk()
        {
            $model = new Desk;
            $tables = Desk::model()->getBusyDesk(Yii::app()->getsetSession->getLocationId());
            //$table_info = Desk::model()->findByPk(Yii::app()->orderingCart->getTableId());
         
            if (Yii::app()->request->isAjaxRequest) {
                //Yii::app()->clientScript->scriptMap['*.js'] = false;
                $cs = Yii::app()->clientScript;
                $cs->scriptMap = array(
                    'jquery.js' => false,
                    'bootstrap.min.js' => false,
                    'jquery.min.js' => false,
                    'bootstrap.notify.js' => false,
                    'bootstrap.bootbox.min.js' => false,
                );
                Yii::app()->clientScript->scriptMap['*.css'] = false;
                
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_merge_desk', array('model' => $model,'tables' => $tables,), true, true),
                ));

                Yii::app()->end();
            } else {
                $this->render('_merge_desk', array('model' => $model,'tables' => $tables));
            }
        }
}