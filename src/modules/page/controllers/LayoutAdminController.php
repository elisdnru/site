<?php

namespace app\modules\page\controllers;

use CHttpException;
use app\modules\main\components\DAdminController;
use PageLayout;

class LayoutAdminController extends DAdminController
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
        $model = new PageLayout();
        return $model;
    }

    public function loadModel($id)
    {
        $model = PageLayout::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
