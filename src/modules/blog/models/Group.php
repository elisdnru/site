<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\category\behaviors\CategoryBehavior;
use app\components\ForceActiveRecordErrors;
use Override;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 *
 * @mixin CategoryBehavior
 */
final class Group extends ActiveRecord
{
    use ForceActiveRecordErrors;

    #[Override]
    public static function tableName(): string
    {
        return 'blog_post_groups';
    }

    #[Override]
    public static function find(): GroupQuery
    {
        return new GroupQuery(self::class);
    }

    public function getPostsCount(): int
    {
        return (int)Post::find()->andWhere(['group_id' => $this->id])->count();
    }

    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryBehavior::class,
            ],
        ];
    }
}
