<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Tag;
use CHttpException;
use app\components\AdminController;

class TagController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => [
                'class' => \app\components\crud\actions\AdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\components\crud\actions\CreateAction::class,
            'update' => \app\components\crud\actions\UpdateAction::class,
            'delete' => \app\components\crud\actions\DeleteAction::class,
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function createModel(): Tag
    {
        return new Tag();
    }

    public function loadModel($id): Tag
    {
        $model = Tag::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
