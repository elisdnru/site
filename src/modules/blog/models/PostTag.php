<?php

namespace app\modules\blog\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * @property integer $id
 * @property integer $post_id
 * @property integer $tag_id
 */
class PostTag extends CActiveRecord
{
    /**
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'blog_post_tags';
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'tag' => [self::BELONGS_TO, Tag::class, 'tag_id'],
        ];
    }
}
