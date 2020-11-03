<?php

namespace app\modules\user\controllers;

use app\components\MathCaptchaAction;
use app\modules\user\forms\RegistrationForm;
use app\modules\user\models\Access;
use app\components\Controller;
use app\modules\user\models\User;
use yii\web\Request;
use yii\web\Session;

class RegistrationController extends Controller
{
    public function actions(): array
    {
        return [
            'captcha1' => [
                'class' => MathCaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? '42' : null,
            ],
            'captcha2' => [
                'class' => MathCaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? '42' : null,
            ],
        ];
    }

    public function actionRequest(Request $request, Session $session)
    {
        $model = new RegistrationForm();

        if ($post = $request->post('RegistrationForm')) {
            $model->attributes = $post;

            if ($model->validate()) {
                $user = new User();
                $user->username = $model->username;
                $user->email = $model->email;
                $user->password_hash = $user->hashPassword($model->password);
                $user->lastname = $model->lastname;
                $user->firstname = $model->firstname;
                $user->role = Access::ROLE_USER;

                if ($user->save(false)) {
                    $user->sendCommit();
                    $session->setFlash('success', 'Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме');
                    return $this->refresh();
                }

                $session->setFlash('error', 'Пользователь не добавлен');
            }
        }
        return $this->render('request', ['model' => $model]);
    }

    public function actionConfirm(string $code, Session $session)
    {
        $user = User::findOne(['confirm' => $code]);

        if ($user) {
            $user->confirm = '';
            if ($user->save()) {
                $session->setFlash('success', 'Регистрация подтверждена');
                return $this->redirect(['default/login']);
            }
            $session->setFlash('error', 'Ошибка');
        } else {
            $session->setFlash('error', 'Запись о подтверждении не найдена');
        }

        return $this->render('confirm');
    }
}
