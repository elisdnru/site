<?php

namespace app\modules\user\controllers\admin;

use app\components\crud\actions\v2\CreateAction;
use app\components\crud\actions\v2\DeleteAction;
use app\components\crud\actions\v2\IndexAction;
use app\components\crud\actions\v2\UpdateAction;
use app\components\crud\actions\v2\ViewAction;
use app\modules\user\forms\UserSearch;
use CActiveForm;
use CHttpException;
use app\components\AdminController;
use app\modules\user\models\User;
use Yii;

class UserController extends AdminController
{
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

    public function createSearchModel(): User
    {
        return new UserSearch();
    }

    public function createModel(): User
    {
        return new User(['scenario' => User::SCENARIO_ADMIN_CREATE]);
    }

    public function loadModel($id): User
    {
        $model = User::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }
        return $model;
    }
}
