<?php

namespace app\modules\user\forms;

use app\modules\user\components\UserIdentity;
use CFormModel;
use Yii;

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    private $identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules(): array
    {
        return [
            // username and password are required
            ['username, password', 'required'],
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
        if (!$this->hasErrors()) {
            $this->identity = new UserIdentity($this->username, $this->password);
            if (!$this->identity->authenticate()) {
                $this->addError('password', 'Некорректное имя пользователя или пароль.');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login(): bool
    {
        if ($this->identity === null) {
            $this->identity = new UserIdentity($this->username, $this->password);
            $this->identity->authenticate();
        }

        if ($this->identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->identity, $duration);
            return true;
        }

        return false;
    }
}
