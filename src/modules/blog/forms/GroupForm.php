<?php

declare(strict_types=1);

namespace app\modules\blog\forms;

use yii\base\Model;

final class GroupForm extends Model
{
    public string $title = '';

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
            'title' => 'Наименование группы',
        ];
    }
}
