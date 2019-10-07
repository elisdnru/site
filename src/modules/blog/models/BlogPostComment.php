<?php

namespace app\modules\blog\models;

use app\components\module\UrlRulesHelper;
use app\modules\comment\models\Comment;

UrlRulesHelper::import('blog');

class BlogPostComment extends Comment
{
    const TYPE_OF_COMMENT = BlogPost::class;

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
