<?php

namespace app\modules\portfolio\models;

use app\components\validators\v1\ExistOrEmpty;
use app\components\category\models\TreeCategory;

/**
 * @property Category[] $child_items
 */
class Category extends TreeCategory
{
    public $urlRoute = '/portfolio/default/category';

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'portfolio_categories';
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['parent_id', ExistOrEmpty::class, 'className' => self::class, 'attributeName' => 'id'],
        ]);
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(parent::relations(), [
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
            'child_items' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'child_items.sort ASC'
            ],
            'items_count' => [self::STAT, Work::class, 'category_id',
                'condition' => 'public = 1',
            ],
        ]);
    }
}
