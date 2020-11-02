<?php

namespace app\modules\comment\controllers;

use app\modules\comment\forms\CommentEditForm;
use app\modules\comment\models\Comment;
use app\components\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
    public function actionUpdate(int $id)
    {
        $model = $this->loadModel($id);

        $form = new CommentEditForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->text = $form->text;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Ваш коментарий сохранён');
                return $this->redirect($model->getUrl());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    private function loadModel(int $id): Comment
    {
        $model = Comment::find()
            ->published()
            ->andWhere(['id' => $id])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        if (!($model->user_id === Yii::$app->user->id || Yii::$app->moduleAdminAccess->isGranted('comment'))) {
            throw new ForbiddenHttpException();
        }

        return $model;
    }
}
