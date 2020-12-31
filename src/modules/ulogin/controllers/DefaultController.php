<?php

namespace app\modules\ulogin\controllers;

use yii\web\Controller;
use app\modules\ulogin\models\ULoginModel;
use Yii;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionLogin(Request $request, Session $session, User $user): Response
    {
        if (!$token = $request->post('token')) {
            return $this->redirect(Yii::$app->homeUrl);
        }
        if ($token !== 'undefined') {
            $uLogin = new ULoginModel();
            $uLogin->attributes = $request->post();

            $uLogin->loadAuthData();

            if (!($uLogin->validate() && $uLogin->login($user))) {
                $session->setFlash('error', 'Возможно этот Email используется в другом аккаунте');
            }
        } else {
            $session->setFlash('error', 'Какая-то техническая ошибка при авторизации');
        }

        return $this->redirect($request->get('return', Yii::$app->homeUrl));
    }
}
