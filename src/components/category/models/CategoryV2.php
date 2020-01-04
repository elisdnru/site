<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryBehaviorV2;
use app\components\Transliterator;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property string $id
 * @property string $sort
 * @property string $alias
 * @property string $title
 * @property string $text
 * @property string $pagetitle
 * @property string $description
 *
 * @mixin CategoryBehaviorV2
 */
abstract class CategoryV2 extends ActiveRecord
{
    public $urlRoute = '';

    public static function find(): CategoryQueryV2
    {
        return new CategoryQueryV2(static::class);
    }

    public function rules(): array
    {
        return self::staticRules();
    }

    public static function staticRules(): array
    {
        return [
            [['alias', 'title'], 'required'],
            ['alias', 'match', 'pattern' => '#^[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['sort', 'integer'],
            [['alias', 'title', 'pagetitle'], 'string', 'max' => 255],
            [['text', 'description'], 'string'],
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
            'pagetitle' => 'Заголовок окна',
            'description' => 'Описание',
        ];
    }

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryBehaviorV2::class,
                'requestPathAttribute' => 'category',
            ],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if (!$this->alias) {
            $this->alias = Transliterator::slug($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->description) {
            $this->description = mb_substr(strip_tags($this->text), 0, 255, 'UTF-8');
        }
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to([$this->urlRoute, 'category' => $this->alias]);
        }

        return $this->cachedUrl;
    }
}
