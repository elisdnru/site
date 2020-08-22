<?php

namespace app\modules\block\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $text
 */
class Block extends ActiveRecord
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
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
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
