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
    /**
     * @return string the associated database table name
     */
    public static function tableName(): string
    {
        return 'blocks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['alias', 'title'], 'required'],
            [['alias', 'title'], 'string', 'max' => 255],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias', 'unique', 'message' => 'Такой {attribute} уже используется'],
            [['text', 'short'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
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
