<?php

declare(strict_types=1);

namespace app\modules\file\forms;

use yii\base\Model;

final class DirectoryForm extends Model
{
    public string $name = '';

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '|^[\w-]+$|i'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Директория',
        ];
    }
}
