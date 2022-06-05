<?php

declare(strict_types=1);

namespace app\components\category\models;

use app\components\AliasValidator;
use app\components\category\behaviors\CategoryBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $sort
 * @property string $alias
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

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

    public function rules(): array
    {
        return self::staticRules();
    }

    public static function staticRules(): array
    {
        return [
            [['alias', 'title'], 'required'],
            ['alias', AliasValidator::class],
            ['sort', 'integer'],
            [['alias', 'title', 'meta_title'], 'string', 'max' => 255],
            [['text', 'meta_description'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return self::staticAttributeLabels();
    }

    public static function staticAttributeLabels(): array
    {
        return [
            'id' => 'ID',
            'sort' => 'Позиция',
            'alias' => 'URL транслитом',
            'title' => 'Наименование',
            'text' => 'Текст',
            'meta_title' => 'Заголовок окна',
            'meta_description' => 'Описание',
        ];
    }

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
            $this->cachedUrl = Url::to([$this->urlRoute, 'category' => $this->alias]);
        }

        return $this->cachedUrl;
    }
}
