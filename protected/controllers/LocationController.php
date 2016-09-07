<?php

class LocationController extends Controller
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
				'actions'=>array('create','update','delete','undodelete','admin'),
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
            
            if (Yii::app()->user->checkAccess('branch.index')) {
            
                if (Yii::app()->request->isAjaxRequest) {

                    Yii::app()->clientScript->scriptMap['*.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'render',
                        'div' => $this->renderPartial('view', array('model' => $this->loadModel($id)), true, false),
                    ));

                    Yii::app()->end();
                } else {
                    $this->render('view',array('model'=>$this->loadModel($id),));
                }
            } else {
                throw new CHttpException(403, 'You are not authorized to perform this action');
            }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (Yii::app()->user->checkAccess('branch.create')) {
			$model = new Location;

			if (isset($_POST['Location'])) {
				$model->attributes = $_POST['Location'];
				if ($model->save()) {
					//$this->redirect(array('view','id'=>$model->id));
					$this->redirect(array('admin'));
				}
			}

			$this->render('create', array(
				'model' => $model,
			));
		} else {
			throw new CHttpException(403, 'You are not authorized to perform this action');
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if (Yii::app()->user->checkAccess('branch.update')) {
			$model = $this->loadModel($id);

			if (isset($_POST['Location'])) {
				$model->attributes = $_POST['Location'];
				if ($model->save()) {
					$this->redirect(array('admin'));
				}
			}

			$this->render('update', array(
				'model' => $model,
			));
		} else {
			throw new CHttpException(403, 'You are not authorized to perform this action');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
    public function actionDelete($id)
    {
        if (Yii::app()->user->checkAccess('branch.delete')) {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                Location::model()->deleteLocation($id);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionUndoDelete($id)
    {
        if (Yii::app()->user->checkAccess('branch.delete')) {
            if (Yii::app()->request->isPostRequest) {
                //$this->loadModel($id)->delete();
                Location::model()->undodeleteLocation($id);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
		$dataProvider=new CActiveDataProvider('Location');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
    public function actionAdmin()
    {
        if (Yii::app()->user->checkAccess('branch.index') || Yii::app()->user->checkAccess('branch.update') || Yii::app()->user->checkAccess('branch.create')) {
            $model = new Location('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Location'])) {
                $model->attributes = $_GET['Location'];
            }

            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('location_PageSize', (int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }

            if (isset($_GET['Archived'])) {
                Yii::app()->user->setState('location_archived', $_GET['Archived']);
                unset($_GET['Archived']);
            }

            $model->location_archived = Yii::app()->user->getState('location_archived',
                Yii::app()->params['defaultArchived']);

            $this->render('admin', array(
                'model' => $model,
            ));
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Location the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Location::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Location $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='location-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}