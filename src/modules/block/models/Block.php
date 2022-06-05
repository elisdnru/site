<?php

declare(strict_types=1);

namespace app\modules\block\models;

use app\components\SlugValidator;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $text
 */
final class Block extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'blocks';
    }

    public function rules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            [['slug', 'title'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'message' => 'Такой {attribute} уже используется'],
            [['text', 'short'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'Псевдоним',
            'title' => 'Наименование',
            'text' => 'Содержимое',
        ];
    }
}
