<?php

class UserModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.user.components.*',
            'application.modules.user.models.*',
        ]);
    }

    public static function system()
    {
        return true;
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

    public function install()
    {
        Yii::app()->config->add([
            [
                'param' => 'USER.REGISTER_COMMIT',
                'label' => 'Требовать подтверждение регистрации',
                'value' => '1',
                'type' => 'checkbox',
                'default' => '1',
            ],
        ]);

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete([
            'USER.REGISTER_COMMIT',
        ]);

        return parent::uninstall();
    }
}
