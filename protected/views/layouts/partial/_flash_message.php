<?php
if ($message_type == 'flash') {
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message .
            '<button class="close" data-dismiss="alert" type="button">
              <i class="ace-icon fa fa-times"></i>
          </button>' .
            "</div>\n";
    }
} else {

    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        if (isset($key)) {
            $this->renderPartial('//layouts/partial/_gritter_notification',
                array(
                    'title' => 'Error',
                    'gritter_key' => 'gritter-' . $key,
                    'message' => $message
                ));
        }
    }
}

