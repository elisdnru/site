<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use tests\fixtures\user\UserFixture;
use yii\test\ActiveFixture;

class PostFixture extends ActiveFixture
{
    public $modelClass = Post::class;
    public $depends = [
        CategoryFixture::class,
        GroupFixture::class,
        UserFixture::class,
    ];
}
