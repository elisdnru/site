<?php

declare(strict_types=1);

namespace app\modules\user;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\routes\RoutesProvider;
use Override;
use yii\base\Module as Base;

final class Module extends Base implements RoutesProvider, AdminMenuProvider
{
    #[Override]
    public function adminGroup(): string
    {
        return 'Пользователи';
    }

    #[Override]
    public function adminName(): string
    {
        return 'Пользователи';
    }

    #[Override]
    public static function adminMenu(): array
    {
        return [
            ['label' => 'Пользователи', 'url' => ['/user/admin/user/index'], 'icon' => 'users.png'],
        ];
    }

    #[Override]
    public static function routes(): array
    {
        return [
            '<action:login|logout>' => 'user/default/<action>',
            'registration' => 'user/registration/request',
            'registration/confirm' => 'user/registration/confirm',
            'registration/captcha<id:\d+>' => 'user/registration/captcha<id>',
            'remind' => 'user/remind/remind',
            'profile' => 'user/profile/view',
            'profile/edit' => 'user/profile/edit',
            'profile/password' => 'user/profile/password',
        ];
    }

    #[Override]
    public static function routesPriority(): int
    {
        return 99;
    }
}
