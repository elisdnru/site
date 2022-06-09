<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\ForceActiveRecordErrors;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 */
final class PostTag extends ActiveRecord
{
    use ForceActiveRecordErrors;

    public static function tableName(): string
    {
        return 'blog_post_tags';
    }

    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
