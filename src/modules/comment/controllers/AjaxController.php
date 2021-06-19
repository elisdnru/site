<?php

declare(strict_types=1);

namespace app\modules\comment\controllers;

use app\components\module\admin\AdminAccess;
use app\modules\comment\models\Comment;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;

class AjaxController extends Controller
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
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new BadRequestHttpException('Ошибка удаления');
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

        if (!$model->save()) {
            throw new BadRequestHttpException('Ошибка');
        }

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: '/');
        }
        return null;
    }

    public function actionLike(int $id, Session $session): int
    {
        $model = $this->loadModel($id);

        $model->toggleLike($session);

        if (!$model->save()) {
            throw new BadRequestHttpException('Ошибка');
        }

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
