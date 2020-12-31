<?php

namespace app\modules\ulogin\models;

use app\components\AuthIdentity;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use yii\base\Model;
use yii\web\User as WebUser;

class ULoginModel extends Model
{
    public $identity;
    public $network;
    public $email;
    public $lastname;
    public $firstname;
    public $photo;
    public $token;
    public $error_type;
    public $error_message;

    public function rules(): array
    {
        return [
            [['identity', 'network', 'token'], 'required'],
            ['email', 'email'],
            [['identity', 'network', 'email'], 'string', 'max' => 255],
            [['lastname', 'firstname', 'photo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'network' => 'Сервис',
            'identity' => 'Идентификатор сервиса',
            'email' => 'eMail',
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'photo' => 'Фото',
        ];
    }

    public function loadAuthData(): void
    {
        if ($authData = json_decode(file_get_contents('http://ulogin.ru/token.php?token=' . $this->token . '&host=' . $_SERVER['HTTP_HOST']), true)) {
            $this->setAttributes($authData);
            $this->firstname = $authData['first_name'];
            $this->lastname = $authData['last_name'];
            $this->photo = $authData['photo'];
        }
    }

    public function login(WebUser $webUser): bool
    {
        $identity = $this->authenticate();
        if ($identity !== null) {
            $duration = 3600 * 24 * 30;
            $webUser->login($identity, $duration);
            return true;
        }
        return false;
    }

    public function attributeNames(): array
    {
        return [
            'identity',
            'network',
            'email',
            'lastname',
            'firstname',
            'photo',
            'token',
            'error_type',
            'error_message',
        ];
    }

    private function authenticate(): ?AuthIdentity
    {
        if ($user = User::findOne(['identity' => $this->identity, 'network' => $this->network])) {
            return new AuthIdentity($user->id);
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
        $user->password_hash = $user->hashPassword(microtime());
        $user->role = Access::ROLE_USER;
        $user->lastname = $this->lastname;
        $user->firstname = $this->firstname;
        $user->avatar = !preg_match('@https?:\/\/ulogin\.ru\/img\/photo\.png@', $this->photo) ? $this->photo : '';

        if (!$user->save()) {
            return null;
        }

        return new AuthIdentity($user->id);
    }
}
