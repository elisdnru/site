<?php

declare(strict_types=1);

namespace app\modules\ulogin\controllers;

use app\modules\ulogin\models\ULoginModel;
use BadMethodCallException;
use Yii;
use yii\web\Application;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionLogin(Request $request, Session $session, User $user): Response
    {
        if (!Yii::$app instanceof Application) {
            throw new BadMethodCallException('Not web app context.');
        }

        if (!$token = (string)$request->getBodyParam('token')) {
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

        return $this->redirect((string)$request->getQueryParam('return', Yii::$app->homeUrl));
    }
}
