<?php

namespace app\modules\blog\models;

use app\components\module\DUrlRulesHelper;
use app\modules\comment\models\Comment;

DUrlRulesHelper::import('blog');

class BlogPostComment extends Comment
{
    const TYPE_OF_COMMENT = BlogPost::class;

    /**
     * Returns the static model of the specified AR class.
     * @return BlogPostComment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function __construct($scenario = 'insert')
    {
        $this->type_of_comment = self::TYPE_OF_COMMENT;
        parent::__construct($scenario);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array_merge(parent::relations(), [
            'child_items' => [self::HAS_MANY, self::class, 'parent_id'],
            'material' => [self::BELONGS_TO, BlogPost::class, 'material_id'],
        ]);
    }
}
