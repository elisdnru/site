<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use app\modules\blog\models\Tag;
use yii\test\ActiveFixture;

class TagFixture extends ActiveFixture
{
    public $modelClass = Tag::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/blog_tags.php';
}
