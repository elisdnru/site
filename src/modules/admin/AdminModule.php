<?php

class AdminModule extends DWebModule
{
    public function getName()
    {
        return 'Панель управления';
    }

    public static function rules()
    {
        return [
            'admin/clearCache' => 'admin/default/clearCache',
            'admin' => 'admin/default/index',
        ];
    }
}
