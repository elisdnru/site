<?php

namespace app\modules\menu\controllers;

use CHttpException;
use app\components\AdminController;
use app\modules\menu\models\Menu;

class MenuAdminController extends AdminController
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
            'toggle' => [
                'class' => \app\modules\crud\components\ToggleAction::class,
                'attributes' => ['visible']
            ],
            'delete' => \app\modules\crud\components\DeleteAction::class,
            'view' => \app\modules\crud\components\ViewAction::class,
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
