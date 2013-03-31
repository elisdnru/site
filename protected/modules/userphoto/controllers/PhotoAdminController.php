<?php

Yii::import('application.modules.crud.components.*');

class PhotoAdminController extends DAdminController
{
    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DAdminAction',
                'view'=>'index',
                'ajaxView'=>'_grid'
            ),
            'update'=>'DUpdateAction',
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('public')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function createModel()
    {
        $model = new UserPhoto();
        return $model;
    }

    public function loadModel($id)
    {
        $model = UserPhoto::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}