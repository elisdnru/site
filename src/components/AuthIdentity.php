<?php

declare(strict_types=1);

namespace app\components;

use app\modules\user\models\User;
use Override;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

final readonly class AuthIdentity implements IdentityInterface
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param int|string $id
     */
    #[Override]
    public static function findIdentity($id): ?self
    {
        $user = User::findOne(['id' => (int)$id]);

        if ($user === null) {
            return null;
        }

        if (!empty($user->confirm)) {
            return null;
        }

        return new self($user->id);
    }

    /**
     * @param mixed $token
     * @param mixed|null $type
     * @throws NotSupportedException
     */
    #[Override]
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    #[Override]
    public function getId(): int
    {
        return $this->id;
    }

    #[Override]
    public function getAuthKey(): string
    {
        return '';
    }

    /**
     * @param string $authKey
     */
    #[Override]
    public function validateAuthKey($authKey): bool
    {
        return true;
    }
}
