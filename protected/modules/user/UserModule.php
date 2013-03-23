<?php

class UserModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'user.components.*',
            'user.models.*',
        ));
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
        return array(
            array('label'=>'Пользователи', 'url'=>array('/user/userAdmin/index'), 'icon'=>'users.png'),
            array('label'=>'Добавить пользователя', 'url'=>array('/user/userAdmin/create'), 'icon'=>'add_user.png'),
        );
    }

    public static function rules()
    {
        return array(
            '<action:login|logout|relogin|registration|remind|confirm>'=>'user/default/<action>',
            'users/captcha'=>'user/default/captcha',
            'users/profile'=>'user/profile/index',
            'users/profile/view'=>'user/profile/view',
            'users'=>'user/users/index',
            'users/self'=>'user/users/self',
            'users/show/<username:[\w\d_-]+>'=>'user/users/show',
        );
    }
}
