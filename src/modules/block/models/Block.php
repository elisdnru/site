<?php

declare(strict_types=1);

namespace app\modules\block\models;

use app\components\AliasValidator;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $alias
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
            [['alias', 'title'], 'required'],
            [['alias', 'title'], 'string', 'max' => 255],
            ['alias', AliasValidator::class],
            ['alias', 'unique', 'message' => 'Такой {attribute} уже используется'],
            [['text', 'short'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'alias' => 'Псевдоним',
            'title' => 'Наименование',
            'text' => 'Содержимое',
        ];
    }
}
