<?php

Yii::import('application.modules.ulogin.components.UloginUserIdentity');

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

    public function rules()
    {
        return [
            ['identity,network,token', 'required'],
            ['email', 'email'],
            ['identity,network,email', 'length', 'max' => 255],
            ['lastname, name, photo', 'length', 'max' => 255],
        ];
    }

    public function attributeLabels()
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

    public function getAuthData()
    {
        if ($authData = json_decode(file_get_contents('http://ulogin.ru/token.php?token=' . $this->token . '&host=' . $_SERVER['HTTP_HOST']), true)) {
            $this->setAttributes($authData);
            $this->name = $authData['first_name'];
            $this->lastname = $authData['last_name'];
            $this->photo = $authData['photo'];
        }
    }

    public function login()
    {
        $identity = new UloginUserIdentity('', '');
        if ($identity->authenticate($this)) {
            $duration = 3600 * 24 * 30;
            Yii::app()->user->login($identity, $duration);
            return true;
        }
        return false;
    }

    public function attributeNames()
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
}
