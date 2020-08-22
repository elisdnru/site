<?php

namespace app\modules\blog\forms;

use yii\base\Model;

/**
 * @property integer $id
 * @property string $title
 */
class GroupForm extends Model
{
    public ?string $title = null;

    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование группы',
        ];
    }
}
