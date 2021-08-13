<?php

declare(strict_types=1);

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Comment;
use app\modules\blog\models\Post;
use app\modules\comment\components\CommentAdminController;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

final class CommentController extends CommentAdminController
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
