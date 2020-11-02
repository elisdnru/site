<?php

namespace app\modules\user\controllers;

use app\components\Controller;
use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionLogin(Request $request)
    {
        $user = $this->loadUser();
        if ($user) {
            return $this->redirect(Url::to(['/user/profile/view']));
        }

        $model = new LoginForm();

        if ($model->load($request->post()) && $model->validate() && $model->login()) {
            return $this->redirect(Yii::$app->user->returnUrl);
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionRelogin(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionLogout(Request $request): Response
    {
        Yii::$app->user->logout();
        return $this->redirect($request->getReferrer() ?: Yii::$app->homeUrl);
    }

    private function loadUser(): ?User
    {
        return User::findOne(Yii::$app->user->id);
    }
}
