<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

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
