<?php

declare(strict_types=1);

namespace app\components\category\models;

use app\components\category\behaviors\CategoryBehavior;
use app\components\SlugValidator;
use Override;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $sort
 * @property string $slug
 * @property string $title
 * @property string $text
 * @property string $meta_title
 * @property string $meta_description
 *
 * @mixin CategoryBehavior
 */
abstract class Category extends ActiveRecord
{
    public string $urlRoute = '';

    private ?string $cachedUrl = null;

    #[Override]
    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

    #[Override]
    public function rules(): array
    {
        return self::staticRules();
    }

    public static function staticRules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            ['slug', SlugValidator::class],
            ['sort', 'integer'],
            [['slug', 'title', 'meta_title'], 'string', 'max' => 255],
            [['text', 'meta_description'], 'string'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return self::staticAttributeLabels();
    }

    public static function staticAttributeLabels(): array
    {
        return [
            'id' => 'ID',
            'sort' => 'Позиция',
            'slug' => 'URL транслитом',
            'title' => 'Наименование',
            'text' => 'Текст',
            'meta_title' => 'Заголовок окна',
            'meta_description' => 'Описание',
        ];
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

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to([$this->urlRoute, 'category' => $this->slug]);
        }

        return $this->cachedUrl;
    }
}
