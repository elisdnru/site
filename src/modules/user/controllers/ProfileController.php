<?php

namespace app\modules\user\controllers;

use app\components\Controller;
use app\modules\user\forms\PasswordForm;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Профиль сохранён.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionPassword()
    {
        $model = $this->loadModel();

        $form = PasswordForm::fromUser($model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->password_hash = $model->hashPassword($form->password);
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Пароль сохранён.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('password', [
            'model' => $form,
        ]);
    }

    public function actionView(): string
    {
        $model = $this->loadModel();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    private function loadModel(): User
    {
        $model = User::findOne(Yii::$app->user->id);
        if ($model === null) {
            throw new ForbiddenHttpException('Войдите или зарегистрируйтесь');
        }
        return $model;
    }
}
