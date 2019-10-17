<?php

namespace app\modules\user\controllers;

use app\modules\user\models\Access;
use CActiveForm;
use app\components\Controller;
use app\modules\user\forms\LoginForm;
use app\modules\user\forms\RemindForm;
use app\modules\user\models\User;
use Yii;

class DefaultController extends Controller
{
    public function actions(): array
    {
        return [
            'captcha' => [
                'class' => \app\components\actions\CaptchaAction::class,
            ],
        ];
    }

    public function actionLogin(): void
    {
        $user = $this->loadUser();
        if ($user) {
            $this->redirect(Yii::app()->createUrl('/user/profile/view'));
        }

        $model = new LoginForm();

        $this->performAjaxValidation($model);

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('login', ['model' => $model]);
    }

    public function actionRelogin(): void
    {
        Yii::app()->user->logout();
        $this->redirect(['login']);
    }

    public function actionLogout(): void
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->request->urlReferrer ?: Yii::app()->homeUrl);
    }

    public function actionRegistration(): void
    {
        $model = new User(User::SCENARIO_REGISTER);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->validate()) {
                $model->role = Access::ROLE_USER;

                if ($model->save()) {
                    $model->sendCommit();
                    Yii::app()->user->setFlash('register-form', 'Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме');

                    $this->refresh();
                } else {
                    Yii::app()->user->setFlash('register-form', 'Пользователь не добавлен');
                }
            }
        }
        $this->render('register', ['model' => $model]);
    }

    public function actionConfirm($code): void
    {
        $user = User::model()->find([
            'condition' => 'confirm = :code',
            'params' => [':code' => $code]
        ]);

        if ($user) {
            $user->confirm = '';
            if ($user->save()) {
                Yii::app()->user->setFlash('confirm-message', 'Регистрация подтверждена');
            } else {
                Yii::app()->user->setFlash('confirm-message', 'Ошибка');
            }
        } else {
            Yii::app()->user->setFlash('confirm-message', 'Запись о подтверждении не найдена');
        }

        $this->render('confirm');
    }

    public function actionRemind(): void
    {
        $model = new RemindForm();

        if (isset($_POST['RemindForm'])) {
            $model->attributes = $_POST['RemindForm'];

            $this->performAjaxValidation($model);

            if ($model->validate()) {
                $user = User::model()->findByAttributes(['email' => $model->email]);

                if ($user) {
                    $user->new_password = mb_substr(md5(microtime()), 0, 10, 'UTF-8');
                    $user->new_confirm = $user->new_password;

                    if ($user->save()) {
                        $user->sendRemind();
                        Yii::app()->user->setFlash('remind-message', 'Новые параметры отправлены на Email');
                        $this->refresh();
                    }
                } else {
                    Yii::app()->user->setFlash('remind-message', 'Пользователь не найден');
                }
            } else {
                Yii::app()->user->setFlash('remind-message', 'Пользователь не найден');
            }
        }

        $this->render('remind', ['model' => $model]);
    }

    protected function performAjaxValidation($model): void
    {
        if (isset($_POST['ajax']) && (in_array($_POST['ajax'], ['login-form', 'remind-form', 'register-form']))) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function loadUser(): ?User
    {
        return User::model()->findByPk(Yii::app()->user->id);
    }
}
