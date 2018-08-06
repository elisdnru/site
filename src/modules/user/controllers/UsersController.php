<?php

Yii::import('application.modules.crud.components.*');
Yii::import('application.modules.user.models.*');

class UsersController extends DController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'DIndexAction',
                'view' => 'index',
                'ajaxView' => '_loop'
            ],
        ];
    }

    public function actionSelf()
    {
        $user = $this->getUser();

        if ($user) {
            $this->redirect($user->url);
        } else {
            throw new CHttpException(403, 'Необходимо авторизоваться');
        }
    }

    public function actionShow($username)
    {
        $model = $this->loadModel($username);

        $this->render('show', [
            'model' => $model,
        ]);
    }

    public function getIndexProviderModel()
    {
        return User::model()->cache(0, new Tags('user'));
    }

    public function loadModel($username)
    {
        $model = User::model()->findByAttributes(['username' => $username]);
        if ($model === null) {
            throw new CHttpException(404, 'Пользователь не найден');
        }
        return $model;
    }
}
