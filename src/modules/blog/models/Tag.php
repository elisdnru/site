<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\ForceActiveRecordErrors;
use Override;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $title
 * @property PostTag[] $postTags
 */
final class Tag extends ActiveRecord
{
    use ForceActiveRecordErrors;

    #[Override]
    public static function tableName(): string
    {
        return 'blog_tags';
    }

    public function getFrequency(): int
    {
        return (int)PostTag::find()->andWhere(['tag_id' => $this->id])->count();
    }

    /**
     * @psalm-api
     */
    public function getPostTags(): ActiveQuery
    {
        return $this->hasMany(PostTag::class, ['tag_id' => 'id']);
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Метка',
            'frequency' => 'Число записей',
        ];
    }

    #[Override]
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->postTags as $postTag) {
                $postTag->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array<int, string>
     */
    public static function getAssocList(): array
    {
        /** @var array<int, string> */
        return ArrayHelper::map(self::find()->orderBy(['title' => SORT_ASC])->asArray()->all(), 'id', 'title');
    }
}
