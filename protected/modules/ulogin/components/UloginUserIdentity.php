<?php

Yii::import('user.models.*');

class UloginUserIdentity extends CUserIdentity
{
    private $id;
    private $isAuthenticated = false;

    public function authenticate($uloginModel = null)
    {
        $user = User::model()->find(array(
            'condition' => 'identity=:identity AND network=:network',
            'params' => array(
                ':identity' => $uloginModel->identity,
                ':network' => $uloginModel->network,
            )
        ));

        if (!$user)
        {
            $user = User::model()->find(array(
                'condition' => 'email=:email',
                'params' => array(
                    ':email' => $uloginModel->email,
                )
            ));
            if ($user)
                return false;
        }

        if ($user)
        {
            $this->id = $user->id;
            $this->username = $user->username;
            $this->isAuthenticated = true;
        }
        else
        {
            $user = new User('ulogin');

            $user->username = $uloginModel->identity ? $uloginModel->network . '_' . array_pop(explode('/',  trim($uloginModel->identity, '/'))) : 'user_' . time();
            $user->identity = $uloginModel->identity;
            $user->network = $uloginModel->network;
            $user->email = $uloginModel->email;
            $user->new_password = microtime();
            $user->new_confirm = $user->new_password;
            $user->role = Access::ROLE_USER;
            $user->lastname = $uloginModel->lastname;
            $user->name = $uloginModel->name;
            $user->avatar = !preg_match('@https?:\/\/ulogin\.ru\/img\/photo\.png@', $uloginModel->photo) ? $uloginModel->photo : '';

            if ($user->save())
            {
                $this->id = $user->getPrimaryKey();
                $this->username = $user->username;
                $this->password = $user->new_password;
                $this->isAuthenticated = true;
            }
            else
                return false;
        }

        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }
}