<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogTag;
use CHttpException;
use app\modules\main\components\DAdminController;

class TagAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \app\modules\crud\components\DAdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\modules\crud\components\DCreateAction::class,
            'update' => \app\modules\crud\components\DUpdateAction::class,
            'delete' => \app\modules\crud\components\DDeleteAction::class,
            'view' => \app\modules\crud\components\DViewAction::class,
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
