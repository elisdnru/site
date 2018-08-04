<?php

class ModuleModule extends DWebModule
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
        return 'Модули';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Модули', 'url'=>array('/module/moduleAdmin/index'), 'icon'=>'settings.png'),
        );
    }

    public static function rules()
    {
        return array(
            'admin'=>'admin/default/index',
            '<module:' . MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
            '<module:' . MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>'=>'<module>/<controller>/index',
            '<module:' . MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>'=>'<module>/<controller>/<action>',
        );
    }
}
