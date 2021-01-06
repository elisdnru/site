<?php

namespace app\modules\user\forms;

use yii\base\Model;

class RemindForm extends Model
{
    public $email;

    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Введите Email',
        ];
    }
}
