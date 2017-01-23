<?php

class MaintenanceController extends CController
{
    public function actionIndex()
    {
        //$this->renderPartial("index");
        $this->redirect('http://app.vitkinghouse.com');
    }
}
?>
