<?php

namespace app\modules\comment\controllers;

use app\modules\user\models\User;
use CHttpException;
use app\modules\comment\models\Comment;
use app\modules\comment\forms\CommentForm;
use app\components\Controller;
use Yii;

class CommentController extends Controller
{
    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'accessControl',
        ]);
    }

    public function accessRules(): array
    {
        return [
            ['allow',
                'actions' => ['update'],
                'users' => ['?'],
            ],
            ['deny',
                'actions' => ['*'],
                'users' => ['*'],
            ],
        ];
    }

    public function actionUpdate($id): string
    {
        $model = $this->loadModel($id);

        $form = new CommentForm('useredit');
        $form->yqe1 = 1;

        $user = $this->loadUser();

        $form->attributes = $model->attributes;

        if ($post = Yii::$app->request->post('CommentForm')) {
            $form->attributes = $post;

            if ($form->validate()) {
                $model->attributes = $form->attributes;

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Ваш коментарий сохранён');
                    $this->redirect($model->getUrl());
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $form,
            'user' => $user,
        ]);
    }

    private function loadModel($id): Comment
    {
        $query = Comment::find()->andWhere(['id' => $id]);

        if (!Yii::$app->moduleManager->allowed('comment')) {
            $query->published();
        }

        $model = $query->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }

    private function loadUser(): ?User
    {
        return User::findOne(Yii::$app->user->id);
    }
}
