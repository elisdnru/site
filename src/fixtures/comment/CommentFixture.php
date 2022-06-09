<?php

declare(strict_types=1);

namespace app\fixtures\comment;

use app\fixtures\blog\PostFixture;
use app\fixtures\user\UserFixture;
use app\modules\comment\models\Comment;
use yii\test\ActiveFixture;

final class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $dataFile = __DIR__ . '/data/comment.php';
    public $depends = [
        PostFixture::class,
        UserFixture::class,
    ];
}
