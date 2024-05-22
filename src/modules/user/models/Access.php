<?php

declare(strict_types=1);

namespace app\modules\user\models;

use BadMethodCallException;
use Yii;
use yii\helpers\ArrayHelper;

final class Access
{
    public const string CONTROL = 'permission_control';
    public const string FULL = 'permission_full';
    public const string ROLE_ADMIN = 'role_admin';
    public const string ROLE_MANAGER = 'role_manager';
    public const string ROLE_USER = 'role_user';

    public static function getRoles(): array
    {
        $authManager = Yii::$app->authManager;

        if ($authManager === null) {
            throw new BadMethodCallException('Auth manager is not set.');
        }

        return ArrayHelper::map($authManager->getRoles(), 'name', 'description');
    }

    public static function getRoleName(?string $role): string
    {
        return match ($role) {
            self::ROLE_USER => 'Пользователь',
            self::ROLE_MANAGER => 'Контент-менеджер',
            self::ROLE_ADMIN => 'Администратор',
            default => '',
        };
    }
}
