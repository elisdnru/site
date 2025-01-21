<?php

declare(strict_types=1);

namespace app\modules\comment\controllers;

use app\components\module\admin\AdminAccess;
use app\modules\comment\forms\CommentEditForm;
use app\modules\comment\models\Comment;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;

/**
 * @psalm-api
 */
final class CommentController extends Controller
{
    public function actionUpdate(
        int $id,
        Request $request,
        Session $session,
        User $user,
        AdminAccess $access
    ): Response|string {
        $model = $this->loadModel($id, (int)$user->id, $access);

        $form = new CommentEditForm($model);

        if ($form->load((array)$request->post()) && $form->validate()) {
            $model->text = $form->text;
            $model->save();
            $session->setFlash('success', 'Ваш комментарий сохранён');
            return $this->redirect($model->getUrl());
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    private function loadModel(int $id, int $userId, AdminAccess $access): Comment
    {
        /** @var Comment|null $model */
        $model = Comment::find()
            ->published()
            ->andWhere(['id' => $id])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        if (!($model->user_id === $userId || $access->isGranted('comment'))) {
            throw new ForbiddenHttpException();
        }

        return $model;
    }
}
