<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DWebModule extends CWebModule
{
    public static function system()
    {
        return false;
    }

    public function getGroup()
    {
        return 'Почее';
    }

    public function getAllow()
    {
        return Yii::app()->user->checkAccess($this->getId());
    }

    public static function adminMenu()
    {
        return [];
    }

    public static function notifications()
    {
        return [];
    }

    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }
}
