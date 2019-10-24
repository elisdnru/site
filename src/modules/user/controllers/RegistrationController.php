<?php

namespace app\modules\user\controllers;

use app\components\actions\CaptchaAction;
use app\modules\user\models\Access;
use app\components\Controller;
use app\modules\user\forms\LoginForm;
use app\modules\user\forms\RemindForm;
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

    public function actionRequest(): void
    {
        $model = new User(['scenario' => User::SCENARIO_REGISTER]);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->validate()) {
                $model->role = Access::ROLE_USER;

                if ($model->save()) {
                    $model->sendCommit();
                    Yii::app()->user->setFlash('success', 'Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме');

                    $this->refresh();
                } else {
                    Yii::app()->user->setFlash('success', 'Пользователь не добавлен');
                }
            }
        }
        $this->render('request', ['model' => $model]);
    }

    public function actionConfirm($code): void
    {
        $user = User::findOne(['confirm' => $code]);

        if ($user) {
            $user->confirm = '';
            if ($user->save()) {
                Yii::app()->user->setFlash('success', 'Регистрация подтверждена');
                $this->redirect(['default/login']);
            }
            Yii::app()->user->setFlash('error', 'Ошибка');
        } else {
            Yii::app()->user->setFlash('error', 'Запись о подтверждении не найдена');
        }

        $this->render('confirm');
    }
}
