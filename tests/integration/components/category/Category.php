<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\Category as Base;

class Category extends Base
{
    public $urlRoute = '/category';

    public function tableName(): string
    {
        return 'test_categories';
    }
}
