<?php

Yii::import('application.modules.crud.components.*');

class DefaultController extends DController
{
    const FILES_UPLOAD_COUNT = 7;

    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DIndexAction',
                'view'=>'index',
                'ajaxView'=>'_loop',
                'pageSize'=>Yii::app()->config->get('USERPHOTO.ITEMS_PER_PAGE'),
            ),
        );
    }

    public function getIndexProviderModel()
    {
        $user = User::model()->findByAttributes(array('username'=>Yii::app()->request->getQuery('username', 0)));
        if($user === null)
            throw new CHttpException(404, 'Не найдено');

        return UserPhoto::model()->user($user->id);
    }
}
