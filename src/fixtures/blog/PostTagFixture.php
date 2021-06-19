<?php

declare(strict_types=1);

namespace app\fixtures\blog;

use app\modules\blog\models\PostTag;
use yii\test\ActiveFixture;

class PostTagFixture extends ActiveFixture
{
    public $modelClass = PostTag::class;
    public $dataFile = __DIR__ . '/post-tag.php';
    public $depends = [
        PostFixture::class,
        TagFixture::class,
    ];
}
