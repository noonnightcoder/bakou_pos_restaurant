<?php if ( ! defined('YII_PATH')) exit('No direct script access allowed');
class NavigationWidget extends CWidget
{
    public function run()
    {
        $report=new Report;  
        $this->renderPartial('index',array('report'=>$report));
    }
    
}
?>
