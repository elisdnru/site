<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogCategory;
use app\modules\blog\models\BlogPost;
use CHttpException;
use app\modules\main\components\DAdminController;

class CategoryAdminController extends DAdminController
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

    public function beforeDelete($model)
    {
        $count = BlogPost::model()->count(
            [
                'condition' => 't.category_id = :id',
                'params' => [':id' => $model->id]
            ]
        );

        if ($count) {
            throw new CHttpException(402, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
        }
    }

    public function createModel()
    {
        return new BlogCategory();
    }

    public function loadModel($id)
    {
        $model = BlogCategory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
