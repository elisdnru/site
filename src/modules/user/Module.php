<?php

namespace app\modules\user;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\admin\AdminDashboardItem;
use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

class Module extends Base implements AdminDashboardItem, RoutesProvider, AdminMenuProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function adminGroup(): string
    {
        return 'Пользователи';
    }

    public function adminName(): string
    {
        return 'Пользователи';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Пользователи', 'url' => ['/user/admin/user/index'], 'icon' => 'users.png'],
        ];
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
