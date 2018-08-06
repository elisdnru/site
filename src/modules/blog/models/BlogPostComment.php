<?php

Yii::import('application.modules.blog.models.*');
Yii::import('application.modules.comment.models.*');
DUrlRulesHelper::import('blog');

class BlogPostComment extends Comment
{
    const TYPE_OF_COMMENT = 'BlogPost';

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
            'child_items' => [self::HAS_MANY, self::TYPE_OF_COMMENT . 'Comment', 'parent_id'],
            'material' => [self::BELONGS_TO, self::TYPE_OF_COMMENT, 'material_id'],
        ]);
    }
}
