<?php

Yii::import('application.modules.crud.components.*');

class TagAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'DAdminAction',
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => 'DCreateAction',
            'update' => 'DUpdateAction',
            'delete' => 'DDeleteAction',
            'view' => 'DViewAction',
        ];
    }

    public function createModel()
    {
        return new BlogTag();
    }

    public function loadModel($id)
    {
        $model = BlogTag::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
