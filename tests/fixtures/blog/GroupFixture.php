<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use yii\test\ActiveFixture;

class GroupFixture extends ActiveFixture
{
    public $modelClass = Group::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/blog_post_groups.php';
}
