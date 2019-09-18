<?php

namespace app\modules\user\controllers;

use app\modules\user\models\Access;
use CActiveForm;
use CHttpException;
use app\modules\main\components\Controller;
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
            'view' => \app\modules\crud\components\ViewAction::class,
            'edit' => \app\modules\crud\components\UpdateAction::class,
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
