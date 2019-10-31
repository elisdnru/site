<?php

namespace app\modules\user\controllers;

use app\components\actions\MathCaptchaAction;
use app\modules\user\forms\RegistrationForm;
use app\modules\user\models\Access;
use app\components\Controller;
use app\modules\user\models\User;
use Yii;

class RegistrationController extends Controller
{
    public function actions(): array
    {
        return [
            'captcha1' => [
                'class' => MathCaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 42 : null,
            ],
            'captcha2' => [
                'class' => MathCaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 42 : null,
            ],
        ];
    }

    public function actionRequest()
    {
        $model = new RegistrationForm();

        if ($post = Yii::$app->request->post('RegistrationForm')) {
            $model->attributes = $post;

            if ($model->validate()) {
                $user = new User();
                $user->username = $model->username;
                $user->email = $model->email;
                $user->new_password = $model->password;
                $user->lastname = $model->lastname;
                $user->name = $model->name;
                $user->role = Access::ROLE_USER;

                if ($user->save(false)) {
                    $user->sendCommit();
                    Yii::$app->session->setFlash('success', 'Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме');
                    return $this->refresh();
                }

                Yii::$app->session->setFlash('error', 'Пользователь не добавлен');
            }
        }
        return $this->render('request', ['model' => $model]);
    }

    public function actionConfirm($code)
    {
        $user = User::findOne(['confirm' => $code]);

        if ($user) {
            $user->confirm = '';
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Регистрация подтверждена');
                return $this->redirect(['default/login']);
            }
            Yii::$app->session->setFlash('error', 'Ошибка');
        } else {
            Yii::$app->session->setFlash('error', 'Запись о подтверждении не найдена');
        }

        return $this->render('confirm');
    }
}
