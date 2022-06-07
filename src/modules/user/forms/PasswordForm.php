<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\modules\user\components\CurrentPasswordValidator;
use app\modules\user\models\User;
use yii\base\Model;

final class PasswordForm extends Model
{
    public int $id = 0;
    public string $current = '';
    public string $password = '';
    public string $confirm = '';

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);

        $this->id = $user->id;
    }

    public function rules(): array
    {
        return [
            [['current', 'password', 'confirm'], 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            [
                'confirm',
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают.',
            ],
            [
                'current',
                CurrentPasswordValidator::class,
                'className' => User::class,
                'validateMethod' => 'validatePassword',
                'emptyMessage' => 'Введите текущий пароль.',
                'notValidMessage' => 'Неверный текущий пароль.',
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'current' => 'Текущий пароль',
            'password' => 'Новый пароль',
            'confirm' => 'Подтверждение нового пароля',
        ];
    }
}
