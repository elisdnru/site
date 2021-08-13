<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use yii\test\ActiveFixture;

final class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;
    public $dataFile = __DIR__ . '/_data/test_categories.php';
}
