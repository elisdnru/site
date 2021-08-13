<?php

declare(strict_types=1);

namespace app\modules\file\forms;

use yii\base\Model;

final class RenameForm extends Model
{
    public string $name = '';

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
        ];
    }
}
