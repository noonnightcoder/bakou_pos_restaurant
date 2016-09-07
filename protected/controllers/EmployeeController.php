<?php

class EmployeeController extends Controller
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
                'actions' => array('index', 'view', 'InlineUpdate'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'undodelete','UploadImage'),
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
        $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'user' => $user,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Employee;
        $user = new RbacUser;
        $emp_location = new EmployeeLocation;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->user->checkAccess('employee.create')) {

            if (isset($_POST['Employee'])) {
                $model->attributes = $_POST['Employee'];
                $user->attributes = $_POST['RbacUser'];
             
                $location_id = $_POST['Employee']['location_id'];

                if ( $_POST['Employee']['year'] !== "" || $_POST['Employee']['month'] !== "" || $_POST['Employee']['day'] !== "" ) {
                    $dob = $_POST['Employee']['year'] . '-' . $_POST['Employee']['month'] . '-' . $_POST['Employee']['day'];
                    $model->dob = $dob;
                }

                // validate BOTH $a and $b
                $valid = $model->validate();
                $valid = $user->validate() && $valid;

                if ($valid) {
                    $transaction = $model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) {
                            
                            $user->employee_id = $model->id;
                            $emp_location->employee_id = $model->id;
                            $emp_location->location_id = $location_id;
                            $emp_location->home_status=1;
                            $emp_location->save();
                           
                            if ($user->save()) {
                                //$assignitems = array('items', 'sales', 'employees', 'customers', 'suppliers', 'store', 'receivings', 'reports', 'payments');
                                $assignitems = array('items', 'sales','reports','employees','zones','branches','giftcards','pricetiers','store');

                                foreach ($assignitems as $assignitem) {
                                    if (!empty($_POST['RbacUser'][$assignitem])) {
                                        foreach ($_POST['RbacUser'][$assignitem] as $itemId) {
                                            $authassigment = new Authassignment;
                                            $authassigment->userid = $user->id;
                                            $authassigment->itemname = $itemId;

                                            if (!$authassigment->save()) {
                                                $transaction->rollback();
                                                print_r($authassigment->errors);
                                            }
                                        }
                                    }
                                }

                                $transaction->commit();
                                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> successfully saved.');
                                //$this->redirect(array('view', 'id' => $model->id));
                                $this->redirect(array('admin'));
                            } else {
                                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.' . $e);
                    }
                }
            }
        } else
            throw new CHttpException(403, 'You are not authorized to perform this action');

        $this->render('create', array('model' => $model, 'user' => $user,));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if (Yii::app()->user->checkAccess('employee.update')) {
            
            $model = $this->loadModel($id);
            $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));  
            $emp_location = EmployeeLocation::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));
            
            if (!$emp_location) {
                $emp_location = New EmployeeLocation;
            } else {
                $model->location_id=$emp_location->location_id;
            }
        

            $criteria = new CDbCriteria;
            $criteria->condition = 'userid=:userId';
            $criteria->select = 'itemname';
            $criteria->params = array(':userId' => $user->id);
            $authassigment = Authassignment::model()->findAll($criteria);

            $auth_items = array();
            foreach ($authassigment as $auth_item) {
                $auth_items[] = $auth_item->itemname;
            }

            $user->items = $auth_items;
            $user->sales = $auth_items;
            $user->reports = $auth_items;
            $user->employees = $auth_items;
            $user->customers = $auth_items;
            $user->zones = $auth_items;
            $user->branches = $auth_items;
            $user->giftcards = $auth_items;
            $user->pricetiers = $auth_items;
            $user->store = $auth_items;
             
            //$user->payments = $auth_items;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['Employee'])) {
                $model->attributes = $_POST['Employee'];
                $location_id = $_POST['Employee']['location_id'];
                $user->attributes=$_POST['RbacUser'];

                if ( $_POST['Employee']['year'] !== "" || $_POST['Employee']['month'] !== "" || $_POST['Employee']['day'] !== "" ) {
                    $dob = $_POST['Employee']['year'] . '-' . $_POST['Employee']['month'] . '-' . $_POST['Employee']['day'];
                    $model->dob = $dob;
                }

                // validate BOTH $a and $b
                $valid = $model->validate();
                $valid= $user->validate() && $valid;

                if ($valid) {
                    $transaction = $model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) {

                            $emp_location->employee_id = $model->id;
                            $emp_location->location_id = $location_id;
                            $emp_location->home_status=1;
                            $emp_location->save();
                            
                            //print_r($location_id); die();
                                                         
                            // Delete all existing granted module 
                            Authassignment::model()->deleteAuthassignment($user->id);

                            //$assignitems = array('items', 'sales', 'employees', 'customers', 'suppliers', 'store', 'receivings', 'reports', 'payments');
                            $assignitems = array('items', 'sales','reports','employees','zones','branches','giftcards','pricetiers','store');

                            foreach ($assignitems as $assignitem) {
                                if (!empty($_POST['RbacUser'][$assignitem])) {
                                    foreach ($_POST['RbacUser'][$assignitem] as $itemId) {
                                        $authassigment = new Authassignment;
                                        $authassigment->userid = $user->id;
                                        $authassigment->itemname = $itemId;
                                        $authassigment->save();
                                    }
                                }
                            }

                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Well done!</strong> successfully saved.');
                            //$this->redirect(array('view', 'id' => $model->id));
                            $this->redirect(array('admin'));
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.' . $e);
                    }
                }
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $this->render('update', array('model' => $model, 'user' => $user));

    }

    public function actionInlineUpdate()
    {
        if (Yii::app()->user->checkAccess('employee.update')) {
            $model = $this->loadModel((int) $_POST['pk']);
            $attribute = $_POST['name'];
            $model->$attribute = $_POST['value'];
            try {
                $model->save();
            } catch (CException $e) {
                echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
                return;
            }
            echo CJSON::encode(array('success' => true));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->user->checkAccess('employee.delete')) {
            if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
                $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));

                if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
                    throw new CHttpException(400, 'Cannot delete owner user system. Please do not repeat this request again.');
                } else {
                    Employee::model()->deleteEmployee($id);
                }

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
            else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }
    
    public function actionundoDelete($id)
    {
        if (Yii::app()->user->checkAccess('employee.delete')) {
            if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
                
                $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));

                if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
                    throw new CHttpException(400, 'Cannot delete owner user system. Please do not repeat this request again.');
                } else {
                    //$this->loadModel($id)->delete();
                    Employee::model()->undodeleteEmployee($id);
                }

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            }
            else {
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
        $dataProvider = new CActiveDataProvider('Employee');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {

        if (Yii::app()->user->checkAccess('employee.index') || Yii::app()->user->checkAccess('employee.create') || Yii::app()->user->checkAccess('employee.update') || Yii::app()->user->checkAccess('employee.delete')) {
            $model = new Employee('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Employee']))
                $model->attributes = $_GET['Employee'];

            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('employee_pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }

            if (isset($_GET['archived'])) {
                Yii::app()->user->setState('employee_archived',$_GET['archived']);
                unset($_GET['archived']);
            }

            $model->employee_archived = Yii::app()->user->getState('employee_archived', Yii::app()->params['defaultArchived'] );

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
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Employee::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function gridLoginIDColumn($data, $row)
    {
        $model = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => $data->id));

        if ($model) {
            $user_name = ucwords($model->user_name);
            if ( $data->status == '1' ) {
                echo $user_name;
            } else {
                echo "<span class=\"text-muted\">  $user_name <span>";
            }
        } else {
            echo "No Login ID";
        }


    }

    /*
    public function actionUploadImage($employee_id)
    {
        $model = $this->loadModel($employee_id);
        $employee_photo = EmployeePhoto::model()->find('employee_id=:employeeId', array(':employeeId' => (int) $employee_id));

        if (!$employee_photo) {
            $employee_photo = new EmployeePhoto;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            //$file=CUploadedFile::getInstance($model,'image');
            //$roomtypephoto->filename=$file->name;
            $employee_photo->filetype = $file->type;
            $employee_photo->size = $file->size;
            $employee_photo->thumnailphoto = ($file->tempName);

            $fileName = "{$rnd}_{$file}";  // random number + file name
            $model->image = $fileName;
            $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $name = $path . '/' . $fileName;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}

            $image = Yii::app()->image->load($name);
            $image->resize(95, 75);
            $image->save();

            $employee_photo->filename = $fileName;
            $employee_photo->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
            $employee_photo->photo = file_get_contents($name);

            $employee_photo->user_id = $model->user_id;

            if (!$employee_photo->save()) {
                //$transaction->rollback();
                print_r($employee_photo->errors);
                //die();
            }
        }
    }
     * 
    */
    
    public function actionUploadImage($employee_id)
    {
        
        $model = new Employee;
        $image_model = EmployeeImage::model()->find('employee_id=:employee_id', array(':employee_id' => (int)$employee_id));

        if (!$image_model) {
            $image_model = new EmployeeImage;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999

            $image_model->filetype = $file->type;
            $image_model->size = $file->size;
            $image_model->photo = file_get_contents($file->tempName);

            $fileName = "{$rnd}_{$file}";  // random number + file name
            $model->image = $fileName;
            $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $name = $path . '/' . $fileName;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}
           
            $image = Yii::app()->image->load($name);
            $image->resize(160, 160);
            $image->save();

            /*
            $image_model->item_id = $employee_id;
            $image_model->filename = $fileName;
            $image_model->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $image_model->thumbnail = file_get_contents($name);
            if (!$image_model->save()) {
                $transaction->rollback();
                print_r($image_model->errors);
            }
             * 
            */
        }
    }


}
