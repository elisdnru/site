<?php

declare(strict_types=1);

namespace tests\fixtures\comment;

use app\modules\comment\models\Comment;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;
use yii\test\ActiveFixture;

class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $depends = [
        PostFixture::class,
        UserFixture::class,
    ];
}
