<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use CHttpException;
use app\modules\comment\components\CommentAdminController as Base;

class CommentAdminController extends Base
{
    protected function loadMaterialModel($id)
    {
        $model = Post::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Материал не найден');
        }
        return $model;
    }

    protected function getModelName()
    {
        return Comment::class;
    }
}
