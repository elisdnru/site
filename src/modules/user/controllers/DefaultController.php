<?php

declare(strict_types=1);

namespace app\modules\user\controllers;

use app\modules\user\forms\LoginForm;
use app\modules\user\models\User;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\User as WebUser;

/**
 * @psalm-api
 */
final class DefaultController extends Controller
{
    public function actionLogin(Request $request, WebUser $webUser): Response|string
    {
        $user = $this->loadUser((int)$webUser->id);
        if ($user) {
            return $this->redirect(Url::to(['/user/profile/view']));
        }

        $model = new LoginForm();

        if ($model->load((array)$request->post()) && $model->validate() && $model->login($webUser)) {
            return $this->redirect($webUser->returnUrl);
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout(Request $request, WebUser $webUser): Response
    {
        $webUser->logout();
        return $this->redirect($request->getReferrer() ?: ['/home/default/index']);
    }

    private function loadUser(int $id): ?User
    {
        return User::findOne($id);
    }
}
