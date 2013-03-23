<?php

Yii::import('crud.components.*');
Yii::import('user.models.*');

class UsersController extends DController
{
    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DIndexAction',
                'view'=>'index',
                'ajaxView'=>'_loop'
            ),
        );
    }

    public function actionSelf()
    {
        $user = $this->getUser();

        if ($user)
            $this->redirect($user->url);
        else
            throw new CHttpException(403, 'Необходимо авторизоваться');
    }

    public function actionShow($username)
    {
        $model = $this->loadModel($username);

        $this->render('show', array(
            'model'=>$model,
        ));
    }

    public function getIndexProviderModel()
    {
        return User::model()->cache(3600);
    }

    public function loadModel($username)
    {
        $model = User::model()->findByAttributes(array('username'=>$username));
        if($model===null)
            throw new CHttpException(404, 'Пользователь не найден');
        return $model;
    }
}
