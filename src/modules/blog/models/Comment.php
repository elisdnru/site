<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\modules\comment\models\Comment as BaseComment;

final class Comment extends BaseComment
{
    public const TYPE_OF_COMMENT = Post::class;

    public function getMaterial(): ?Post
    {
        return Post::findOne($this->material_id);
    }
}
