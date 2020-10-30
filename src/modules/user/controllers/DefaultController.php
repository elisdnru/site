<?php

namespace app\modules\user\controllers;

use app\components\Controller;
use app\modules\user\forms\LoginForm;
use app\modules\user\forms\RemindForm;
use app\modules\user\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionLogin()
    {
        $user = $this->loadUser();
        if ($user) {
            return $this->redirect(Url::to(['/user/profile/view']));
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->login()) {
            return $this->redirect(Yii::$app->user->returnUrl);
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionRelogin(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->request->getReferrer() ?: Yii::$app->homeUrl);
    }

    public function actionRemind()
    {
        $model = new RemindForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findOne(['email' => $model->email]);

            if ($user) {
                $password = mb_substr(md5(microtime()), 0, 10, 'UTF-8');
                $user->password_hash = $user->hashPassword($password);

                if ($user->save()) {
                    $user->sendRemind($password);
                    Yii::$app->session->setFlash('success', 'Новые параметры отправлены на Email');
                    return $this->redirect(['login']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Пользователь не найден');
            }
        }

        return $this->render('remind', [
            'model' => $model,

        ]);
    }

    private function loadUser(): ?User
    {
        return User::findOne(Yii::$app->user->id);
    }
}
