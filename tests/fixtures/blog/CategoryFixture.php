<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use yii\test\ActiveFixture;

class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/blog_categories.php';
}