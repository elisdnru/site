<?php

class AdminModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public function getName()
    {
        return 'Панель управления';
    }

    public static function rules()
    {
        return array(
            'admin/clearCache'=>'admin/default/clearCache',
            'admin'=>'admin/default/index',
        );
    }
}
