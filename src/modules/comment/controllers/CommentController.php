<?php

namespace app\modules\comment\controllers;

use app\modules\comment\forms\CommentEditForm;
use app\modules\comment\models\Comment;
use app\components\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Session;
use yii\web\User;

class CommentController extends Controller
{
    public function actionUpdate(int $id, Request $request, Session $session, User $user)
    {
        $model = $this->loadModel($id, (int)$user->id);

        $form = new CommentEditForm($model);

        if ($form->load($request->post()) && $form->validate()) {
            $model->text = $form->text;
            if ($model->save()) {
                $session->setFlash('success', 'Ваш коментарий сохранён');
                return $this->redirect($model->getUrl());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    private function loadModel(int $id, int $userId): Comment
    {
        $model = Comment::find()
            ->published()
            ->andWhere(['id' => $id])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        if (!($model->user_id === $userId || Yii::$app->moduleAdminAccess->isGranted('comment'))) {
            throw new ForbiddenHttpException();
        }

        return $model;
    }
}
