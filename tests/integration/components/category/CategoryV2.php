<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\CategoryV2 as Base;

class CategoryV2 extends Base
{
    protected $urlRoute = '/category';

    public static function tableName(): string
    {
        return 'test_categories';
    }
}
