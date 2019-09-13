<?php

namespace app\modules\page\controllers;

use CHttpException;
use DAdminController;
use PageLayout;

class LayoutAdminController extends DAdminController
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
