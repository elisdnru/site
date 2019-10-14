<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use CActiveRecord;
use CHttpException;
use app\modules\comment\components\CommentAdminController as Base;

class CommentController extends Base
{
    protected function loadMaterialModel($id): CActiveRecord
    {
        $model = Post::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Материал не найден');
        }
        return $model;
    }

    protected function getModelName(): string
    {
        return Comment::class;
    }
}
