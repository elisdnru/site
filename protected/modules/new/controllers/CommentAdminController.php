<?php

Yii::import('application.modules.comment.components.CommentAdminControllerBase');

class CommentAdminController extends CommentAdminControllerBase
{
    protected function loadMaterialModel($id)
    {
        $model = News::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Материал не найден');
        return $model;
    }

    protected function getModelName()
    {
        return 'NewsComment';
    }
}