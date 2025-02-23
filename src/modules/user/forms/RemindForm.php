<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use Override;
use yii\base\Model;

final class RemindForm extends Model
{
    public string $email = '';

    #[Override]
    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'email' => 'Введите Email',
        ];
    }
}
