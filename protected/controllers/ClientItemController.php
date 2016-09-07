
<?php
class ClientItemController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('RemoveCustomer','SetComment','DeleteItem','AddItem','EditItem','EditItemPrice','Index','IndexPara','AddPayment','CancelSale','CompleteSale','Complete','SuspendSale','DeletePayment','SelectCustomer','AddCustomer','Receipt','UnsuspendSale','EditSale','Receipt','Suspend'),
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
        
        public function actionIndex($category_id=0)
	{
            if (Yii::app()->user->checkAccess('sale.edit'))
            {
                $item_id=0;          
                if (isset($_POST['item_id']))
                {
                    $item_id=$_POST['item_id'];
                    Yii::app()->clientitemCart->addItem($item_id);
                }
                
                $this->reload($item_id,$category_id);
            }
            else
                throw new CHttpException(403, 'You are not authorized to perform this action');
	}
        
        public function actionIndexPara($item_id)
	{
            if (Yii::app()->user->checkAccess('sale.edit'))
            {
               
                Yii::app()->clientitemCart->addItem($item_id);
                
                $this->reload($item_id);
            }
            else
                throw new CHttpException(403, 'You are not authorized to perform this action');
	}
        
        public function actionDeleteItem($item_id)
        {
            if(Yii::app()->request->isPostRequest)
            {
                Yii::app()->clientitemCart->deleteItem($item_id);
                
                if(Yii::app()->request->isAjaxRequest)
                {
                    $this->reload();
                }
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            
        }
        
        public function actionEditItem()
        {
           
            if(Yii::app()->request->isPostRequest)
            {   
                    
                    $item_id=$_POST['item_id'];
                    $quantity=$_POST['quantity'];
                    $price=$_POST['price'];
                    $discount=$_POST['discount'];
                    $description='test';
                    
                    Yii::app()->clientitemCart->editItem($item_id,$quantity,$discount,$price,$description);  
                    $this->reload($item_id);
           }
           else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            
        }
                
        public function actionSelectCustomer()
	{
            $customer_id = $_POST['customer_id'];
            Yii::app()->clientitemCart->setCustomer($customer_id);
            
            Yii::app()->clientitemCart->saleClientCookie((int)$customer_id);
                
            //$this->redirect('index');
            $this->reload();
	}
        
        public function actionRemoveCustomer()
	{
            //Yii::app()->clientScript->scriptMap['*.css'] = false;
            Yii::app()->clientitemCart->removeCustomer();
            $this->reload();
	}
        
        public  function actionSetComment()
        {
            Yii::app()->clientitemCart->setComment($_POST['comment']);
            echo CJSON::encode(array(
                                'status'=>'success',
                                'div'=>"<div class=alert alert-info fade in>Successfully saved ! </div>",
                        ));
        }


        private function reload($item_id=0,$category_id=0)
        {
            $model=new SaleItem;
              
            $data['model']=$model;
            $data['status']='success';   
            $data['items']=Yii::app()->clientitemCart->getCart();
            $data['payments']=Yii::app()->clientitemCart->getPayments();
            $data['payment_total']=Yii::app()->clientitemCart->getPaymentsTotal();
            $data['count_item']=Yii::app()->clientitemCart->getQuantityTotal();
            $data['count_payment']=count(Yii::app()->clientitemCart->getPayments());
            $data['sub_total']=Yii::app()->clientitemCart->getSubTotal();
            $data['total']=Yii::app()->clientitemCart->getTotal();
            $data['amount_due']=Yii::app()->clientitemCart->getAmountDue();
            $data['comment']=Yii::app()->clientitemCart->getComment();
            $customer_id=Yii::app()->clientitemCart->getCustomer();
            $data['usd_2_khr']=Yii::app()->settings->get('exchange_rate', 'USD2KHR');
            $data['total_khr']=$data['total']*$data['usd_2_khr'];
            
            $model->comment=$data['comment'];
           
            if($customer_id!=null)
            {
                $model=Client::model()->findbyPk($customer_id);
                $data['customer']=$model->first_name . ' '  . $model->last_name;
                $data['customer_mobile_no']=$model->mobile_no;
            }
            
            if(Yii::app()->clientitemCart->outofStock($item_id))
            {
                $data['warning']='Warning, Desired Quantity is Insufficient. You can still process the sale, but check your inventory!';
            }
            
            if (Yii::app()->settings->get('system', 'touchScreen')=='1') {
                $data['categories'] = Category::model()->findAll();
                $data['category_id'] = $category_id;

                /*if ($category_id==0) {    
                    $data['products'] = Item::model()->findAll(); */
                if ($category_id==-1) {
                    $criteria=new CDbCriteria;
                    $criteria->addCondition('category_id IS NULL');
                    $data['products'] = Item::model()->findAll($criteria);
                }
                else {
                    $data['products'] = Item::model()->findAll('category_id=:category_id',array(':category_id'=>$category_id));
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
                    'bootstrap.min.js'=>false,
                    'select2.js'=>false,
                    //'EModalDlg.js'=>false,
                );
                
                Yii::app()->clientScript->scriptMap['*.css'] = false;
                //Yii::app()->clientScript->scriptMap['*.js'] = false; 
                
                if (Yii::app()->settings->get('system', 'touchScreen')=='1') {
                    $data['div_gridcart']=$this->renderPartial('touchscreen/ajax_gridcart', $data,true,true);
                }
                else {
                    $data['div_gridcart']=$this->renderPartial('ajax_gridcart', $data,true,false);
                    $data['div_taskcart']=$this->renderPartial('ajax_taskcart', $data,true, false);
                    $data['div_clientcart']=$this->renderPartial('ajax_client', $data, true, true);
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            elseif (Yii::app()->settings->get('system', 'touchScreen')=='1'){
                $this->layout='//layouts/column_sale';
                $this->render('touchscreen/admin_touchscreen',$data);
            }
            else {
                $this->render('admin',$data);
            }
        }
        
        public function actionCancelSale()
        {
            if(Yii::app()->request->isPostRequest)
            {
                Yii::app()->clientitemCart->clearAll();
                $this->reload();
            }
        }
        
        public function actionCompleteSale()
        {  
            $data['items']=Yii::app()->clientitemCart->getCart();
            //$data['payments']=Yii::app()->clientitemCart->getPayments();
            //$data['$payment_received']=Yii::app()->clientitemCart->getPaymentsTotal();
            //$data['sub_total']=Yii::app()->clientitemCart->getSubTotal();
            //$data['total']=Yii::app()->clientitemCart->getTotal();
            //$data['amount_due']=Yii::app()->clientitemCart->getAmountDue();
            $data['customer_id']=Yii::app()->clientitemCart->getCustomer();
            $data['comment']=Yii::app()->clientitemCart->getComment();
            $data['employee_id']=Yii::app()->session['employeeid'];
            $data['transaction_time']= date('m/d/Y h:i:s a');
            $data['employee']=ucwords(Yii::app()->session['emp_fullname']);
            
            //Save transaction to db
            $data['sale_id']='POS '. Sale::model()->saveSaleCookie($data['items'],$data['customer_id'],$data['employee_id'],$data['comment']);
            
            /* Ubcomment here for debugging purpose */
            /*U&
            echo CJSON::encode(array(
                        'status'=>'failed',
                        'message'=>'<div class="alert in alert-block fade alert-error">Transaction Failed !<a class="close" data-dismiss="alert" href="#">&times;</a></div>'. $data['sale_id'],
                    ));
            
            exit;
             * 
            */
          
            if ($data['sale_id'] == 'POS -1')
            {
                echo CJSON::encode(array(
                        'status'=>'failed',
                        'message'=>'<div class="alert in alert-block fade alert-error">Transaction Failed !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
                    ));
            }
            else if (Yii::app()->clientitemCart->getCustomer()===null)
            {
                echo CJSON::encode(array(
                        'status'=>'failed',
                        'message'=>'<div class="alert in alert-block fade alert-error">No Customer Selected !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
                    ));
                Yii::app()->end();
            }
            else
            {
                Yii::app()->clientitemCart->clearAll();
                echo CJSON::encode(array(
                            'status'=>'success',
                            'div_receipt'=>$this->createUrl('ClientItem/index')
                 ));
            }
                         
        }
         
        public function actionEditSale($sale_id)
	{
            //if(Yii::app()->request->isPostRequest)
            //{
                Yii::app()->clientitemCart->clearAll();
                Yii::app()->clientitemCart->copyEntireSale($sale_id);
                Sale::model()->deleteSale($sale_id);
                //$this->reload();
                $this->redirect('index');
            //}
           
	}
        
        
     
  }
