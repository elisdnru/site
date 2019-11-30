<?php

namespace app\modules\user\forms;

use app\components\UserIdentity;
use app\modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules(): array
    {
        return [
            // username and password are required
            [['username', 'password'], 'required'],
            // rememberMe needs to be a boolean
            ['rememberMe', 'boolean'],
            // password needs to be authenticated
            ['password', 'authenticate'],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels(): array
    {
        return [
            'rememberMe' => 'Запомнить меня',
            'username' => 'Логин или Email',
            'password' => 'Пароль',
        ];
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate(): void
    {
        if ($this->hasErrors()) {
            return;
        }

        if (!$this->loadIdentity($this->username, $this->password)) {
            $this->addError('password', 'Некорректное имя пользователя или пароль.');
        }
    }

    public function login(): bool
    {
        $identity = $this->loadIdentity($this->username, $this->password);

        if ($identity !== null) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::$app->user->login($identity, $duration);
            return true;
        }

        return false;
    }

    private function loadIdentity($username, $password): ?UserIdentity
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

        return new UserIdentity($user->id);
    }
}
