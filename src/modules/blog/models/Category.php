<?php

namespace app\modules\blog\models;

use app\components\category\models\TreeCategory;

class Category extends TreeCategory
{
    public $urlRoute = '/blog/default/category';

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'blog_categories';
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
            'children' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'children.sort ASC'
            ],
        ]);
    }
}
