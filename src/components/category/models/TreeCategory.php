<?php

declare(strict_types=1);

namespace app\components\category\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use Override;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * @property string $parent_id
 *
 * @mixin CategoryTreeBehavior
 */
abstract class TreeCategory extends Category
{
    public int $indent = 0;

    private ?string $cachedUrl = null;

    #[Override]
    public static function find(): TreeCategoryQuery
    {
        return new TreeCategoryQuery(static::class);
    }

    #[Override]
    public function rules(): array
    {
        return array_merge(self::staticRules(), [
            ['parent_id', 'exist', 'targetClass' => static::class, 'targetAttribute' => 'id'],
        ]);
    }

    #[Override]
    public function attributeLabels(): array
    {
        return array_merge(self::staticAttributeLabels(), [
            'parent_id' => 'Родительский пункт',
        ]);
    }

    #[Override]
    public function behaviors(): array
    {
        return array_replace(parent::behaviors(), [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehavior::class,
            ],
        ]);
    }

    /**
     * @psalm-api
     * @return ActiveQuery|CategoryQuery
     * @psalm-return CategoryQuery
     */
    public function getParent(): CategoryQuery
    {
        /** @var CategoryQuery */
        return $this->hasOne(static::class, ['id' => 'parent_id']);
    }

    /**
     * @psalm-api
     * @return ActiveQuery|CategoryQuery
     * @psalm-return CategoryQuery
     */
    public function getChildren(): CategoryQuery
    {
        /** @var CategoryQuery */
        return $this->hasMany(static::class, ['parent_id' => 'id'])
            ->alias('children')
            ->orderBy(['children.sort' => SORT_ASC, 'children.title' => SORT_ASC]);
    }

    #[Override]
    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to([$this->urlRoute, 'category' => $this->getPath()]);
        }

        return $this->cachedUrl;
    }
}
