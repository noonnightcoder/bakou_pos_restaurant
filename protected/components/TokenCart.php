<?php
if (!defined('YII_PATH')) {
    exit('No direct script access allowed');
}

class TokenCart extends CApplicationComponent
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

    public function getUniqueToken()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['unique_token'])) {
            $this->setUniqueToken(array());
        }
        return $this->session['unique_token'];
    }

    public function setUniqueToken($token_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['unique_token'] = $token_data;
    }
    
    public function clearAll()
    {
        $this->emptyCart();
    }

}

?>
