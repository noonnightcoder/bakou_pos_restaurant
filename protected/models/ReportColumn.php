<?php

class ReportColumn extends CModel
{

    public function attributeNames()
    {
        return array(
            'id',
            'sale_id',
            'sale_time',
            'date_report',
            'sub_total',
            'discount_amount',
            'vat_amount',
            'total',
            'cross_profit',
            'profit',
            'margin',
        );
    }

    /**
     * Helper function to get example grid columns
     * @return array
     */
    public static function getSaleInvoiceColumns()
    {
        return array(
            array('name' => 'sale_id',
                'header' => Yii::t('app', 'Invoice ID'),
                'value' => '$data["sale_id"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('Report/saleInvoiceDetail'),
            ),
            array('name' => 'sale_time',
                'header' => Yii::t('app', 'Sale Time'),
                'value' => '$data["sale_time"]',
            ),
            array('name' => 'location_name_kh',
                'header' => Yii::t('app', 'Sold @'),
                'value' => '$data["location_name_kh"]',
            ),
            array('name' => 'employee_id',
                'header' => Yii::t('app', 'Sold By'),
                'value' => '$data["employee_name"]',
            ),
            /*
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            */
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'discount',
                'header' => Yii::t('app', 'Discount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'status',
                'header' => Yii::t('app', 'Status'),
                'value' => '$data["status_f"]',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                //'header'=>'Invoice Detail',
                'template' => '<div class="btn-group">{view}{print}{cancel}{edit}</div>',
                'buttons' => array(
                    'view' => array(
                        'click' => 'updateDialogOpen',
                        'label' => 'Detail',
                        'url' => 'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["sale_id"],"employee_id"=>$data["employee_name"]))',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'Invoice Detail'),
                            'title' => Yii::t('app', 'Invoice Detail'),
                            'class' => 'btn btn-xs btn-info',
                            'id' => uniqid(),
                            'on' => false,
                        ),
                    ),
                    'print' => array(
                        'label' => 'print',
                        'icon' => 'glyphicon-print',
                        'url' => 'Yii::app()->createUrl("saleItem/Receipt", array("sale_id"=>$data["sale_id"]))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invoice Printing'),
                            'class' => 'btn btn-xs btn-success',
                        ),
                        'visible' => 'Yii::app()->user->checkAccess("invoice.print")',
                    ),
                    'cancel' => array(
                        'label' => 'cancel',
                        'icon' => 'glyphicon-trash',
                        'url' => 'Yii::app()->createUrl("sale/delete", array("sale_id"=>$data["sale_id"], "customer_id"=>$data["client_id"]))',
                        'options' => array(
                            'title' => Yii::t('app', 'Cancel Invoice'),
                            'class' => 'btnCancelInvoice btn btn-xs btn-danger',
                        ),
                        'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("invoice.delete")',
                    ),
                    'edit' => array(
                        'label' => 'edit',
                        'icon' => 'glyphicon-edit',
                        'url' => 'Yii::app()->createUrl("SaleItem/EditSale", array("sale_id"=>$data["sale_id"],"customer_id" => $data["client_name"],"paid_amount"=>$data["paid"]))',
                        'options' => array(
                            'title' => Yii::t('app', 'Edit Invoice'),
                            'class' => 'btn btn-xs btn-warning',
                        ),
                        'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("invoice.update")',
                    ),
                ),
            ),
        );
    }

    public static function getSaleInvoiceDetailColumns()
    {
        return array(
            array('name'=>'name',
                'header'=>Yii::t('app','Item Name'),
                'value'=>'$data["name"]',
            ),
            array('name'=>'quantity',
                'header'=>Yii::t('app','QTY'),
                'value' =>'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array('name'=>'price',
                'header'=>Yii::t('app','Price'),
                'value' =>'number_format($data["price"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array('name'=>'sub_total',
                'header'=>Yii::t('app','Sub Total'),
                'value' =>'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getSaleDailyColumns() {
        return array(
            array('name'=>'date',
                'header'=>Yii::t('app','Date'),
                'value'=>'$data["date_report"]',
            ),
            array('name'=>'quantity',
                'header'=>Yii::t('app','QTY'),
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                'value' =>'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                //'footer'=>number_format($report->saleDailyTotals()[0],Common::getDecimalPlace(), ".", ","),
                //'footerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array('name'=>'sub_total',
                'header'=>Yii::t('app','Sub Total'),
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                'value' =>'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name'=>'discount',
                'header'=>Yii::t('app','Discount'),
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                'value' =>'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
            ),
            /*
            array('name'=>'vat',
                'header'=>Yii::t('app','VAT'),
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                'value' =>'number_format($data["vat_amount"],Common::getDecimalPlace(), ".", ",")',
            ),
            */
            array('name'=>'total',
                'header'=>Yii::t('app','Total'),
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                'value' =>'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                //'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleDailyTotals()[3],Common::getDecimalPlace(), ".", ","),
                //'footerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getSaleItemSummaryColumns() {
        return array(
            array('name'=>'item_name',
                'header'=>Yii::t('app','Item Name'),
                'value'=>'$data["item_name"]',
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array('name'=>'date_report',
                'header'=>Yii::t('app','Date'),
                'value' =>'$data["date_report"]',
            ),
            array('name'=>'quantity',
                'header'=>Yii::t('app','QTY'),
                'value' =>'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array('name'=>'sub_total',
                'header'=>Yii::t('app','Sub Total'),
                'value' =>'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions'=>array('style' => 'text-align: right;'),
                'headerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getUserLogSummaryColumns()
    {
        return array(
            array('name' => 'fullname',
                'header' => Yii::t('app', 'Full Name'),
                'value' => '$data["fullname"]',
            ),
            array('name' => 'date_log',
                'header' => Yii::t('app', 'Date Log'),
                'value' => '$data["date_log"]',
            ),
            array('name' => 'nlog',
                'header' => Yii::t('app', '# Log'),
                'value' => 'number_format($data["nlog"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            )
        );
    }

}