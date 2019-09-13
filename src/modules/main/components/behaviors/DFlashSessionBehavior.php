<?php

namespace app\modules\main\components\behaviors;

use CBehavior;
use Yii;

class DFlashSessionBehavior extends CBehavior
{
    public function initFlashSession()
    {
        if (isset($_POST['SESSION_ID'])) {
            $session = Yii::app()->getSession();
            $session->close();
            $session->sessionID = $_POST['SESSION_ID'];
            $session->open();
        }
    }
}
