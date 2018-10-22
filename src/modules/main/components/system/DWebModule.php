<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

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
