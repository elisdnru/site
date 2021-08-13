<?php

declare(strict_types=1);

namespace tests\fixtures\portfolio;

use app\modules\portfolio\models\Category;
use yii\test\ActiveFixture;

final class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/portfolio_categories.php';
}
