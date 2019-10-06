<?php

namespace app\modules\block\controllers;

use app\modules\block\models\Block;
use CHttpException;
use app\components\AdminController;

class BlockAdminController extends AdminController
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
            'delete' => \app\modules\crud\components\DeleteAction::class,
            'view' => \app\modules\crud\components\ViewAction::class,
        ];
    }

    public function createModel()
    {
        return new Block();
    }

    public function loadModel($id)
    {
        $model = Block::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
