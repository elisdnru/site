<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use app\components\AdminController;
use app\modules\portfolio\models\PortfolioCategory;
use app\modules\portfolio\models\PortfolioWork;

class CategoryAdminController extends AdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \app\modules\crud\components\AdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\modules\crud\components\CreateAction::class,
            'update' => \app\modules\crud\components\UpdateAction::class,
            'delete' => \app\modules\crud\components\DeleteAction::class,
            'view' => \app\modules\crud\components\ViewAction::class,
        ];
    }

    public function beforeDelete($model)
    {
        $count = PortfolioWork::model()->count(
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
        return new PortfolioCategory();
    }

    public function loadModel($id)
    {
        $model = PortfolioCategory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
