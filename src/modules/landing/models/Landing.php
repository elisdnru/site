<?php

declare(strict_types=1);

namespace app\modules\landing\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\components\ForceActiveRecordErrors;
use Override;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $text
 * @property int|null $parent_id
 * @property bool|int $system
 *
 * @property Landing[] $children
 *
 * @mixin CategoryTreeBehavior
 */
final class Landing extends ActiveRecord
{
    use ForceActiveRecordErrors;

    public int $indent = 0;

    #[Override]
    public static function tableName(): string
    {
        return 'landings';
    }

    #[Override]
    public static function find(): LandingQuery
    {
        return new LandingQuery(self::class);
    }

    /**
     * @psalm-api
     */
    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])
            ->alias('children')
            ->orderBy(['children.title' => SORT_ASC]);
    }

    /**
     * @psalm-api
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'URL транслитом',
            'title' => 'Заголовок',
            'system' => 'Системный',
            'text' => 'Текст',
            'parent_id' => 'Родительский лендинг',
        ];
    }

    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'parentAttribute' => 'parent_id',
                'parentRelation' => 'parent',
            ],
        ];
    }

    #[Override]
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            $this->delChildLandings();
            return true;
        }
        return false;
    }

    private function delChildLandings(): void
    {
        foreach ($this->children as $child) {
            $child->delete();
        }
    }
}
