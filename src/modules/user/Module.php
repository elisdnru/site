<?php

namespace app\modules\user;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup()
    {
        return 'Пользователи';
    }

    public function getName()
    {
        return 'Пользователи';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Пользователи', 'url' => ['/user/admin/user/index'], 'icon' => 'users.png'],
            ['label' => 'Добавить пользователя', 'url' => ['/user/admin/user/create'], 'icon' => 'add_user.png'],
        ];
    }

    public static function rules()
    {
        return [
            '<action:login|logout|relogin|registration|remind|confirm>' => 'user/default/<action>',
            'users/captcha' => 'user/default/captcha',
            'profile' => 'user/profile/view',
            'profile/edit' => 'user/profile/edit',
        ];
    }
}
