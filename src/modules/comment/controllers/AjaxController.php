<?php

declare(strict_types=1);

namespace app\modules\comment\controllers;

use app\components\module\admin\AdminAccess;
use app\modules\comment\models\Comment;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;

final class AjaxController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'hide' => ['post'],
                    'like' => ['post'],
                ],
            ],
        ]);
    }

    public function actionDelete(int $id, Request $request, User $user, AdminAccess $access): ?Response
    {
        $model = $this->loadModel($id);

        if (!$user->id) {
            throw new ForbiddenHttpException();
        }

        if (!($access->isGranted('comment') || $model->user_id === $user->id)) {
            throw new ForbiddenHttpException();
        }

        if ($model->children) {
            $model->public = 0;
            $model->save();
        } else {
            $model->delete();
        }

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: '/');
        }
        return null;
    }

    public function actionHide(int $id, Request $request, User $user, AdminAccess $access): ?Response
    {
        if (!$user->id) {
            throw new ForbiddenHttpException();
        }

        $model = $this->loadModel($id);

        if (!($access->isGranted('comment') || $model->user_id === $user->id)) {
            throw new ForbiddenHttpException();
        }

        $model->public = $model->public ? 0 : 1;

        $model->save();

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: '/');
        }
        return null;
    }

    public function actionLike(int $id, Session $session): int
    {
        $model = $this->loadModel($id);

        $model->toggleLike($session);

        $model->save();

        return $model->likes;
    }

    private function loadModel(int $id): Comment
    {
        $model = Comment::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}
