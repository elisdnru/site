<?php

namespace app\modules\blog\models;

use app\modules\comment\models\Comment as BaseComment;

class Comment extends BaseComment
{
    const TYPE_OF_COMMENT = Post::class;

    public function __construct($scenario = 'insert')
    {
        $this->type_of_comment = self::TYPE_OF_COMMENT;
        parent::__construct($scenario);
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        return array_merge(parent::relations(), [
            'child_items' => [self::HAS_MANY, self::class, 'parent_id'],
            'material' => [self::BELONGS_TO, Post::class, 'material_id'],
        ]);
    }
}
