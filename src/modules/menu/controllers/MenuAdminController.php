<?php

namespace app\modules\menu\controllers;

use CHttpException;
use DAdminController;
use Menu;

class MenuAdminController extends DAdminController
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
            'toggle' => [
                'class' => \DToggleAction::class,
                'attributes' => ['visible']
            ],
            'delete' => \DDeleteAction::class,
            'view' => \DViewAction::class,
        ];
    }

    public function createModel()
    {
        $model = new Menu();
        $model->visible = 1;
        return $model;
    }

    public function loadModel($id)
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
