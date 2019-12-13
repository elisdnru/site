<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use yii\test\ActiveFixture;

class CategoryV2Fixture extends ActiveFixture
{
    public $modelClass = CategoryV2::class;
    public $dataFile = __DIR__ . '/_data/test_categories.php';
}
