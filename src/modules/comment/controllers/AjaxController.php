<?php

namespace app\modules\comment\controllers;

use CHttpException;
use app\modules\comment\models\Comment;
use app\components\Controller;
use Yii;

class AjaxController extends Controller
{
    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + delete, hide, like',
        ]);
    }

    public function actionDelete($id): void
    {
        $model = $this->loadModel($id);

        if (!Yii::app()->user->id) {
            throw new CHttpException(403);
        }

        if (!(Yii::$app->moduleManager->allowed('comment') || $model->user_id == Yii::app()->user->id)) {
            throw new CHttpException(403);
        }

        if ($model->children) {
            $model->public = false;
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new CHttpException(400, 'Ошибка удаления');
        }

        $this->redirectOrAjax(Yii::$app->request->getReferrer() ?: '/');
    }

    public function actionHide($id): void
    {
        if (!Yii::app()->user->id) {
            throw new CHttpException(403);
        }

        $model = $this->loadModel($id);

        if (!(Yii::$app->moduleManager->allowed('comment') || $model->user_id == Yii::app()->user->id)) {
            throw new CHttpException('403');
        }

        $model->public = $model->public ? 0 : 1;

        if (!$model->save()) {
            throw new CHttpException(400, 'Ошибка');
        }

        $this->redirectOrAjax(Yii::$app->request->getReferrer() ?: '/');
    }

    public function actionLike($id): void
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
            throw new CHttpException(400, 'Ошибка');
        }

        echo $model->likes;
        Yii::app()->end();
    }

    protected function loadModel($id): Comment
    {
        $model = Comment::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Комментарий не найден');
        }
        return $model;
    }
}
