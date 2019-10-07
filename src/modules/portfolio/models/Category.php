<?php

namespace app\modules\portfolio\models;

use app\components\module\UrlRulesHelper;
use app\components\ExistOrEmpty;
use app\components\category\models\TreeCategory;

UrlRulesHelper::import('portfolio');

class Category extends TreeCategory
{
    public $urlRoute = '/portfolio/default/category';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'portfolio_categories';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['parent_id', ExistOrEmpty::class, 'className' => self::class, 'attributeName' => 'id'],
        ]);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(parent::relations(), [
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
            'child_items' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'child_items.sort ASC'
            ],
            'items_count' => [self::STAT, \app\modules\portfolio\models\Work::class, 'category_id',
                'condition' => 'public = 1',
            ],
        ]);
    }
}
