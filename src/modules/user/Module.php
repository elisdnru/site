<?php

namespace app\modules\user;

use app\components\system\WebModule;

class Module extends WebModule
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
            '<action:login|logout|relogin|registration|remind|confirm>' => 'user/default/<action>',
            'users/captcha' => 'user/default/captcha',
            'profile' => 'user/profile/view',
            'profile/edit' => 'user/profile/edit',
        ];
    }
}
