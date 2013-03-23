<?php

class Access extends CModel
{
    const ROLE_ADMIN = 'role_admin';
    const ROLE_MANAGER = 'role_manager';
    const ROLE_CONTROL = 'role_control';
    const ROLE_USER = 'role_user';

    public function attributeNames()
    {
        return array();
    }

    public static function getRoles()
    {
        return CHtml::listData(Yii::app()->authManager->roles,'name','description');
    }

    public static function getRoleName($role)
    {
        switch ($role)
        {
            case self::ROLE_USER: return 'Пользователь'; break;
            case self::ROLE_MANAGER: return 'Контент-менеджер'; break;
            case self::ROLE_ADMIN: return 'Администратор'; break;
        };
        return false;
    }
}