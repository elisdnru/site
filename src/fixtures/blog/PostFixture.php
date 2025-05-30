<?php

declare(strict_types=1);

namespace app\fixtures\blog;

use app\fixtures\user\UserFixture;
use app\modules\blog\models\Post;
use yii\test\ActiveFixture;

/**
 * @psalm-api
 */
final class PostFixture extends ActiveFixture
{
    public $modelClass = Post::class;
    public $dataFile = __DIR__ . '/data/post.php';
    public $depends = [
        CategoryFixture::class,
        GroupFixture::class,
        UserFixture::class,
    ];
}
