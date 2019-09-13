<?php

namespace app\modules\blog\controllers;

use BlogTag;
use CHttpException;
use DAdminController;

class TagAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \DAdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \DCreateAction::class,
            'update' => \DUpdateAction::class,
            'delete' => \DDeleteAction::class,
            'view' => \DViewAction::class,
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
