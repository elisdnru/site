<?php

namespace app\modules\block\controllers\admin;

use app\components\crud\actions\v2\CreateAction;
use app\components\crud\actions\v2\DeleteAction;
use app\components\crud\actions\v2\IndexAction;
use app\components\crud\actions\v2\UpdateAction;
use app\components\crud\actions\v2\ViewAction;
use app\modules\block\models\Block;
use app\modules\block\forms\BlockSearch;
use CHttpException;
use app\components\AdminController;

class BlockController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'update' =>  UpdateAction::class,
            'delete' => DeleteAction::class,
            'view' => ViewAction::class,
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
