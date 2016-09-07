<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class GetsetSession extends CApplicationComponent
{

    //private $quantity;

    private $session;

    //private $decimal_place;

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($value)
    {
        $this->session = $value;
    }

    public function getLocationId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_id'])) {
            $this->setLocationId(array());
        }
        return $this->session['location_id'];
    }

    public function setLocationId($location_id)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_id'] = $location_id;
    }
    
    public function getLocationCode()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_code'])) {
            $this->setLocationId(array());
        }
        return $this->session['location_code'];
    }

    public function setLocationCode($location_id)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_code'] = $location_id;
    }
    
    public function getLocationName()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_name'])) {
            $this->setLocationName(array());
        }
        return $this->session['location_name'];
    }

    public function setLocationName($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_name'] = $location_data;
    }
    
    public function getLocationNameKH()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_namekh'])) {
            $this->setLocationName(array());
        }
        return $this->session['location_namekh'];
    }

    public function setLocationNameKH($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_namekh'] = $location_data;
    }
    
    public function getLocationPhone()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_phone'])) {
            $this->setLocationPhone(array());
        }
        return $this->session['location_phone'];
    }

    public function setLocationPhone($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_phone'] = $location_data;
    }
    
    public function getLocationPhone1()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_phone1'])) {
            $this->setLocationPhone1(array());
        }
        return $this->session['location_phone1'];
    }

    public function setLocationPhone1($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_phone1'] = $location_data;
    }
    
    public function getLocationAddress()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_address'])) {
            $this->setLocationAddress(array());
        }
        return $this->session['location_address'];
    }

    public function setLocationAddress($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_address'] = $location_data;
    }
    
    public function getLocationAddress1()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_address1'])) {
            $this->setLocationAddress(array());
        }
        return $this->session['location_address1'];
    }

    public function setLocationAddress1($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_address1'] = $location_data;
    }
    
    public function getLocationAddress2()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_address2'])) {
            $this->setLocationAddress(array());
        }
        return $this->session['location_address2'];
    }

    public function setLocationAddress2($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_address2'] = $location_data;
    }
   
    
    public function setLocationWifi($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_wifi'] = $location_data;
    }
    
    public function getLocationWifi()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_wifi'])) {
            $this->setLocationAddress(array());
        }
        return $this->session['location_wifi'];
    }
    
    public function getLocationEmail()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_email'])) {
            $this->setLocationEmail(array());
        }
        return $this->session['location_email'];
    }

    public function setLocationEmail($location_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_email'] = $location_data;
    }
    
    public function getLocationPrinterFood()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['printer_food'])) {
            $this->setLocationPrinterFood(array());
        }
        return $this->session['printer_food'];
    }

    public function setLocationPrinterFood($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['printer_food'] = $data;
    }
    
    public function getLocationPrinterBeverage()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['printer_beverage'])) {
            $this->setLocationPrinterFood(array());
        }
        return $this->session['printer_beverage'];
    }

    public function setLocationPrinterBeverage($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['printer_beverage'] = $data;
    }
    
    public function getLocationPrinterReceipt()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['printer_receipt'])) {
            $this->setLocationPrinterFood(array());
        }
        return $this->session['printer_receipt'];
    }

    public function setLocationPrinterReceipt($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['printer_receipt'] = $data;
    }

    public function getLocationVat()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['location_vat'])) {
            $this->setLocationVat(array());
        }
        return $this->session['location_vat'];
    }

    public function setLocationVat($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['location_vat'] = $data;
    }

}

?>
