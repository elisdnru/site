<?php

namespace app\modules\menu;

use DWebModule;

class MenuModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.menu.models.*',
        ]);
    }

    public function getGroup()
    {
        return 'Структура';
    }

    public function getName()
    {
        return 'Меню';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Пункты', 'url' => ['/menu/menuAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить пункт', 'url' => ['/menu/menuAdmin/create'], 'icon' => 'add.png'],
        ];
    }
}
