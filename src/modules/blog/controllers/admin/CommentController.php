<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use app\modules\comment\components\CommentAdminController as Base;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class CommentController extends Base
{
    protected function loadMaterialModel(int $id): ActiveRecord
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    protected function getModelName(): string
    {
        return Comment::class;
    }
}
