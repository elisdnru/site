<?php

declare(strict_types=1);

namespace app\fixtures\blog;

use app\modules\blog\models\Post;
use app\fixtures\user\UserFixture;
use yii\test\ActiveFixture;

class PostFixture extends ActiveFixture
{
    public $modelClass = Post::class;
    public $dataFile = __DIR__ . '/post.php';
    public $depends = [
        CategoryFixture::class,
        GroupFixture::class,
        UserFixture::class,
    ];
}
