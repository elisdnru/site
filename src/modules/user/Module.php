<?php

namespace app\modules\user;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;

class Module extends Base implements UrlProvider
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
            ['label' => 'Добавить пользователя', 'url' => ['/user/admin/user/create'], 'icon' => 'add_user.png'],
        ];
    }

    public static function rules(): array
    {
        return [
            '<action:login|logout|relogin|remind>' => 'user/default/<action>',
            'registration' => 'user/registration/request',
            'registration/confirm' => 'user/registration/confirm',
            'registration/captcha' => 'user/registration/captcha',
            'profile' => 'user/profile/view',
            'profile/edit' => 'user/profile/edit',
        ];
    }

    public static function rulesPriority(): int
    {
        return 99;
    }
}
