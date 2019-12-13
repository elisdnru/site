<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\TreeCategoryV2 as Base;

class TreeCategoryV2 extends Base
{
    public $urlRoute = '/category';

    public static function tableName(): string
    {
        return 'test_tree_categories';
    }
}
