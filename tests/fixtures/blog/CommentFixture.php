<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use app\modules\comment\models\Comment;
use tests\fixtures\user\UserFixture;
use yii\test\ActiveFixture;

final class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/comments.php';
    public $depends = [
        PostFixture::class,
        UserFixture::class,
    ];
}
