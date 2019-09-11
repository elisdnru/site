<?php

namespace app\modules\menu\controllers;

use CHttpException;
use DAdminController;
use Menu;
use Yii;

Yii::import('application.modules.crud.components.*');
Yii::import('application.modules.page.models.*');

class MenuAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'DAdminAction',
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => 'DCreateAction',
            'update' => 'DUpdateAction',
            'toggle' => [
                'class' => 'DToggleAction',
                'attributes' => ['visible']
            ],
            'delete' => 'DDeleteAction',
            'view' => 'DViewAction',
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
