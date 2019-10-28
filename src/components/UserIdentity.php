<?php

namespace app\components;

use app\modules\user\models\User;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class UserIdentity implements IdentityInterface
{
    private $id;

    public static function findIdentity($id): ?self
    {
        $user = User::findOne($id);
        if ($user && empty($user->confirm)) {
            return new self($user->id);
        }
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return '';
    }

    public function validateAuthKey($authKey): bool
    {
        return true;
    }
}
