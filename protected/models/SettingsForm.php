<?php
class SettingsForm extends CFormModel
{
    
   /* public $exchange_rate = array(
        'USD2KHR' => '',
        //'USD2THB' => '',
        //'THB2KHR' =>'',
    );*/
    /*public $site = array(
        'companyName' => '',
        'companyAddress' => '',
        'companyAddress1' => '',
        'companyPhone' => '',
        'currencySymbol' => '',
        'altcurrencySymbol' => '',
        'email' => '',
        'returnPolicy' => '',
    );*/
    public $system = array(
        'language' => '',
        'decimalPlace'=>'',
        'itemNumberPerPage' => '',
    );
    /*public $sale = array(
        'saleCookie'=>'',
        'receiptPrint' => '',
        'receiptPrintDraftSale'=>'',
        'touchScreen'=>'',
        'discount'=>'',
    );
    public $receipt = array(
        'printcompanyLogo' => '',
        'printcompanyName'=>'',
        'printcompanyAddress'=>'',
        'printcompanyAddress1'=>'',
        'printcompanyPhone'=>'',
        'printtransactionTime'=>'',
        'printSignature'=>'',
    );*/
   
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function getAttributesLabels($key)
    {
        $keys = array(
            'companyName' => Yii::t('app','Company Name'),
            'companyAddress' => Yii::t('app','Company Address (House, Street)'),
            'companyAddress1' => Yii::t('app','Company Address1 (State, City)'),
            'companyPhone' => Yii::t('app','Company Phone'),
            'currencySymbol' => Yii::t('app','Currency Symbol'),
            'altcurrencySymbol' => Yii::t('app','Secondary Currency Symbol'),
            'email' => Yii::t('app','E-Mail'),
            'returnPolicy' => Yii::t('app','Return Policy'),
            'language'=> Yii::t('app','Language'),
            'receiptPrint' => Yii::t('app','Print Receipt After Sale'),
            'receiptPrintDraftSale'=> Yii::t('app','Print Receipt Draft Sale'),
            'USD2KHR' => Yii::app()->settings->get('site', 'currencySymbol') . ' To '  . Yii::app()->settings->get('site', 'altcurrencySymbol'),
            'decimalPlace' => Yii::t('app','Number of Decimal Place'),
            'itemNumberPerPage' => Yii::t('app','Item Number Per Page'),
            'touchScreen' => Yii::t('app','Touch Screen Sale'),
            'saleCookie' => Yii::t('app','Do you want to remember customer\'s item on sale ?'),
            'discount' => Yii::t('app','Have Discount in Sale Grid?'),
            'printcompanyLogo' => Yii::t('app','Print Company Logo'),
            'printcompanyName'=> Yii::t('app','Print Company Name'),
            'printcompanyAddress'=> Yii::t('app','Print Company Address'),
            'printcompanyPhone'=> Yii::t('app','Print Company Phone'),
            'printtransactionTime'=> Yii::t('app','Print Transaction Time'),
            'printSignature'=> Yii::t('app','Print Signature (Customer & Chashier)'),
        );
 
        if(array_key_exists($key, $keys)) {
            return $keys[$key];
        }    
 
        $label = trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $key))));
        $label = preg_replace('/\s+/', ' ', $label);
 
        if (strcasecmp(substr($label, -3), ' id') === 0)
            $label = substr($label, 0, -3);
 
        return ucwords($label);
    }
 
    /**
     * Sets attribues values
     * @param array $values
     * @param boolean $safeOnly
     */
    public function setAttributes($values,$safeOnly=true) 
    { 
        if(!is_array($values)) {
            return; 
        }    
            
        foreach($values as $category=>$values) 
        { 
            if(isset($this->$category)) {
                $cat = $this->$category;
                foreach ($values as $key => $value) {
                    if(isset($cat[$key])){
                        $cat[$key] = $value;
                    }
                }
                $this->$category = $cat;
            }
        } 
    }
}
?>
