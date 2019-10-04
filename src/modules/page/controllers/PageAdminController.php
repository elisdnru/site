<?php

namespace app\modules\page\controllers;

use CHttpException;
use app\modules\main\components\AdminController;
use app\modules\page\models\Page;
use Yii;

class PageAdminController extends AdminController
{
    public function filters()
    {
        return array_merge(parent::filters(), [
            'PostOnly + deleteFile',
        ]);
    }

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

    public function beforeUpdate($model)
    {
        $user = $this->getUser();
        if (!$model->allowedForUser($user)) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }

    public function beforeDelete($model)
    {
        $user = $this->getUser();
        if ($model->system || !$model->allowedForUser($user)) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }

    public function createModel()
    {
        $model = new Page();
        $model->parent_id = Yii::app()->request->getParam('parent', 0);
        return $model;
    }

    public function loadModel($id)
    {
        $model = Page::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
