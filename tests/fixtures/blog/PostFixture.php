<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use app\modules\blog\models\Post;
use tests\fixtures\user\UserFixture;
use yii\test\ActiveFixture;

class PostFixture extends ActiveFixture
{
    public $modelClass = Post::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/blog_posts.php';
    public $depends = [
        CategoryFixture::class,
        GroupFixture::class,
        UserFixture::class,
    ];
}
