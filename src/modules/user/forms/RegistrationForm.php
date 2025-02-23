<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\modules\user\components\UsernameValidator;
use app\modules\user\models\User;
use Override;
use yii\base\Model;

final class RegistrationForm extends Model
{
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $confirm = '';
    public string $lastname = '';
    public string $firstname = '';
    public string $test1 = '';
    public string $test2 = '';

    #[Override]
    public function rules(): array
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 255],
            ['username', UsernameValidator::class],
            ['username', 'unique', 'targetClass' => User::class],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],

            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255, 'tooShort' => 'Пароль должен быть не короче 6 символов.'],

            ['confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],

            [['lastname', 'firstname'], 'required'],
            [['lastname', 'firstname'], 'string', 'max' => 255],

            ['test1', 'required'],
            ['test1', 'captcha', 'captchaAction' => '/user/registration/captcha1'],

            ['test2', 'required'],
            ['test2', 'captcha', 'captchaAction' => '/user/registration/captcha2'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Новый пароль',
            'confirm' => 'Подтверждение пароля',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'test' => 'Решите примеры',
            'test1' => 'Код 1',
            'test2' => 'Код 2',
        ];
    }
}
