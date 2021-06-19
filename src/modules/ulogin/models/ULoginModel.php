<?php

declare(strict_types=1);

namespace app\modules\ulogin\models;

use app\components\AuthIdentity;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use yii\base\Model;
use yii\web\User as WebUser;

class ULoginModel extends Model
{
    public string $identity = '';
    public string $network = '';
    public string $token = '';
    public string $email = '';
    public string $firstname = '';
    public string $lastname = '';
    public ?string $photo = null;
    public ?string $error_type = null;
    public ?string $error_message = null;

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
        $body = file_get_contents('http://ulogin.ru/token.php?token=' . $this->token . '&host=elisdn.ru');
        /**
         * @psalm-var array{first_name: string, last_name: string, photo: string} $authData
         */
        $authData = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        $this->setAttributes($authData);
        $this->firstname = $authData['first_name'];
        $this->lastname = $authData['last_name'];
        $this->photo = $authData['photo'];
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

        if (User::findOne(['email' => $this->email])) {
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
        $user->avatar = ($this->photo && !preg_match('@https?:\/\/ulogin\.ru\/img\/photo\.png@', $this->photo))
            ? $this->photo
            : '';

        if (!$user->save()) {
            return null;
        }

        return new AuthIdentity($user->id);
    }
}
