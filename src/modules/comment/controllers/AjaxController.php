<?php

namespace app\modules\comment\controllers;

use app\modules\comment\models\Comment;
use app\components\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
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

    public function actionDelete(int $id, Request $request, User $user): ?Response
    {
        $model = $this->loadModel($id);

        if (!$user->id) {
            throw new ForbiddenHttpException();
        }

        if (!(Yii::$app->moduleAdminAccess->isGranted('comment') || $model->user_id == $user->id)) {
            throw new ForbiddenHttpException();
        }

        if ($model->children) {
            $model->public = false;
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

    public function actionHide(int $id, Request $request, User $user): ?Response
    {
        if (!$user->id) {
            throw new ForbiddenHttpException();
        }

        $model = $this->loadModel($id);

        if (!(Yii::$app->moduleAdminAccess->isGranted('comment') || $model->user_id == $user->id)) {
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

    public function actionLike(int $id): int
    {
        $model = $this->loadModel($id);

        if (!$model->getLiked()) {
            $model->likes++;
            $model->setLiked(true);
        } else {
            $model->likes--;
            $model->setLiked(false);
        }

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
