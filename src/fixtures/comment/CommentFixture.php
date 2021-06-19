<?php

declare(strict_types=1);

namespace app\fixtures\comment;

use app\fixtures\blog\PostFixture;
use app\modules\blog\models\Comment;
use app\fixtures\user\UserFixture;
use yii\test\ActiveFixture;

class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $dataFile = __DIR__ . '/comment.php';
    public $depends = [
        PostFixture::class,
        UserFixture::class,
    ];
}
