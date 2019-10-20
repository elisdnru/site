<?php

namespace app\modules\block\controllers\admin;

use app\modules\block\models\Block;
use app\modules\block\models\search\BlockSearch;
use CHttpException;
use app\components\AdminController;

class BlockController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => \app\components\crud\actions\v2\IndexAction::class,
            'create' => \app\components\crud\actions\v2\CreateAction::class,
            'update' =>  \app\components\crud\actions\v2\UpdateAction::class,
            'delete' => \app\components\crud\actions\v2\DeleteAction::class,
            'view' => \app\components\crud\actions\v2\ViewAction::class,
        ];
    }

    public function createSearchModel(): Block
    {
        return new BlockSearch();
    }

    public function createModel(): Block
    {
        return new Block();
    }

    public function loadModel($id): Block
    {
        $model = Block::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
