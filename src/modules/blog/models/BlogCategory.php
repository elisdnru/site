<?php

namespace app\modules\blog\models;

use app\components\module\DUrlRulesHelper;
use TreeCategory;

DUrlRulesHelper::import('blog');

/**
 * This is the model class for table "{{blog_category}}".
 */
class BlogCategory extends TreeCategory
{
    public $urlRoute = '/blog/default/category';
    public $indent = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BlogCategory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{blog_category}}';
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
            'posts_count' => [self::STAT, \app\modules\blog\models\BlogPost::class, 'category_id'],
            'posts' => [self::HAS_MANY, \app\modules\blog\models\BlogPost::class, 'category_id'],
            'child_items' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'child_items.sort ASC'
            ],
            'items_count' => [self::STAT, \app\modules\blog\models\BlogPost::class, 'category_id',
                'condition' => 'public = 1',
            ],
        ]);
    }
}
