<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 */
class PostTag extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'blog_post_tags';
    }

    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
