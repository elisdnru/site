<?php

namespace app\modules\menu\controllers\admin;

use app\components\crud\actions\CreateAction;
use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\IndexAction;
use app\components\crud\actions\ToggleAction;
use app\components\crud\actions\UpdateAction;
use app\components\crud\actions\ViewAction;
use CHttpException;
use app\components\AdminController;
use app\modules\menu\models\Menu;

class MenuController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'update' => UpdateAction::class,
            'toggle' => [
                'class' => ToggleAction::class,
                'attributes' => ['visible']
            ],
            'delete' => DeleteAction::class,
            'view' => ViewAction::class,
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
