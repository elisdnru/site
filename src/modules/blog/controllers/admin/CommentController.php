<?php

declare(strict_types=1);

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use app\modules\comment\components\CommentAdminController;
use Override;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * @psalm-api
 */
final class CommentController extends CommentAdminController
{
    #[Override]
    protected function loadMaterialModel(int $id): ActiveRecord
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    #[Override]
    protected function getType(): ?string
    {
        return Post::class;
    }
}
