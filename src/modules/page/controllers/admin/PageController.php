<?php

namespace app\modules\page\controllers\admin;

use CHttpException;
use app\components\AdminController;
use app\modules\page\models\Page;
use Yii;

class PageController extends AdminController
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
                'class' => \app\components\crud\actions\AdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\components\crud\actions\CreateAction::class,
            'update' => \app\components\crud\actions\UpdateAction::class,
            'delete' => \app\components\crud\actions\DeleteAction::class,
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function beforeDelete($model)
    {
        if ($model->system) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }

    public function createModel()
    {
        $model = new Page();
        $model->date = time();
        $model->parent_id = Yii::app()->request->getParam('parent', 0);
        return $model;
    }

    public function loadModel($id)
    {
        $model = Page::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        if ($model->date === '0000-00-00') {
            $model->date = date('Y-m-d');
        }
        return $model;
    }
}