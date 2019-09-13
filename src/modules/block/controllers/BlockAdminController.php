<?php

namespace app\modules\block\controllers;

use Block;
use CHttpException;
use DAdminController;

class BlockAdminController extends DAdminController
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
