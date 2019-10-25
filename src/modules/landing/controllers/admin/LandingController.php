<?php

namespace app\modules\landing\controllers\admin;

use app\components\crud\actions\CreateAction;
use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\IndexAction;
use app\components\crud\actions\UpdateAction;
use app\components\crud\actions\ViewAction;
use CHttpException;
use app\components\AdminController;
use app\modules\landing\models\Landing;
use Yii;

class LandingController extends AdminController
{
    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + deleteFile',
        ]);
    }

    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'update' => UpdateAction::class,
            'delete' => DeleteAction::class,
            'view' => ViewAction::class,
        ];
    }

    public function beforeDelete($model): void
    {
        if ($model->system) {
            throw new CHttpException(403, 'Отказано в доступе');
        }
    }

    public function createModel(): Landing
    {
        $model = new Landing();
        $model->parent_id = Yii::app()->request->getParam('parent');
        return $model;
    }

    public function loadModel($id): Landing
    {
        $model = Landing::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }
        return $model;
    }
}
