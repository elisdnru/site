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
    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
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

    public function actions()
    {
        return [
            'view' => \app\components\crud\actions\ViewAction::class,
            'edit' => \app\components\crud\actions\UpdateAction::class,
        ];
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'settings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function loadModel($id)
    {
        $model = User::model()->findByPk(Yii::app()->user->id);
        $model->scenario = 'settings';
        if ($model === null) {
            throw new CHttpException(403, 'Войдите или зарегистрируйтесь');
        }
        if ($model->create_datetime === '0000-00-00 00:00:00') {
            $model->create_datetime = '1900-01-01 00:00:00';
        }
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }
        return $model;
    }
}
