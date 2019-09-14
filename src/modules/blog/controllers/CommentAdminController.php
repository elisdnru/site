<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogPostComment;
use CHttpException;
use app\modules\comment\components\CommentAdminControllerBase;

class CommentAdminController extends CommentAdminControllerBase
{
    protected function loadMaterialModel($id)
    {
        $model = BlogPost::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Материал не найден');
        }
        return $model;
    }

    protected function getModelName()
    {
        return BlogPostComment::class;
    }
}
