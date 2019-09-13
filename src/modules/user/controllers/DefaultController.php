<?php

namespace app\modules\user\controllers;

use Access;
use CActiveForm;
use DController;
use DUrlRulesHelper;
use LoginForm;
use RemindForm;
use User;
use Yii;

DUrlRulesHelper::import('user');

class DefaultController extends DController
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => \DCaptchaAction::class,
            ],
        ];
    }

    public function actionLogin()
    {
        $user = $this->getUser();
        if ($user) {
            $this->redirect($user->url);
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

    public function actionRelogin()
    {
        Yii::app()->user->logout();
        $this->redirect(['login']);
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : Yii::app()->homeUrl);
    }

    public function actionRegistration()
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

    public function actionConfirm($code)
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

    public function actionRemind()
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

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && (in_array($_POST['ajax'], ['login-form', 'remind-form', 'register-form']))) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
