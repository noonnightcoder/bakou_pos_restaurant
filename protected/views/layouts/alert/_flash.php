<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message .
        '<button class="close" data-dismiss="alert" type="button">
              <i class="ace-icon fa fa-times"></i>
          </button>' .
        "</div>\n";
}

