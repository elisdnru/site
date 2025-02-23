<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\TreeCategory as Base;
use Override;

final class TreeCategory extends Base
{
    public string $urlRoute = '/category';

    #[Override]
    public static function tableName(): string
    {
        return 'test_tree_categories';
    }
}
