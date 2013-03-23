<?php

class ConfigModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'config.components.*',
            'config.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Настройки и шаблоны';
    }

    public function getName()
    {
        return 'Параметры';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Параметры', 'url'=>array('/config/configAdmin/index'), 'icon'=>'settings.png'),
        );
    }
}
