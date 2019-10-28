<?php

namespace app\modules\ulogin\models;

use app\components\UserIdentity;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use CModel;
use Yii;

class UloginModel extends CModel
{

    public $identity;
    public $network;
    public $email;
    public $lastname;
    public $name;
    public $photo;
    public $token;
    public $error_type;
    public $error_message;

    public function rules(): array
    {
        return [
            ['identity,network,token', 'required'],
            ['email', 'email'],
            ['identity,network,email', 'length', 'max' => 255],
            ['lastname, name, photo', 'length', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'network' => 'Сервис',
            'identity' => 'Идентификатор сервиса',
            'email' => 'eMail',
            'lastname' => 'Фамилия',
            'name' => 'Имя',
            'photo' => 'Фото',
        ];
    }

    public function getAuthData(): void
    {
        if ($authData = json_decode(file_get_contents('http://ulogin.ru/token.php?token=' . $this->token . '&host=' . $_SERVER['HTTP_HOST']), true)) {
            $this->setAttributes($authData);
            $this->name = $authData['first_name'];
            $this->lastname = $authData['last_name'];
            $this->photo = $authData['photo'];
        }
    }

    public function login(): bool
    {
        $identity = $this->authenticate();
        if ($identity !== null) {
            $duration = 3600 * 24 * 30;
            Yii::$app->user->login($identity, $duration);
            return true;
        }
        return false;
    }

    public function attributeNames(): array
    {
        return [
            'identity'
            , 'network'
            , 'email'
            , 'lastname'
            , 'name'
            , 'photo'
            , 'token'
            , 'error_type'
            , 'error_message'
        ];
    }

    private function authenticate(): ?UserIdentity
    {
        if ($user = User::findOne(['identity' => $this->identity, 'network' => $this->network])) {
            return new UserIdentity($user->id);
        }

        if ($user = User::findOne(['email' => $this->email])) {
            return null;
        }

        $user = new User();

        $identity = explode('/', trim($this->identity, '/'));
        $user->username = $this->identity ? $this->network . '_' . array_pop($identity) : 'user_' . time();
        $user->identity = $this->identity;
        $user->network = $this->network;
        $user->email = $this->email;
        $user->new_password = microtime();
        $user->new_confirm = $user->new_password;
        $user->role = Access::ROLE_USER;
        $user->lastname = $this->lastname;
        $user->name = $this->name;
        $user->avatar = !preg_match('@https?:\/\/ulogin\.ru\/img\/photo\.png@', $this->photo) ? $this->photo : '';

        if (!$user->save()) {
            return null;
        }

        return new UserIdentity($user->id);
    }
}
