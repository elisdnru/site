<?php

Yii::import('crud.components.*');

class DefaultController extends DController
{
    const FILES_UPLOAD_COUNT = 7;

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

    public function getIndexProviderModel()
    {
        $user = User::model()->findByAttributes(array('username'=>Yii::app()->request->getQuery('id', 0)));
        if($user === null)
            throw new CHttpException(404, 'Не найдено');

        return UserPhoto::model()->user($user->id);
    }
}
