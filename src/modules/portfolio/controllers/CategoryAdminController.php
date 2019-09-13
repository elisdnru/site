<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use app\modules\main\components\DAdminController;
use PortfolioCategory;
use PortfolioWork;

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
