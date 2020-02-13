<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use app\modules\blog\models\Category;
use yii\test\ActiveFixture;

class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/blog_categories.php';
}
