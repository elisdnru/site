<?php

namespace app\modules\portfolio\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;

class CategoryController extends AdminController
{
    public function actions()
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

    public function beforeDelete($model)
    {
        $count = Work::model()->count(
            [
                'condition' => 't.category_id = :ID',
                'params' => [':ID' => $model->id]
            ]
        );

        if ($count) {
            throw new CHttpException(400, 'В данной группе есть записи. Удалите их или переместите в другие категории.');
        }
    }

    public function createModel()
    {
        return new Category();
    }

    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
