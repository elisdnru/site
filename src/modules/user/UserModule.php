<?php

namespace app\modules\user;

use DWebModule;

class UserModule extends DWebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.user.components.*',
            'application.modules.user.models.*',
        ]);
    }

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
            ['label' => 'Пользователи', 'url' => ['/user/userAdmin/index'], 'icon' => 'users.png'],
            ['label' => 'Добавить пользователя', 'url' => ['/user/userAdmin/create'], 'icon' => 'add_user.png'],
        ];
    }

    public static function rules()
    {
        return [
            '<action:login|logout|relogin|registration|remind|confirm>' => 'user/default/<action>',
            'users/captcha' => 'user/default/captcha',
            'users/profile' => 'user/profile/index',
            'users/profile/view' => 'user/profile/view',
            'users' => 'user/users/index',
            'users/self' => 'user/users/self',
            'users/show/<username:[\w\d_-]+>' => 'user/users/show',
        ];
    }
}
