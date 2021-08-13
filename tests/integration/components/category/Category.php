<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\Category as Base;

final class Category extends Base
{
    public string $urlRoute = '/category';

    public static function tableName(): string
    {
        return 'test_categories';
    }
}
