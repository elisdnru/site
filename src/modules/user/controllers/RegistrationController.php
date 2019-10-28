<?php

namespace app\modules\user\controllers;

use app\components\actions\CaptchaAction;
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
            'captcha' => [
                'class' => CaptchaAction::class,
            ],
        ];
    }

    public function actionRequest(): string
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

                    $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Пользователь не добавлен');
                }
            }
        }
        return $this->render('request', ['model' => $model]);
    }

    public function actionConfirm($code): string
    {
        $user = User::findOne(['confirm' => $code]);

        if ($user) {
            $user->confirm = '';
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Регистрация подтверждена');
                $this->redirect(['default/login']);
            }
            Yii::$app->session->setFlash('error', 'Ошибка');
        } else {
            Yii::$app->session->setFlash('error', 'Запись о подтверждении не найдена');
        }

        return $this->render('confirm');
    }
}
