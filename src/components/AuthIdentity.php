<?php

namespace app\components;

use app\modules\user\models\User;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class AuthIdentity implements IdentityInterface
{
    private int $id;

    /**
     * @param int|string $id
     * @return self|null
     */
    public static function findIdentity($id): ?self
    {
        $user = User::findOne($id);
        if ($user && empty($user->confirm)) {
            return new self($user->id);
        }
        return null;
    }

    /**
     * @param mixed $token
     * @param mixed|null $type
     * @return self|null
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return '';
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return true;
    }
}
