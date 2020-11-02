<?php

namespace app\modules\ulogin\controllers;

use app\components\Controller;
use app\modules\ulogin\models\UloginModel;
use Yii;
use yii\web\Request;
use yii\web\Response;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionLogin(Request $request): Response
    {
        if (!$token = $request->post('token')) {
            return $this->redirect(Yii::$app->homeUrl);
        }
        if ($token !== 'undefined') {
            $uLogin = new UloginModel();
            $uLogin->attributes = $request->post();

            $uLogin->loadAuthData();

            if (!($uLogin->validate() && $uLogin->login())) {
                Yii::$app->session->setFlash('error', 'Возможно этот Email используется в другом аккаунте');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Какая-то техническая ошибка при авторизации');
        }

        return $this->redirect($request->get('return', Yii::$app->homeUrl));
    }
}
