<?php

declare(strict_types=1);

namespace app\modules\file\forms\admin;

use Override;
use yii\base\Model;

final class DirectoryForm extends Model
{
    public string $name = '';

    #[Override]
    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '|^[\w-]+$|i'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'name' => 'Директория',
        ];
    }
}
