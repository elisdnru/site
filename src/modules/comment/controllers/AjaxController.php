<?php

namespace app\modules\comment\controllers;

use CHttpException;
use Comment;
use app\modules\main\components\DController;
use Yii;

class AjaxController extends DController
{
    public function filters()
    {
        return array_merge(parent::filters(), [
            'PostOnly + delete, hide, like',
        ]);
    }

    public function actionDelete($id)
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

        $this->redirectOrAjax(Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : '/');
    }

    public function actionHide($id)
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

        $this->redirectOrAjax(Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : '/');
    }

    public function actionLike($id)
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

        if (Yii::app()->request->isAjaxRequest) {
            echo $model->likes;
            Yii::app()->end();
        }

        $this->redirectOrAjax(Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : '/');
    }

    protected function loadModel($id)
    {
        $model = Comment::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Комментарий не найден');
        }
        return $model;
    }
}
