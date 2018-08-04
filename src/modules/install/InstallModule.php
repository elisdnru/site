<?php

class InstallModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Система';
    }

    public function getName()
    {
        return 'Установка';
    }

    public static function rules()
    {
        return array(
            'install'=>'install/default/index',
            'install/<action:\w+>'=>'install/default/<action>',
        );
    }
}
