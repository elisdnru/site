<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\ForceActiveRecordErrors;
use Override;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 */
final class PostTag extends ActiveRecord
{
    use ForceActiveRecordErrors;

    #[Override]
    public static function tableName(): string
    {
        return 'blog_post_tags';
    }

    /**
     * @psalm-api
     */
    public function getTag(): ActiveQueryInterface
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
