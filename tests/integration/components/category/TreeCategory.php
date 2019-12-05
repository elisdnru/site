<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\TreeCategory as Base;

class TreeCategory extends Base
{
    public $urlRoute = '/category';

    public function tableName(): string
    {
        return 'test_tree_categories';
    }

    public function relations(): array
    {
        return array_merge(parent::relations(), [
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
        ]);
    }
}
