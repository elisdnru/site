<?php

declare(strict_types=1);

namespace app\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

final class Access
{
    public const CONTROL = 'permission_control';
    public const FULL = 'permission_full';
    public const ROLE_ADMIN = 'role_admin';
    public const ROLE_MANAGER = 'role_manager';
    public const ROLE_USER = 'role_user';

    public static function getRoles(): array
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public static function getRoleName(?string $role): string
    {
        switch ($role) {
            case self::ROLE_USER:
                return 'Пользователь';
            case self::ROLE_MANAGER:
                return 'Контент-менеджер';
            case self::ROLE_ADMIN:
                return 'Администратор';
        }
        return '';
    }
}
