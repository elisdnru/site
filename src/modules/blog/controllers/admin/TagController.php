<?php

namespace app\modules\blog\controllers\admin;

use app\components\crud\actions\CreateAction;
use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\IndexAction;
use app\components\crud\actions\UpdateAction;
use app\components\crud\actions\ViewAction;
use app\modules\blog\models\Tag;
use CHttpException;
use app\components\AdminController;

class TagController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'update' => UpdateAction::class,
            'delete' => DeleteAction::class,
            'view' => ViewAction::class,
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
