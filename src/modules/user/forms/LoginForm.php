<?php

namespace app\modules\user\forms;

use app\components\AuthIdentity;
use app\modules\user\models\User;
use yii\base\Model;
use yii\web\User as WebUser;

class LoginForm extends Model
{
    public string $username = '';
    public string $password = '';
    public string $rememberMe = '1';

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'authenticate'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'rememberMe' => 'Запомнить меня',
            'username' => 'Логин или Email',
            'password' => 'Пароль',
        ];
    }

    public function authenticate(): void
    {
        if ($this->hasErrors()) {
            return;
        }

        if (!$this->loadIdentity($this->username, $this->password)) {
            $this->addError('password', 'Некорректное имя пользователя или пароль.');
        }
    }

    public function login(WebUser $webUser): bool
    {
        $identity = $this->loadIdentity($this->username, $this->password);

        if ($identity !== null) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            $webUser->login($identity, $duration);
            return true;
        }

        return false;
    }

    private function loadIdentity(string $username, string $password): ?AuthIdentity
    {
        /** @var User $user */
        $user = User::findBySql('SELECT * FROM users WHERE LOWER(username) = :name OR LOWER(email) = :name', [
            ':name' => strtolower($username),
        ])->one();

        if ($user === null) {
            return null;
        }

        if ($user->confirm) {
            return null;
        }

        if (!$user->validatePassword($password)) {
            return null;
        }

        return new AuthIdentity($user->id);
    }
}
