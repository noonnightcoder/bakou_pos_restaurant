<?php

class ItemController extends Controller
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
                'actions' => array('create', 'CreateImage', 'update', 'UpdateImage', 'delete','undodelete', 'GetItem', 'Inventory', 'admin', 'AutocompleteItem', 'SelectItem', 'SelectItemRecv', 'SelectItemClient', 'CostHistory', 'PriceHistory', 'LowStock', 'OutStock','loadImage'),
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

    public function actionCreateImage()
    {
        $model = new Item;
        $item_price_promo = new ItemPricePromo;
        $price_tiers = PriceTier::model()->getListPriceTier();
        $has_error="";

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (Yii::app()->user->checkAccess('item.create')) {
            if (isset($_POST['Item'])) {
                $model->attributes = $_POST['Item'];
                $item_price_promo->attributes = $_POST['ItemPricePromo'];

                $qty = isset($_POST['Item']['quantity']) ? $_POST['Item']['quantity'] : 0;
                $cost_price = isset($_POST['Item']['cost_price']) ? $_POST['Item']['cost_price'] : 0;
                $model->quantity = $qty;
                $model->cost_price=$cost_price;

                $valid = $model->validate();
                if ( !empty($_POST['ItemPricePromo']['unit_price']) || !empty($_POST['ItemPricePromo']['start_date']) || !empty($_POST['ItemPricePromo']['end_date'] ) ) {
                    if (!$item_price_promo->validate()) {
                        $has_error = 'has-error';
                    }
                    $valid = $item_price_promo->validate() & $valid;
                }

                if ($valid) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($model->save()) {
                            if ($price_tiers) {
                                foreach ($price_tiers as $i=>$price_tier) {
                                    //$item_price_tier= ItemPriceTier::model()->find('price_tier_id=:price_tier_id', array(':price_tier_id'=>(int)$i));
                                    if ($_POST['ItemPrice'][$price_tier["tier_id"]]!="") {
                                        $item_price_tier = new ItemPriceTier;
                                        $item_price_tier->item_id=$model->id;
                                        $item_price_tier->price_tier_id=$price_tier["tier_id"];
                                        $item_price_tier->price=$_POST['ItemPrice'][$price_tier["tier_id"]];
                                        $item_price_tier->save();
                                    }
                                }
                            }

                            if (!empty($_POST['ItemPricePromo']['unit_price'])) {
                                $item_price_promo->item_id = $model->id;
                                $item_price_promo->save();
                            }

                            /*if (!empty($_POST['Item']['promo_price'])) {
                                $item_price_promo = new ItemPricePromo;
                                $item_price_promo->item_id=$model->id;
                                $item_price_promo->unit_price=$_POST['Item']['promo_price'];
                                $item_price_promo->start_date=str_to_date($_POST['Item']['promo_start_date'],'%d-%m-%Y');
                                $item_price_promo->end_date=str_to_date($_POST['Item']['promo_end_date'],'%d-%m-%Y');
                                $item_price_promo->save();
                            }*/

                            //$this->addImages($model, $transaction);
                            $transaction->commit();
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'<strong> Well done!</strong> Item Id #' . $model->name . ' have been saved successfully!' );
                            $this->redirect(array('createImage'));
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        print_r($e);
                    }
                }
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
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
                'div' => $this->renderPartial('_form_image', array('model' => $model,'price_tiers'=>$price_tiers, 'item_price_promo' => $item_price_promo, 'has_error' => $has_error), true, true),
            ));

            Yii::app()->end();
        } else {
            $this->render('create_image', array('model' => $model,'price_tiers'=>$price_tiers, 'item_price_promo' => $item_price_promo, 'has_error' => $has_error));
        }
    }

    public function actionUpdateImage($id)
    {
        $model = $this->loadModel($id);
        $price_tiers = PriceTier::model()->getListPriceTierUpdate($id);
        $item_price_promo = ItemPricePromo::model()->itemPricePromoByItemID($id);
        $has_error = "";

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (Yii::app()->user->checkAccess('item.update')) {
            if (isset($_POST['Item'])) {
                $old_price = $model->unit_price;
                $model->attributes = $_POST['Item'];
                $item_price_promo->attributes = $_POST['ItemPricePromo'];

                $valid = $model->validate();
                if ( !empty($_POST['ItemPricePromo']['unit_price']) || !empty($_POST['ItemPricePromo']['start_date']) || !empty($_POST['ItemPricePromo']['end_date'] ) ) {
                    if (!$item_price_promo->validate()) {
                        $has_error = 'has-error';
                    }
                    $valid = $item_price_promo->validate() & $valid;
                }

                if ($valid) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($model->save()) {
                            if ($price_tiers) {
                                ItemPriceTier::model()->deleteItemPriceTier($model->id);
                                foreach ($price_tiers as $i=>$price_tier) {
                                    if ($_POST['ItemPrice'][$price_tier["tier_id"]]!="") {
                                        $item_price_tier = new ItemPriceTier;
                                        $item_price_tier->item_id=$model->id;
                                        $item_price_tier->price_tier_id=$price_tier["tier_id"];
                                        $item_price_tier->price=$_POST['ItemPrice'][$price_tier["tier_id"]];
                                        $item_price_tier->save();
                                    }
                                }
                            }

                            if (!empty($_POST['ItemPricePromo']['unit_price'])) {
                                $item_price_promo->item_id = $model->id;
                                $item_price_promo->save();
                            }

                            //$this->addImages($model, $transaction);
                            $transaction->commit();
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'<strong> Well done!</strong> Item Id #' . $model->name . ' have been saved successfully!' );
                            $this->redirect(array('admin'));
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        print_r($e);
                    }
                }
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }


        $this->render('update_image', array('model' => $model,'price_tiers'=>$price_tiers, 'item_price_promo' => $item_price_promo, 'has_error' => $has_error));
    }



    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->user->checkAccess('item.delete')) {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                //$this->loadModel($id)->delete();
                Item::model()->deleteItem($id);

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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionUndoDelete($id)
    {
        if (Yii::app()->user->checkAccess('item.delete')) {
            if (Yii::app()->request->isPostRequest) {
                Item::model()->undodeleteItem($id);
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
        $dataProvider = new CActiveDataProvider('Item');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        if (Yii::app()->user->checkAccess('item.index')) {

            $model = new Item('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Item']))
                $model->attributes = $_GET['Item'];

            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }

            if (isset($_GET['archivedItem'])) {
                Yii::app()->user->setState('archived',$_GET['archivedItem']);
                unset($_GET['archivedItem']);
            }

            $model->item_archived = Yii::app()->user->getState('archived', Yii::app()->params['defaultArchived'] );

            $this->render('admin', array(
                'model' => $model,
            ));
        } else
            throw new CHttpException(403, 'You are not authorized to perform this action');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Item::model()->findByPk($id);

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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAutocompleteItem()
    {
        $res = array();
        if (isset($_GET['term'])) {
            // http://www.yiiframework.com/doc/guide/database.dao
            $qtxt = "SELECT id,concat_ws(' : ',name,unit_price) AS text FROM item WHERE name LIKE :item_name";
            $command = Yii::app()->db->createCommand($qtxt);
            $command->bindValue(":item_name", '%' . $_GET['term'] . '%', PDO::PARAM_STR);
            $res = $command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();
    }

    /** Lookup Client for selet 2 
     * 
     * @throws CHttpException
     */
    public function actionGetItem($price_tier_id)
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Item::model()->getItem($term,$price_tier_id); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionInventory($item_id)
    {
        $model = $this->loadModel($item_id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Item'])) {
            $model->attributes = $_POST['Item'];

            if (empty($_POST['Item']['items_add_minus'])) {
                $valid = false;
                $model->addError('items_add_minus', 'Cannot be blank.');
            } elseif (empty($_POST['Item']['inv_comment'])) {
                $valid = false;
                $model->addError('inv_comment', 'Cannot be blank.');
            } else {
                $new_quantity = $_POST['Item']['items_add_minus'];
                $valid = $model->validate();
            }

            if ($valid) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    $cur_quantity = $model->quantity;
                    $model->quantity = $cur_quantity + $new_quantity;
                    if ($model->save()) {
                        //Ramel Inventory Tracking
                        $inventory = new Inventory;
                        $sale_remarks = $_POST['Item']['inv_comment'];
                        $inventory->trans_items = $model->id;
                        $inventory->trans_user = Yii::app()->user->id;
                        $inventory->trans_comment = $sale_remarks;
                        $inventory->trans_inventory = $new_quantity;
                        $inventory->trans_date = date('Y-m-d H:i:s');

                        if (!$inventory->save()) {
                            $transaction->rollback();
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo CJSON::encode(array(
                                'status' => 'falied',
                                'div' => "<div class=alert alert-info fade in> Something wrong! </div>" . Yii::app()->user->id . var_dump($inventory->getErrors()),
                            ));
                            Yii::app()->end();
                        }

                        $transaction->commit();
                        //Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => "<div class=alert alert-info fade in> Successfully updated ! </div>",
                        ));
                        Yii::app()->end();
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    print_r($e);
                }
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
            );

            Yii::app()->clientScript->scriptMap['*.js'] = false;

            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_inventory', array('model' => $model), true, false),
            ));

            Yii::app()->end();
        } else {
            $this->render('_inventory', array('model' => $model));
        }
    }

    public function actionSelectItem($item_parent_id,$category_id)
    {
        $model = new Item('topping');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item']))
            $model->attributes = $_GET['Item'];

        if (Yii::app()->request->isAjaxRequest) {
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                //'bootstrap.js'=>false,
                //'jquery.ba-bbq.min.js'=>false,
                //'jquery.yiigridview.js'=>false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-grid') {
                $this->render('_select_item', array(
                    'model' => $model, 'item_parent_id'=> $item_parent_id,'category_id'=>$category_id
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item', array('model' => $model, 'item_parent_id' => $item_parent_id,'category_id'=>$category_id), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item', array('model' => $model, 'item_parent_id' => $item_parent_id,'category_id'=>$category_id));
        }
    }

    public function actionSelectItemRecv()
    {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item']))
            $model->attributes = $_GET['Item'];

        if (Yii::app()->request->isAjaxRequest) {
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                //'bootstrap.js'=>false,
                //'jquery.ba-bbq.js'=>false,
                //'jquery.ba-bbq.min.js' => false,
                //'jquery.yiigridview.js'=>false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-recv-grid') {
                $this->render('_select_item_recv', array(
                    'model' => $model
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item_recv', array('model' => $model), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item_recv', array('model' => $model));
        }
    }

    public function actionSelectItemClient()
    {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item']))
            $model->attributes = $_GET['Item'];

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

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-grid') {
                $this->render('_select_item_client', array(
                    'model' => $model
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item_client', array('model' => $model), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item_client', array('model' => $model));
        }
    }

    public function actionCostHistory($item_id)
    {
        $model = new Item;

        $item = Item::model()->getItemInfo((int) $item_id);
        $avg_cost = Item::model()->avgCost((int) $item_id);

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.ba-bbq.min.js' => false,
                'jquery.yiigridview.js' => false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'costhistory-grid') {
                $this->render('_cost_history', array(
                    'model' => $model, 'item_id' => $item_id, 'item' => $item, 'avg_cost' => $avg_cost
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_cost_history', array('model' => $model, 'item_id' => $item_id, 'item' => $item, 'avg_cost' => $avg_cost), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_cost_history', array(
                'model' => $model, 'item_id' => $item_id, 'item' => $item, 'avg_cost' => $avg_cost
            ));
        }
    }

    public function actionPriceHistory($item_id)
    {
        $model = new ItemPrice('search');
        $model->unsetAttributes();  //

        $item = Item::model()->getItemInfo((int) $item_id);

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.ba-bbq.min.js' => false,
                'jquery.yiigridview.js' => false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'pricehistory-grid') {
                $this->render('_price_history', array(
                    'model' => $model, 'item_id' => $item_id, 'item' => $item
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_price_history', array('model' => $model, 'item_id' => $item_id, 'item' => $item), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_price_history', array(
                'model' => $model, 'item_id' => $item_id, 'item' => $item
            ));
        }
    }

    public function actionLowStock()
    {
        if (Yii::app()->user->checkAccess('item.index')) {

            $model = new Item('lowstock');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Item']))
                $model->attributes = $_GET['Item'];

            $this->render('_low_stock', array(
                'model' => $model,
            ));
        } else
            throw new CHttpException(403, 'You are not authorized to perform this action');
    }

    public function actionOutStock()
    {
        if (Yii::app()->user->checkAccess('item.index')) {

            $model = new Item('outstock');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Item']))
                $model->attributes = $_GET['Item'];

            $this->render('_out_stock', array(
                'model' => $model,
            ));
        } else
            throw new CHttpException(403, 'You are not authorized to perform this action');
    }

    protected function addImages($model, $transaction)
    {
        $image_model = ItemImage::model()->find('item_id=:itemId', array(':itemId' => $model->id));

        if (!$image_model) {
            $image_model = new ItemImage;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999

            $image_model->filetype = $file->type;
            $image_model->size = $file->size;
            $image_model->photo = file_get_contents($file->tempName);

            $fileName = "{$rnd}_{$file}";  // random number + file name
            $model->image = $fileName;
            $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
            $name = $path . '/' . $fileName;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}

            $image = Yii::app()->image->load($name);
            $image->resize(160, 160);
            $image->save();

            $image_model->item_id = $model->id;
            $image_model->filename = $fileName;
            $image_model->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
            $image_model->thumbnail = file_get_contents($name);
            if (!$image_model->save()) {
                $transaction->rollback();
                print_r($image_model->errors);
            }
        }
    }
    
    public function actionloadImage($id)
    {
        $model= ItemImage::model()->find('item_id=:item_id',array(':item_id'=>$id));
        $this->renderPartial('image', array(
            'model'=>$model
        ));
    }
    
    public function actionSelectItemTopping()
    {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (Yii::app()->request->isAjaxRequest) {
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                //'bootstrap.js'=>false,
                //'jquery.ba-bbq.min.js'=>false,
                //'jquery.yiigridview.js'=>false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-grid') {
                $this->render('_select_item', array(
                    'model' => $model
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item', array('model' => $model), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item', array('model' => $model));
        }
    }

}
