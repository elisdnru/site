<?php

namespace app\modules\portfolio\controllers;

use CHttpException;
use DAdminController;
use PortfolioCategory;
use PortfolioWork;

class CategoryAdminController extends DAdminController
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
