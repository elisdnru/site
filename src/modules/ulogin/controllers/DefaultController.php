<?php

namespace app\modules\ulogin\controllers;

use app\modules\main\components\DController;
use app\modules\ulogin\models\UloginModel;
use Yii;

class DefaultController extends DController
{
    public function actionLogin()
    {
        if (!empty($_POST['token'])) {
            if ($_POST['token'] != 'undefined') {
                $ulogin = new UloginModel();
                $ulogin->attributes = $_POST;

                $ulogin->getAuthData();

                if ($ulogin->validate() && $ulogin->login()) {
                } else {
                    Yii::app()->user->setFlash('error', 'Возможно этот Email используется в другом аккаунте');
                }
            } else {
                Yii::app()->user->setFlash('error', 'Какая-то техническая ошибка при авторизации');
            }

            $return = Yii::app()->request->getParam('return');
            $this->redirect($return ? $return : Yii::app()->homeUrl);
        } else {
            $this->redirect(Yii::app()->homeUrl, true);
        }
    }
}
