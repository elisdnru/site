<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\modules\user\components\CurrentPasswordValidator;
use app\modules\user\models\User;
use Override;
use yii\base\Model;

final class PasswordForm extends Model
{
    public int $id = 0;
    public string $current = '';
    public string $password = '';
    public string $confirm = '';

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);

        $this->id = $user->id;
    }

    #[Override]
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
                'idAttribute' => 'id',
                'validateMethod' => 'validatePassword',
                'emptyMessage' => 'Введите текущий пароль.',
                'notValidMessage' => 'Неверный текущий пароль.',
            ],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'current' => 'Текущий пароль',
            'password' => 'Новый пароль',
            'confirm' => 'Подтверждение нового пароля',
        ];
    }
}
