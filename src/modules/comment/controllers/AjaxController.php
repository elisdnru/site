<?php

namespace app\modules\comment\controllers;

use app\modules\comment\models\Comment;
use app\components\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

    public function actionDelete($id): ?Response
    {
        $model = $this->loadModel($id);

        if (!Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        if (!(Yii::$app->moduleManager->allowed('comment') || $model->user_id == Yii::$app->user->id)) {
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

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: '/');
        }
        return null;
    }

    public function actionHide($id): ?Response
    {
        if (!Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model = $this->loadModel($id);

        if (!(Yii::$app->moduleManager->allowed('comment') || $model->user_id == Yii::$app->user->id)) {
            throw new ForbiddenHttpException();
        }

        $model->public = $model->public ? 0 : 1;

        if (!$model->save()) {
            throw new BadRequestHttpException('Ошибка');
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(Yii::$app->request->getReferrer() ?: '/');
        }
        return null;
    }

    public function actionLike($id): int
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

    protected function loadModel($id): Comment
    {
        $model = Comment::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Комментарий не найден');
        }
        return $model;
    }
}
