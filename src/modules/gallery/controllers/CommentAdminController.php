<?php

Yii::import('application.modules.comment.components.*');

class CommentAdminController extends CommentAdminControllerBase
{
    protected function loadMaterialModel($id)
    {
        $model = GalleryPhoto::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Материал не найден');
        }
        return $model;
    }

    protected function getModelName()
    {
        return 'GalleryPhotoComment';
    }
}
