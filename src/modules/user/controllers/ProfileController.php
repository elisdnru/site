<?php

namespace app\modules\user\controllers;

use app\components\Controller;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class ProfileController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEdit()
    {
        $model = $this->loadModel();
        $model->scenario = 'settings';

        if ($model->create_datetime === '0000-00-00 00:00:00') {
            $model->create_datetime = '1900-01-01 00:00:00';
        }
        if ($model->last_visit_datetime === '0000-00-00 00:00:00') {
            $model->last_visit_datetime = null;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Профиль сохранён.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionView(): string
    {
        $model = $this->loadModel();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function loadModel(): User
    {
        $model = User::findOne(Yii::$app->user->id);
        if ($model === null) {
            throw new ForbiddenHttpException('Войдите или зарегистрируйтесь');
        }
        return $model;
    }
}
