<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = User::model()->find('LOWER(username)=:name OR LOWER(email)=:name', [':name' => strtolower($this->name)]);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif ($user->confirm) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } elseif (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->getPrimaryKey();
            $this->username = $user->username;
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}
