<?php

namespace app\modules\user\forms;

use app\components\validators\CaptchaValidator;
use app\modules\user\models\User;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm;
    public $lastname;
    public $name;
    public $verifyCode;

    public function rules(): array
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 255],
            [
                'username',
                'match',
                'pattern' => '#^[a-zA-Z0-9_\.-]+$#',
                'message' => 'Логин содержит запрещённые символы',
            ],
            ['username', 'unique', 'targetClass' => User::class],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],

            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255],

            ['confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],

            [['lastname', 'name'], 'required'],
            [['lastname', 'name'], 'string', 'max' => 255],

            ['verifyCode', 'required'],

            ['verifyCode', CaptchaValidator::class, 'captchaAction' => '/user/registration/captcha'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Новый пароль',
            'confirm' => 'Подтверждение пароля',
            'name' => 'Имя',
            'lastname' => 'Фамилия',
            'verifyCode' => 'Проверочный код',
        ];
    }
}