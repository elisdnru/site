<?php

namespace app\modules\menu\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\menu\models\Menu;

class MenuController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => \app\components\crud\actions\IndexAction::class,
            'create' => \app\components\crud\actions\CreateAction::class,
            'update' => \app\components\crud\actions\UpdateAction::class,
            'toggle' => [
                'class' => \app\components\crud\actions\ToggleAction::class,
                'attributes' => ['visible']
            ],
            'delete' => \app\components\crud\actions\DeleteAction::class,
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function createModel(): Menu
    {
        $model = new Menu();
        $model->visible = 1;
        return $model;
    }

    public function loadModel($id): Menu
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
