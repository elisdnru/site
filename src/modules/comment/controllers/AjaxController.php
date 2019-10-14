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

        if (!($this->moduleAllowed('comment') || $model->user_id == Yii::app()->user->id)) {
            throw new CHttpException(403);
        }

        if ($model->child_items) {
            $model->public = false;
            $success = $model->save(false);
        } else {
            $success = $model->delete();
        }

        if (!$success) {
            throw new CHttpException(400, 'Ошибка удаления');
        }

        $this->redirectOrAjax(Yii::app()->request->urlReferrer ?: '/');
    }

    public function actionHide($id): void
    {
        if (!Yii::app()->user->id) {
            throw new CHttpException(403);
        }

        $model = $this->loadModel($id);

        if (!($this->moduleAllowed('comment') || $model->user_id == Yii::app()->user->id)) {
            throw new CHttpException('403');
        }

        $model->public = $model->public ? 0 : 1;

        if (!$model->save()) {
            throw new CHttpException(400, 'Ошибка');
        }

        $this->redirectOrAjax(Yii::app()->request->urlReferrer ?: '/');
    }

    public function actionLike($id): void
    {
        $model = $this->loadModel($id);

        if (!$model->liked) {
            $model->likes++;
            $model->liked = true;
        } else {
            $model->likes--;
            $model->liked = false;
        }

        if (!$model->save()) {
            throw new CHttpException(400, 'Ошибка');
        }

        echo $model->likes;
        Yii::app()->end();
    }

    protected function loadModel($id): Comment
    {
        $model = Comment::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Комментарий не найден');
        }
        return $model;
    }
}
