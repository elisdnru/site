<?php

namespace app\modules\ulogin\controllers;

use app\components\Controller;
use app\modules\ulogin\models\UloginModel;
use Yii;

class DefaultController extends Controller
{
    public function actionLogin(): void
    {
        if ($token = Yii::$app->request->post('token')) {
            if ($token !== 'undefined') {
                $ulogin = new UloginModel();
                $ulogin->attributes = Yii::$app->request->post();

                $ulogin->getAuthData();

                if (!($ulogin->validate() && $ulogin->login())) {
                    Yii::$app->session->setFlash('error', 'Возможно этот Email используется в другом аккаунте');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Какая-то техническая ошибка при авторизации');
            }

            $this->redirect(Yii::$app->request->get('return', Yii::$app->homeUrl));
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }
    }
}
