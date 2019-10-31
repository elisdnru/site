<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use CActiveRecord;
use app\modules\comment\components\CommentAdminController as Base;
use yii\web\NotFoundHttpException;

class CommentController extends Base
{
    protected function loadMaterialModel($id): CActiveRecord
    {
        $model = Post::model()->findByPk((int)$id);
        if ($model === null) {
            throw new NotFoundHttpException('Материал не найден');
        }
        return $model;
    }

    protected function getModelName(): string
    {
        return Comment::class;
    }
}
