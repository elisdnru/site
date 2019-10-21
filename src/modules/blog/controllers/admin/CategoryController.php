<?php

namespace app\modules\blog\controllers\admin;

use app\components\crud\actions\CreateAction;
use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\IndexAction;
use app\components\crud\actions\UpdateAction;
use app\components\crud\actions\ViewAction;
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use CHttpException;
use app\components\AdminController;

class CategoryController extends AdminController
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

    public function beforeDelete($model): void
    {
        $count = Post::model()->count(
            [
                'condition' => 't.category_id = :id',
                'params' => [':id' => $model->id]
            ]
        );

        if ($count) {
            throw new CHttpException(402, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
        }
    }

    public function createModel(): Category
    {
        return new Category();
    }

    public function loadModel($id): Category
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
