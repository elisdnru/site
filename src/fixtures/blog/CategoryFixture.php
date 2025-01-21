<?php

declare(strict_types=1);

namespace app\fixtures\blog;

use app\modules\blog\models\Category;
use yii\test\ActiveFixture;

/**
 * @psalm-api
 */
final class CategoryFixture extends ActiveFixture
{
    public $modelClass = Category::class;
    public $dataFile = __DIR__ . '/data/category.php';
}
