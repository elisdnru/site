<?php


class DWebModule extends CWebModule
{
    public function getGroup()
    {
        return 'Почее';
    }

    public static function adminMenu()
    {
        return [];
    }

    public static function notifications()
    {
        return [];
    }
}
