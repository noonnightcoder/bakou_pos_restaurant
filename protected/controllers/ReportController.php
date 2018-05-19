<?php

class ReportController extends Controller
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
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'UserLogDt', 'ReportTab', 'SaleInvoiceItem',
                    'SaleInvoice', 'SaleInvoiceAlert', 'SaleDaily', 'SaleReportTab', 'SaleSummary',
                    'Payment', 'TopProduct', 'SaleHourly', 'Inventory', 'ItemExpiry', 'DailyProfit',
                    'ItemInactive', 'Transaction', 'TransactionItem', 'ItemAsset', 'SaleItemSummary',
                    'UserLogSummary', 'SaleInvoiceDetail','SaleDailyBySaleRep','SetLocation'
                ),
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

    public function actionSaleInvoice()
    {
        $this->canViewReport();

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Invoice';

        $data = $this->commonData($grid_id,$title,'show','_header');

        $data['grid_columns'] = ReportColumn::getSaleInvoiceColumns();
        $data['data_provider'] = $data['report']->saleInvoice();

        $this->setLocation($data['report']->location_id);

        $this->renderView($data);


    }

    public function actionSaleInvoiceDetail($id)
    {
        $this->canViewReport();

        $report = new Report;

        $data['report'] = $report;
        $data['sale_id'] = $id;

        $data['grid_id'] = 'rpt-sale-invoice-grid';
        $data['title'] = Yii::t('app','Sale Invoice Detail #') .' ' . $id  ;

        $data['grid_columns'] = ReportColumn::getSaleInvoiceDetailColumns();

        $report->sale_id = $id;
        $data['data_provider'] = $report->saleInvoiceDetail();

        $this->renderView($data);

    }

    public function actionSaleDaily()
    {

        $this->canViewReport();

        $grid_id = 'rpt-sale-daily-grid';
        $title = 'Sale Daily';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleDailyColumns();
        $data['data_provider'] = $data['report']->saleDaily();

        $this->renderView($data);
    }

    public function actionSaleDailyBySaleRep()
    {

        $this->canViewReport();

        $grid_id = 'rpt-sale-daily-by-salerep-grid';
        $title = 'Close Register';

        $data = $this->commonData($grid_id,$title,null,'_header','_grid','show');

        $data['grid_columns'] = ReportColumn::getSaleDailyBySaleRepColumns();
        $data['data_provider'] = $data['report']->saleDailyBySaleRep();

        $this->renderView($data);
    }

    public function actionSaleItemSummary()
    {
        $this->canViewReport();

        $grid_id = 'rpt-sale-item-summary-grid';
        $title = 'Sale Item Summary';

        $data = $this->commonData($grid_id,$title,'show','_header');

        $data['grid_columns'] = ReportColumn::getSaleItemSummaryColumns();
        $data['data_provider'] = $data['report']->saleItemSummary();

        $this->renderView($data);

    }

    public function actionUserLogSummary($period = 'today')
    {
        $this->canViewReport();

        $grid_id = 'rpt-user-log-summary-grid';
        $title = 'User Log Summary';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getUserLogSummaryColumns();
        $data['data_provider'] = $data['report']->UserLogSummary();

        $this->renderView($data);
    }

    public function actionSaleInvoiceItem($sale_id, $employee_id)
    {
        $model = new SaleItem('search');
        $model->unsetAttributes();  // clear any default values

        $payment = new SalePayment('search');
        //$payment->unsetAttributes();
        //$employee=Employee::model()->findByPk((int)$employee_id);
        //$cashier=$employee->first_name . ' ' . $employee->last_name;

        if (isset($_GET['SaleItem']))
            $model->attributes = $_GET['SaleItem'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'sale-item-grid') {
                $this->render('sale_item', array(
                    'model' => $model,
                    'payment' => $payment,
                    'sale_id' => $sale_id,
                    'employee_id' => $employee_id
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('sale_item', array('model' => $model, 'payment' => $payment, 'sale_id' => $sale_id, 'employee_id' => $employee_id), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('sale_item', array('model' => $model));
        }
    }

    public function actionTransaction($period = 'today')
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values
        $date_view = 0;

        if (!empty($_GET['Report']['sale_id'])) {
            $report->sale_id = $_GET['Report']['sale_id'];
        }
  
        switch ($period) {
            case 'today':
                $from_date = date('d-m-Y');
                $to_date = date('d-m-Y');
                break;
            case 'yesterday':
                $from_date = date('d-m-Y', strtotime('-1 day'));
                $to_date = date('d-m-Y', strtotime('-1 day'));
                break;
            case 'thismonth':
                $from_date = date('01-m-Y');
                $to_date = date('d-m-Y');
                break;
            case 'lastmonth':
                $from_date = date('01-m-Y', strtotime("-1 month"));
                $d = new DateTime($from_date);
                $to_date = $d->format('t-m-Y');
                //$to_date=$d->format('Y-m-t',strtotime($from_date)); // will fail after year 2038
                break;
            case 'choose':
                if (isset($_GET['Report'])) {
                    $report->attributes = $_GET['Report'];
                    $from_date = $_GET['Report']['from_date'];
                    $to_date = $_GET['Report']['to_date'];
                    $date_view = 1;
                } else {
                    $from_date = date('d-m-Y');
                    $to_date = date('d-m-Y');
                    $date_view = 1;
                }
                $view_file='sale_ajax_period';
                break;
        }

        if (!empty($_GET['Report']['receive_id'])) {
            $report->receive_id = $_GET['Report']['receive_id'];
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
                'jquery.yiigridview.js' => false,
                'jquery.ba-bbq.min.js'=>false,
            );
            if (isset($_GET['ajax']) && $_GET['ajax'] == 'receive-grid') {
                $this->render('receive', array(
                    'report' => $report, 'from_date' => $from_date, 'to_date' => $to_date, 'date_view' => $date_view,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('receive_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date, 'date_view' => $date_view), true, true),
                ));
            }
        } else {
            $this->render('receive', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date, 'date_view' => $date_view));
        }
    }

    public function actionTransactionItem($receive_id, $employee_id, $remark)
    {
        $model = new ReceivingItem('search');
        $model->unsetAttributes();  // clear any default values
        //$employee=Employee::model()->findByPk((int)$employee_id);
        //$cashier=$employee->first_name . ' ' . $employee->last_name;

        if (isset($_GET['SaleItem']))
            $model->attributes = $_GET['SaleItem'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'receive-item-grid') {
                $this->render('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark));
        }
    }

    public function actionSaleSummary()
    {

        $report = new Report;
        //$report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('sale_summary_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('sale_summary', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionSaleHourly()
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            //$from_date=$_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            //$from_date=date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        //$report->from_date=$from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('sale_hourly_ajax', array('report' => $report, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('sale_hourly', array('report' => $report, 'to_date' => $to_date));
        }
    }

    public function actionPayment()
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            /*
              Yii::app()->clientScript->scriptMap['*.js'] = false;
              Yii::app()->clientScript->scriptMap['*.css'] = false;
              $this->renderPartial('sale_daily', array('report' => $report,'from_date'=>$from_date,'to_date'=>$to_date),false,true);
              Yii::app()->end();
             * 
             */
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('payment_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('payment', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionDailyProfit()
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('sale_daily_profit_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('sale_daily_profit', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionTopProduct()
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('topproduct_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('topproduct', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionInventory($filter = 'all')
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'inventory-grid') {
                $this->render('inventory', array('report' => $report, 'filter' => $filter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('inventory_ajax', array('report' => $report, 'filter' => $filter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('inventory', array('report' => $report, 'filter' => $filter));
        }
    }

    public function actionItemExpiry($mfilter = '1')
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'rpt-item-expiry-grid') {
                $this->render('item_expiry', array('report' => $report, 'mfilter' => $mfilter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('item_expiry_ajax', array('report' => $report, 'mfilter' => $mfilter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('item_expiry', array('report' => $report, 'mfilter' => $mfilter));
        }
    }

    public function actionItemInactive($mfilter = '1')
    {
        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'rpt-item-inactive-grid') {
                $this->render('item_expiry', array('report' => $report, 'mfilter' => $mfilter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('item_inactive_ajax', array('report' => $report, 'mfilter' => $mfilter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('item_inactive', array('report' => $report, 'mfilter' => $mfilter));
        }
    }

    public function actionItemAsset()
    {
        $report = new Report;
        $this->render('item_asset', array('report' => $report));
    }

    public function actionUserLogDt($employee_id,$full_name)
    {
        $model = new UserLog('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['UserLog']))
            $model->attributes = $_GET['UserLog'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
     
            if (isset($_GET['ajax']) && $_GET['ajax'] == 'user-log-summary-grid') {
                $this->render('user_log_dt', array(
                    'model' => $model,
                    'employee_id' => $employee_id,
                    'full_name' => $full_name,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('user_log_dt', array('model' => $model,'employee_id' => $employee_id,'full_name' => $full_name,), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('user_log_dt', array('model' => $model,'employee_id' => $employee_id,'full_name' => $full_name,));
        }
    }

    protected function setLocation($location_id)
    {
        Yii::app()->shoppingCart->setRptLocation($location_id);
    }

    protected function renderView($data, $view_name='index')
    {
        if (Yii::app()->request->isAjaxRequest && !isset($_GET['ajax']) ) {
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            Yii::app()->clientScript->scriptMap['*.js'] = false;

            $this->renderPartial('partial/_grid', $data);
        } else {
            $this->render($view_name, $data);
        }
    }

    protected function renderSubView($data)
    {
        $this->renderPartial('partial/_grid', $data);
    }

    protected function canViewReport()
    {
        if (!Yii::app()->user->checkAccess('report.index')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    /**
     * @param $grid_id
     * @param $title
     * @param $advance_search :  to indicate whether there is an advance search text box
     * @param $header_view
     * @param $grid_view
     * @return mixed
     */
    protected function commonData($grid_id,$title,$advance_search=null,$header_view='_header',$grid_view='_grid',$employee_search=null)
    {
        $report = new Report;

        $data['report'] = $report;
        $data['from_date'] = isset($_GET['Report']['from_date']) ? $_GET['Report']['from_date'] : date('d-m-Y');
        $data['to_date'] = isset($_GET['Report']['to_date']) ? $_GET['Report']['to_date'] : date('d-m-Y');
        $data['search_id'] = isset($_GET['Report']['search_id']) ? $_GET['Report']['search_id'] : '';
        $data['location_id'] = isset($_GET['Report']['location_id']) ? $_GET['Report']['location_id'] : Common::getCurLocationID();
        $data['employee_id'] = isset($_GET['Report']['employee_id']) ? $_GET['Report']['employee_id'] : Common::getEmployeeID();
        $data['advance_search'] = $advance_search;
        $data['employee_search'] = $employee_search;
        $data['header_tab'] = '';

        $data['grid_id'] = $grid_id;
        $data['title'] = Yii::t('app', $title) . ' ' . Yii::t('app',
                'From') . ' ' . $data['from_date'] . '  ' . Yii::t('app', 'To') . ' ' . $data['to_date'];
        $data['header_view'] = $header_view;
        $data['grid_view'] = $grid_view;

        $data['report']->from_date = $data['from_date'];
        $data['report']->to_date = $data['to_date'];
        $data['report']->search_id = $data['search_id'];
        $data['report']->location_id = $data['location_id'];
        $data['report']->employee_id = $data['employee_id'];

        return $data;
    }
    

}
