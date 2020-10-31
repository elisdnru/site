<?php

namespace app\modules\user;

use app\components\module\Module as Base;
use app\components\module\routes\RoutesProvider;

class Module extends Base implements RoutesProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Пользователи';
    }

    public function getName(): string
    {
        return 'Пользователи';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Пользователи', 'url' => ['/user/admin/user/index'], 'icon' => 'users.png'],
        ];
    }

    public static function notifications(): array
    {
        return [];
    }

    public static function routes(): array
    {
        return [
            '<action:login|logout|relogin>' => 'user/default/<action>',
            'registration' => 'user/registration/request',
            'registration/confirm' => 'user/registration/confirm',
            'registration/captcha<id:\d+>' => 'user/registration/captcha<id>',
            'remind' => 'user/remind/remind',
            'profile' => 'user/profile/view',
            'profile/edit' => 'user/profile/edit',
            'profile/password' => 'user/profile/password',
        ];
    }

    public static function routesPriority(): int
    {
        return 99;
    }
}
