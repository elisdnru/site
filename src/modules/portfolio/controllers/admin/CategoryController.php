<?php

namespace app\modules\portfolio\controllers\admin;

use app\components\crud\actions\CreateAction;
use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\IndexAction;
use app\components\crud\actions\UpdateAction;
use app\components\crud\actions\ViewAction;
use CHttpException;
use app\components\AdminController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;

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
        $count = Work::find()->category($model->id)->count();
        if ($count) {
            throw new CHttpException(400, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
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
