<?php

namespace app\modules\user\forms;

use app\modules\user\components\UsernameValidator;
use app\modules\user\models\User;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm;
    public $lastname;
    public $firstname;
    public $test1;
    public $test2;

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
