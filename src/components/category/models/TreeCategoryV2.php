<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryTreeBehaviorV2;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * @property string $parent_id
 *
 * @mixin CategoryTreeBehaviorV2
 */
abstract class TreeCategoryV2 extends CategoryV2
{
    public $indent = 0;

    public static function find(): TreeCategoryQueryV2
    {
        return new TreeCategoryQueryV2(static::class);
    }

    public function rules(): array
    {
        return array_merge(self::staticRules(), [
            ['parent_id', 'exist', 'attributeName' => 'id'],
        ]);
    }

    public function attributeLabels(): array
    {
        return array_merge(self::staticAttributeLabels(), [
            'parent_id' => 'Родительский пункт',
        ]);
    }

    public function behaviors(): array
    {
        return array_replace(parent::behaviors(), [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehaviorV2::class,
            ],
        ]);
    }

    /**
     * @return CategoryQueryV2|ActiveQuery
     */
    public function getParent(): CategoryQueryV2
    {
        return $this->hasOne(static::class, ['id' => 'parent_id']);
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to([$this->urlRoute, 'category' => $this->getPath()]);
        }

        return $this->cachedUrl;
    }
}
