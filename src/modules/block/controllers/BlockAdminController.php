<?php

namespace app\modules\block\controllers;

use app\modules\block\models\Block;
use CHttpException;
use app\modules\main\components\DAdminController;

class BlockAdminController extends DAdminController
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
