<?php

DUrlRulesHelper::import('user');

class DefaultController extends DController
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'DCaptchaAction',
            ),
        );
    }

    public function actionLogin()
    {
        $user = $this->getUser();
        if ($user)
            $this->redirect($user->url);

        $model = new LoginForm();

        $this->performAjaxValidation($model);

        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }

        $this->render('login',array('model'=>$model));
    }

    public function actionRelogin()
    {
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : Yii::app()->homeUrl);
    }

    public function actionRegistration()
    {
        $model = new User(User::SCENARIO_REGISTER);

        if(isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];

            if($model->validate())
            {
                $model->role = Access::ROLE_USER;

                if ($model->save())
                    {
                        if (Yii::app()->config->get('USER.REGISTER_COMMIT'))
                        {
                            $model->sendCommit();
                            Yii::app()->user->setFlash('register-form','Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме');
                        }
                        else
                            Yii::app()->user->setFlash('register-form','Регистрация завершена');

                        $this->refresh();
                    }
                    else
                        Yii::app()->user->setFlash('register-form','Пользователь не добавлен');
            }
        }
        $this->render('register', array('model'=>$model));
    }

    public function actionConfirm($code)
    {
        $user = User::model()->find(array(
            'condition'=>'confirm = :code',
            'params'=>array(':code'=>$code)
        ));

        if ($user)
        {
            $user->confirm = '';
            if ($user->save())
                Yii::app()->user->setFlash('confirm-message','Регистрация подтверждена');
            else
                Yii::app()->user->setFlash('confirm-message','Ошибка');
        }
        else
            Yii::app()->user->setFlash('confirm-message','Запись о подтверждении не найдена');

        $this->render('confirm');
    }

    public function actionRemind()
    {
        $model = new RemindForm();

        if(isset($_POST['RemindForm']))
        {
            $model->attributes=$_POST['RemindForm'];

            $this->performAjaxValidation($model);

            if($model->validate())
            {
                $user = User::model()->findByAttributes(array('email'=>$model->email));

                if ($user)
                {
                    $user->new_password = mb_substr(md5(microtime()), 0, 10, 'UTF-8');
                    $user->new_confirm = $user->new_password;

                    if ($user->save())
                    {
                        $user->sendRemind();
                        Yii::app()->user->setFlash('remind-message','Новые параметры отправлены на Email');
                        $this->refresh();
                    }
                }
                else
                    Yii::app()->user->setFlash('remind-message','Пользователь не найден');
            } else
                Yii::app()->user->setFlash('remind-message','Пользователь не найден');
        }

        $this->render('remind',array('model'=>$model));
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && (in_array($_POST['ajax'], array('login-form', 'remind-form', 'register-form'))))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}