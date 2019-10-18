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

    public function actionUpdate($id): void
    {
        $model = $this->loadModel($id);

        $form = new CommentForm('useredit');
        $form->yqe1 = 1;

        $user = $this->loadUser();

        $form->attributes = $model->attributes;

        if (isset($_POST['CommentForm'])) {
            $form->attributes = $_POST['CommentForm'];

            if ($form->validate()) {
                $model->attributes = $form->attributes;

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Ваш коментарий сохранён');
                    $this->redirect($model->getUrl());
                }
            }
        }

        $this->render('update', [
            'model' => $model,
            'form' => $form,
            'user' => $user,
        ]);
    }

    protected function loadModel($id): Comment
    {
        if (Yii::app()->moduleManager->allowed('comment')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = Comment::model()->findByPk($id, $condition);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }

    private function loadUser(): ?User
    {
        return User::model()->findByPk(Yii::app()->user->id);
    }
}
