<?php

namespace app\modules\user\controllers;

use app\modules\user\models\Access;
use CActiveForm;
use CHttpException;
use app\components\Controller;
use app\modules\user\models\User;
use Yii;

class ProfileController extends Controller
{
    public function filters(): array
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules(): array
    {
        return [
            ['allow',
                'roles' => [Access::ROLE_USER],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'view' => \app\components\crud\actions\v2\ViewAction::class,
            'edit' => \app\components\crud\actions\v2\UpdateAction::class,
        ];
    }

    public function loadModel(): User
    {
        $model = User::findOne(Yii::app()->user->id);
        if ($model === null) {
            throw new CHttpException(403, 'Войдите или зарегистрируйтесь');
        }
        $model->scenario = 'settings';
        if ($model->create_datetime === '0000-00-00 00:00:00') {
            $model->create_datetime = '1900-01-01 00:00:00';
        }
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }
        return $model;
    }
}
