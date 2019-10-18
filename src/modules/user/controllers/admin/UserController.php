<?php

namespace app\modules\user\controllers\admin;

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
            'index' => [
                'class' => \app\components\crud\actions\AdminAction::class,
                'view' => 'index',
            ],
            'create' => \app\components\crud\actions\CreateAction::class,
            'update' => \app\components\crud\actions\UpdateAction::class,
            'toggle' => [
                'class' => \app\components\crud\actions\ToggleAction::class,
                'attributes' => ['active']
            ],
            'delete' => \app\components\crud\actions\DeleteAction::class,
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function createModel(): User
    {
        return new User(User::SCENARIO_ADMIN_CREATE);
    }

    public function loadModel($id): User
    {
        $model = User::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }
        return $model;
    }

    public function performAjaxValidation($model): void
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
