<?php

namespace app\modules\user\controllers;

use app\modules\user\models\Access;
use CActiveForm;
use CHttpException;
use app\modules\main\components\DController;
use app\modules\user\models\User;
use Yii;

class ProfileController extends DController
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
            'index' => \app\modules\crud\components\DUpdateAction::class,
            'view' => \app\modules\crud\components\DViewAction::class,
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
        return $model;
    }
}
