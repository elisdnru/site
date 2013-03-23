<?php

Yii::import('crud.components.*');

class ImageController extends DController
{
    public function filters()
    {
        return array_merge(parent::filters(), array(
            'accessControl',
            'postOnly + delete',
        ));
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
            ),
            array('deny'),
        );

    }

    public function actions()
    {
        return array(
            'create'=>'DCreateAction',
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function beforeCreate($model)
    {
        $count = UserPhoto::model()->user(Yii::app()->user->id)->count();
        $limit = Yii::app()->config->get('USERPHOTO.MAX_COUNT');
        if ($count >= $limit)
            throw new CHttpException(400, 'Разрешено загружать не больше ' . $limit . ' фотографий.');
    }

    public function createModel()
    {
        $model = new UserPhoto();
        $model->user_id = Yii::app()->user->id;
        return $model;
    }

    public function loadModel($id)
    {
        $model = UserPhoto::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');

        if($model->user_id !== Yii::app()->user->id)
            throw new CHttpException(404, 'Не найдено');

        return $model;
    }
}
