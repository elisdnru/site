<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use yii\test\ActiveFixture;

final class TreeCategoryFixture extends ActiveFixture
{
    public $modelClass = TreeCategory::class;
    public $dataFile = __DIR__ . '/_data/test_tree_categories.php';
}
