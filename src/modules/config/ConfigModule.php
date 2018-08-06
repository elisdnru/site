<?php

class ConfigModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.config.components.*',
            'application.modules.config.models.*',
        ]);
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
        return [
            ['label' => 'Параметры', 'url' => ['/config/configAdmin/index'], 'icon' => 'settings.png'],
        ];
    }
}
