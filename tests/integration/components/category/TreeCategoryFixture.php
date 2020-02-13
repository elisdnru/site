<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use yii\test\ActiveFixture;

class TreeCategoryFixture extends ActiveFixture
{
    public $modelClass = TreeCategoryV2::class;
    public $dataFile = __DIR__ . '/_data/test_tree_categories.php';
}
